<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;port=3306;dbname=properta',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
    'on afterOpen' => function ($event) {
        // set 'Asia/Jakarta' timezone
        $event->sender->createCommand("SET time_zone='+07:00';")->execute();
    },
];
