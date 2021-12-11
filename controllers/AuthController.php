<?php


namespace app\controllers;


use app\core\Application;
use app\core\BaseController;
use app\core\Request;
use app\models\UsersModel;

class AuthController extends BaseController
{

    public function login(Request $request){
        if (Application::$app->isLoggedIn()) return 'Already logged in';

        else if ($request->isPost()) {
            $userModel = new UsersModel();
            $userModel->loadData($request->getBody());

            $user = UsersModel::findOne(['email' => $userModel->email]);

            if (!$user) {
                return 'User does not exist with this email address';
            }
            if ($user->password !== $userModel->password) {
                return 'Password is incorrect';
            }

            $this->setApplicationUser($user);

            echo "logged in: " .Application::$app->user->id;
        }
    }

    public function logout(){
        $this->unsetApplicationUser();
        echo "logged out";
    }

    private function setApplicationUser(UsersModel $user)
    {
        if (!$user || !$user->id) return false;

        Application::$app->user = $user;
        Application::$app->session->set('user', $user->id);
        return true;
    }

    private function unsetApplicationUser()
    {
        Application::$app->user = null;
        Application::$app->session->remove('user');
    }
}