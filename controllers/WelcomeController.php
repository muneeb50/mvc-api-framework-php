<?php


namespace app\controllers;


use app\core\Application;
use app\core\BaseController;
use app\core\Request;

class WelcomeController extends BaseController
{

    public function test(){
        error_log('WelcomeController/test');

        return 'test WelcomeController successful!';
    }

    public function welcomePage(Request $request){
        $body = $request->getBody();
        return $this->render('Welcome', $body);
    }
}