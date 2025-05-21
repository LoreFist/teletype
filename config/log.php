<?php

use codemix\streamlog\Target;

return [
    'traceLevel' => YII_DEBUG ? 3 : 0,
    'targets' => [
        [
            'class' => Target::class,
            'url' => 'php://stdout',
            'levels' => YII_DEBUG ? ['info', 'error', 'warning'] : ['error', 'warning'],
            'logVars' => [],
            'replaceNewline' => ' ¦ ',
            'exportInterval' => 1,
        ],
    ],
    'flushInterval' => 1,
];
