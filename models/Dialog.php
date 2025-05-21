<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property int $client_id
 * @property Message[] $messages
 */
class Dialog extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'dialogs';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [['client_id', 'required'], ['client_id', 'unique']];
    }

    /**
     * @return ActiveQuery
     */
    public function getMessages(): ActiveQuery
    {
        return $this->hasMany(Message::class, ['dialog_id' => 'id']);
    }
}