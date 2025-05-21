<?php

namespace app\commands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\Utils;
use yii\console\Controller;

class GenController extends Controller
{
    public int $count = 1000;

    public function options($actionID): array
    {
        return array_merge(
            parent::options($actionID),
            $actionID == 'index' ? ['count'] : []
        );
    }

    public function optionAliases(): array
    {
        return array_merge(parent::optionAliases(), [
            'c' => 'count',
        ]);
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function actionIndex(): void
    {
        $start = microtime(true);
        for ($i = 1; $i <= $this->count; $i++) {
            $ts = microtime(true);
            $client = new Client([
                'base_uri' => 'http://localhost',
            ]);

            $response = $client->request('POST', '/v1/message', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'external_message_id' => rand(1, 100),
                    'external_client_id' => rand(1, 100),
                    'client_phone' => '+79999999999',
                    'message_text' => 'test',
                ],
            ]);
        }

        $rpc = round($this->count / (microtime(true) - $start));
        dump("RPC=$rpc");
    }

    public function actionAsync()
    {
        $start = microtime(true);

        $client = new Client([
            'base_uri' => 'http://localhost',
        ]);

        $promises = [];
        $timestamps = [];

        for ($i = 1; $i <= $this->count; $i++) {
            $timestamps[$i] = microtime(true);
            $promises[$i] = $client->requestAsync('POST', '/v1/message', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'external_message_id' => rand(1, 100),
                    'external_client_id' => rand(1, 100),
                    'client_phone' => '+79999999999',
                    'message_text' => 'test',
                ],
            ]);
        }

        Utils::settle($promises)->wait();

        $rpc = round($this->count / (microtime(true) - $start));
        dump("RPC=$rpc");
    }
}
