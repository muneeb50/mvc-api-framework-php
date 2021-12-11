<?php
namespace app\core;

use app\models\UsersModel;

class Application
{
    public static string $ROOT_DIR;
    public static Application $app;

    public Database $db;
    public Session $session;

    public Router $router;
    public Request $request;
    public Response $response;

    public ?UsersModel $user;

    public function __construct($rootDir, array $config)
    {
        error_log('Initialize Application');
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);

        $this->db = new Database($config['db']);
        $this->session = new Session();
        $this->user = null;


        $userId = Application::$app->session->get('user');
        if ($userId) {
            $this->user = UsersModel::findOne(['id' => $userId]);
        }
    }

    public function isLoggedIn()
    {
        return !!self::$app->user;
    }

//    public function login(UserModel $user)
//    {
//        $this->user = $user;
//        $primaryKey = $user->primaryKey();
//        $value = $user->{$primaryKey};
//        Application::$app->session->set('user', $value);
//
//        return true;
//    }
//
//    public function logout()
//    {
//        $this->user = null;
//        self::$app->session->remove('user');
//    }

    public function run(){
        error_log('Application/run');
        echo $this->router->resolve();
    }
}