<?php

namespace app\modules\api\controllers;

use yii\rest\Controller;

class MessageController extends Controller
{
    public function verbs(): array
    {
        return [
            'index' => ['POST'],
        ];
    }

    public function actionIndex(): array
    {
        return ['success' => true];
    }
}
