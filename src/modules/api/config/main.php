<?php

use yii\web\Response;

return [
    'components' => [
        'response' => [
            'format' => Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],
    ],
];
