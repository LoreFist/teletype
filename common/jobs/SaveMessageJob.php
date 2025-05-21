<?php

namespace app\common\jobs;

use app\models\Client;
use app\models\Dialog;
use app\models\Message;
use app\modules\api\forms\MessageForm;
use Throwable;
use yii\base\BaseObject;
use yii\db\Exception;
use yii\queue\RetryableJobInterface;

class SaveMessageJob extends BaseObject implements RetryableJobInterface
{
    public string $external_message_id;
    public string $external_client_id;
    public string $client_phone;
    public string $message_text;
    public int $send_at;

    const int TTR = 60;
    const int ATTEMPTS = 5;

    /**
     * @return int
     */
    public function getTtr(): int
    {
        return self::TTR;
    }

    /**
     * @param $attempt
     * @param $error
     * @return bool
     */
    public function canRetry($attempt, $error): bool
    {
        return $attempt < self::ATTEMPTS;
    }

    /**
     * @param $queue
     * @return void
     * @throws Throwable
     * @throws Exception
     */
    public function execute($queue): void
    {
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            $client = Client::findOne(['external_client_id' => $this->external_client_id]);

            if (!$client) {
                $client = new Client([
                    'external_client_id' => $this->external_client_id,
                    'phone' => $this->client_phone,
                ]);

                if (!$client->save()) {
                    throw new \RuntimeException('Failed to save client: ' . json_encode($client->getErrors()));
                }
            }

            $dialog = Dialog::findOne(['client_id' => $client->id]);

            if (!$dialog) {
                $dialog = new Dialog([
                    'client_id' => $client->id,
                ]);

                if (!$dialog->save()) {
                    throw new \RuntimeException('Failed to save dialog: ' . json_encode($dialog->getErrors()));
                }
            }

            $existingMessage = Message::findOne(['external_message_id' => $this->external_message_id]);

            if ($existingMessage) {
                \Yii::info("Duplicate message skipped: {$this->external_message_id}", __METHOD__);
                $transaction->rollBack();
                return;
            }

            $message = new Message([
                'dialog_id' => $dialog->id,
                'external_message_id' => $this->external_message_id,
                'message_text' => $this->message_text,
                'send_at' => $this->send_at,
            ]);

            if (!$message->save()) {
                throw new \RuntimeException('Failed to save message: ' . json_encode($message->getErrors()));
            }

            $transaction->commit();
        } catch (Throwable $e) {
            $transaction->rollBack();
            \Yii::error("Job failed: {$e->getMessage()}", __METHOD__);
            throw $e;
        }
    }
}
