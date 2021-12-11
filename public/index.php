<?php
require_once __DIR__.'/../vendor/autoload.php';

use app\controllers\AuthController;
use app\controllers\WelcomeController;
use app\core\Application;

error_log('index.php');

$config = [
    'db' => [
        'dsn' => 'mysql:host=localhost;port=3306;dbname=mvc_api_framework_php',
        'user' => 'root',
        'password' => 'password'
    ]
];

$app = new Application(dirname(__DIR__), $config);

    /*
     * Callback Types
     *
     * 1. false == invalid route
     * 2. string == view
     * 3. functions/call_user_func == GET
     * 4. array == POST
     *
     * */

$app->router->get('/', function(){
    return 'Welcome to my app! Hello World';
});
$app->router->get('/home', 'Home');
$app->router->get('/terms-and-conditions', 'TermsAndConditions');

$app->router->get('/test', [WelcomeController::class, 'test']);
$app->router->get('/users', [WelcomeController::class, 'getUsers']);
$app->router->post('/register', [WelcomeController::class, 'registerUser']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/logout', [AuthController::class, 'logout']);

$app->run();