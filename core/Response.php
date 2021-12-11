<?php


namespace app\core;


class Response
{
    public function __construct()
    {
        error_log('Initialize Response');
    }

    public function setStatusCode(int $statusCode){
        error_log('Response/setStatusCode'." statusCode: $statusCode");
        http_response_code($statusCode);
    }

    public function redirect($url)
    {
        header("Location: $url");
    }
}