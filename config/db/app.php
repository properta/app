<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=103.186.1.156;port=3306;dbname=properta_app',
    'username' => 'riuhkopi',
    'password' => 'Riuharifin88',
    'charset' => 'utf8',
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',
    'on afterOpen' => function ($event) {
        // set 'Asia/Jakarta' timezone
        $event->sender->createCommand("SET time_zone='+07:00';")->execute();
    },
];
