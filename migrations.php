<?php


use app\core\Application;

require_once __DIR__.'/vendor/autoload.php';

$config = [
    'db' => [
        'dsn' => 'mysql:host=localhost;port=3306;dbname=mvc_api_framework_php',
        'user' => 'root',
        'password' => 'password'
    ]
];

$app = new Application(__DIR__, $config);

$app->db->applyMigrations();
