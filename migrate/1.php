<?php

class Migrate1 implements Migrate
{
    public function upgrade(PDO $pdo){
        $pdo->exec('
CREATE TABLE task_user (
task_user_id serial NOT NULL,
login_id text NOT NULL UNIQUE,
password text NOT NULL
)');
        $users = parse_ini_file('config/develop_auth.ini');
        foreach ($users as $user => $password){
            $stmt = $pdo->prepare('INSERT INTO task_user(login_id, password) values (?, ?)');
            $stmt->execute(array($user, $password));
        }
    }
    public function downgrade(PDO $pdo){
        $pdo->exec('DROP TABLE task_user');
    }
}
