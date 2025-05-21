<?php

return [
    [
        'prefix' => 'v1',
        'controller' => 'message',
        'only' => ['index'],
        'extraPatterns' => [
            'POST' => 'index',
        ],
        'pluralize' => false,
    ],
];
