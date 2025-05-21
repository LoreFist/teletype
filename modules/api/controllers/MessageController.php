<?php

namespace app\modules\api\controllers;

use app\modules\api\forms\MessageForm;
use yii\base\InvalidConfigException;
use yii\rest\Controller;

class MessageController extends Controller
{
    public function verbs(): array
    {
        return [
            'index' => ['POST'],
        ];
    }

    /**
     * @return false[]|true[]
     * @throws InvalidConfigException
     */
    public function actionIndex(): array
    {
        $form = new MessageForm();
        $form->load(\Yii::$app->request->post(), '');
        if (!$form->validate()) {
            \Yii::info('error: ' . json_encode($form->getErrors()));
            return ['success' => false];
        }
        $form->save();
        return ['success' => true];
    }
}
