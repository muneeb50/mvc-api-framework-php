<?php


namespace app\core;


class BaseController
{
    public function render($view, $params = []){
        error_log('BaseController/render'." View: $view");

        return Application::$app->router->renderView($view, $params);
    }
}