<?php
namespace app\core;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        error_log('Initialize Router');

        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback){
        error_log('Router/get'." Path: $path");

        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback){
        error_log('Router/post'." Path: $path");

        $this->routes['post'][$path] = $callback;
    }

    public function resolve(){
        error_log('Router/resolve');

        //determine the current path and method
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $callback = $this->routes[$method][$path] ?? false;

        /*
         * Callback Types
         *
         * 1. false == invalid route
         * 2. string == view
         * 3. functions/call_user_func == GET
         * 4. array == POST
         *
         * */



        if ($callback === false){
            $this->response->setStatusCode(404);
            return "ROUTE NOT FOUND";
        }

        //if route is string like this '/terms-and-conditions' it means it's a view
        if (is_string($callback)){
            return $this->renderView($callback);
        }

        // post method
        if (is_array($callback)){
            // initialize object of Controller class
            $callback[0] = new $callback[0]();
        }

        //else return the route
        return call_user_func($callback, $this->request);
    }

    public function renderView($view, $params = []){
        error_log('Router/renderView'." View: $view, Params: $params");

        //layoutContent is view templates like header/footer
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
//        include_once Application::$ROOT_DIR."/views/$view.php";
    }

    protected function layoutContent()
    {
        error_log('Router/layoutContent');

        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/main.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params = []){
        error_log('Router/renderOnlyView'." View: $view, Params: $params");

        foreach ($params as $key => $value){
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}