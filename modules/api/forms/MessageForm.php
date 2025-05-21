<?php

namespace app\modules\api\forms;

use app\common\jobs\SaveMessageJob;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\Query;
use yii\queue\Queue;

class MessageForm extends Model
{
    public string $external_message_id;
    public string $external_client_id;
    public string $client_phone;
    public string $message_text;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['external_message_id', 'external_client_id', 'client_phone', 'message_text'], 'required'],
            ['external_message_id', 'string', 'max' => 36],
            ['external_client_id', 'string', 'max' => 36],
            ['client_phone', 'match', 'pattern' => '/^\+7\d{10}$/'],
            ['message_text', 'string', 'max' => 4096],
            ['external_message_id', 'checkUnique']
        ];
    }

    /**
     * @return bool
     */
    public function checkUnique(): bool
    {
        $query = (new Query())
            ->from('clients c')
            ->innerJoin('dialogs d', 'd.client_id = c.id')
            ->innerJoin('messages m', 'm.dialog_id = d.id')
            ->where([
                'c.external_client_id' => $this->external_client_id,
                'm.external_message_id' => $this->external_message_id,
            ])
            ->limit(1);

        if ($query->exists()) {
            $this->addError('external_message_id', 'Message already exists for this client');
            return false;
        }

        return true;
    }

    /**
     * @return void
     * @throws InvalidConfigException
     */
    public function save(): void
    {
        /** @var Queue $queue */
        $queue = \Yii::$app->get('queue');

        $queue->push(new SaveMessageJob([
            'external_message_id' => $this->external_message_id,
            'external_client_id' => $this->external_client_id,
            'client_phone' => $this->client_phone,
            'message_text' => $this->message_text,
            'send_at' => time(),
        ]));
    }
}