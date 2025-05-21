<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $dialog_id
 * @property string $external_message_id
 * @property string $message_text
 * @property int $send_at
 *
 * @property Dialog $dialog
 */
class Message extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'messages';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['external_message_id', 'message_text', 'send_at'], 'required'],
            ['external_message_id', 'string', 'max' => 36],
            ['external_message_id', 'unique'],
            ['message_text', 'string', 'max' => 4096],
            ['send_at', 'integer'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getDialog(): ActiveQuery
    {
        return $this->hasOne(Dialog::class, ['id' => 'dialog_id']);
    }

}