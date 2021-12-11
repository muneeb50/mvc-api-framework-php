<?php


use app\core\Application;

class m0001_users {
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE users (
                id VARCHAR(512) PRIMARY KEY,
                createdBy VARCHAR(255),
                createdAt TIMESTAMP,
                modifiedBy VARCHAR(255),
                modifiedAt TIMESTAMP,
                fullName VARCHAR(255) NOT NULL UNIQUE,
                email VARCHAR(255) NOT NULL UNIQUE,
                username VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(512)
            )  ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE users;";
        $db->pdo->exec($SQL);
    }
}