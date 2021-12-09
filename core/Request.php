<?php


namespace app\core;


class Request
{
    public function __construct()
    {
        error_log('Initialize Request');
    }

    public function getPath(){
        error_log('Request/getPath');

        //if REQUEST_URI does not exists it means we got the root '/' uri
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        //separate request parameters
        $position = strpos($path, '?');

        //if no parameters
        if ($position === false){
            return $path;
        }

        //else retrieve path
        return substr($path, 0, $position);
    }

    public function getMethod(){
        error_log('Request/getMethod');
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet()
    {
        return $this->getMethod() === 'get';
    }

    public function isPost()
    {
        return $this->getMethod() === 'post';
    }

    public function getBody(){
        error_log('Request/getBody');

        $body = [];

        if ($this->isGet()){
            foreach ($_GET as $key => $value){
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->isPost()){
            foreach ($_POST as $key => $value){
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}