<?php
namespace app\core;

class Application
{
    public static string $ROOT_DIR;
    public static Application $app;

    public Database $db;

    public Router $router;
    public Request $request;
    public Response $response;

    public function __construct($rootDir, array $config)
    {
        error_log('Initialize Application');
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);

        $this->db = new Database($config['db']);
    }

    public function run(){
        error_log('Application/run');
        echo $this->router->resolve();
    }
}