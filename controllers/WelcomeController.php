<?php


namespace app\controllers;

use app\core\BaseController;
use app\core\Request;
use app\core\Response;
use app\models\UsersModel;

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

    public function registerUser(Request $request)
    {
        $userModel = new UsersModel();
        if ($request->isPost()) {
            $userModel->loadData($request->getBody());
            $userModel->save();
        }
    }

    public function getUsers(Request $request)
    {
        $userModel = new UsersModel();
        if ($request->isGet()) {
            return json_encode($userModel->findAll($request->getBody()));
        }
    }
}