<?php


use app\core\Application;

class m0001_users {
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL,
                firstname VARCHAR(255) NOT NULL,
                lastname VARCHAR(255) NOT NULL,
                status TINYINT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
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