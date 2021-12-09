<?php

namespace app\models;

use app\core\DbModel;

class UsersModel extends DbModel
{
    public int $id = 0;
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public int $status = 1;
    public string $passwordConfirm = '';

    public static function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return ['firstname', 'lastname', 'email', 'password'];
    }

    public function save()
    {
//        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        return parent::save();
    }
}