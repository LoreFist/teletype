<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $external_client_id
 * @property string $phone
 */
class Client extends ActiveRecord
{

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'clients';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['external_client_id', 'phone'], 'required'],
            ['external_client_id', 'string', 'max' => 36],
            ['external_client_id', 'unique'],
            ['phone', 'match', 'pattern' => '/^\+7\d{10}$/']
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getDialog(): ActiveQuery
    {
        return $this->hasOne(Dialog::class, ['client_id' => 'id']);
    }
}