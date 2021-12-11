<?php

namespace app\models;

use app\core\Application;
use app\core\DbModel;

class UsersModel extends DbModel
{
    public string $id = '';
    public string $fullName = '';
    public string $email = '';
    public string $username = '';
    public string $password = '';

    public function __construct(){
        parent::__construct();
//        $this->id = uniqid();
    }

    public static function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return ['fullName', 'username', 'email', 'password'];
    }

    public function save()
    {

//        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public static function className(): string
    {
        return UsersModel::class;
    }
}