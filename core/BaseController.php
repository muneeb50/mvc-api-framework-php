<?php


namespace app\core;


class BaseController
{
    public function render($view, $params = []){
        error_log('BaseController/render'." View: $view, Params: $params");

        return Application::$app->router->renderView($view, $params);
    }
}