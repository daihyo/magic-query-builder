<?php

declare(strict_types=1);

namespace Src;

use PDO;
use PDOException;

class DB
{
    public $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new PDO('sqlite:sample.sqlite');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


            $this->stb();
        } catch (PDOException $e) {
            die('ERROR: '.$e->getMessage());
        }
    }

    public static function conn()
    {
        return new static();
    }

    // TODO 消す
    private function stb()
    {
        $userD = "DROP TABLE IF EXISTS users";
        $userT = " CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT ,
        name text,
        age INT(11),
        gender INT(11)
        )";

        $empD = "DROP TABLE IF EXISTS employees";
        $empT = "CREATE TABLE IF NOT EXISTS employees (
        id INTEGER PRIMARY KEY AUTOINCREMENT ,
        mail text,
        user_id INT(11)
        )";

        $user[] = "INSERT INTO users(name,age,gender) VALUES ('suzuki taro1' , 20, 1)";
        $user[] = "INSERT INTO users(name,age,gender) VALUES ( 'suzuki taro2' , 25, 1)";
        $user[] = "INSERT INTO users(name,age,gender) VALUES ( 'suzuki taro3' , 30, 1)";
        $user[] = "INSERT INTO users(name,age,gender) VALUES ( 'suzuki taro4' , 35, 1)";
        $user[] = "INSERT INTO users(name,age,gender) VALUES ( 'suzuki hanako1' , 20, 2)";
        $user[] = "INSERT INTO users(name,age,gender) VALUES ( 'suzuki hanako2' , 25, 2)";
        $user[] = "INSERT INTO users(name,age,gender) VALUES ( 'suzuki hanako3' , 30, 2)";
        $user[] = "INSERT INTO users(name,age,gender) VALUES ( 'sato jiro1' , 20, 1)";
        $user[] = "INSERT INTO users(name,age,gender) VALUES ( 'sato jiro2' , 25, 1)";
        $user[] = "INSERT INTO users(name,age,gender) VALUES ( 'sato jiro3' , 30, 1)";
        $user[] = "INSERT INTO users(name,age,gender) VALUES ( 'test example' , 55, 1)";
        $user[] = "INSERT INTO users(name,age,gender) VALUES ( 'test test' , 30, 99)";

        $emp[] = "INSERT INTO employees(mail,user_id) VALUES ('suzuki_taro1@examole.com' , 1)";
        $emp[] = "INSERT INTO employees(mail,user_id) VALUES ('suzuki_taro2@examole.com' , 2)";
        $emp[] = "INSERT INTO employees(mail,user_id) VALUES ('suzuki_taro3@examole.com' , 3)";
        $emp[] = "INSERT INTO employees(mail,user_id) VALUES ('suzuki_taro4@examole.com' , 4)";
        $emp[] = "INSERT INTO employees(mail,user_id) VALUES ('suzuki hanako1@examole.com' , 5)";


        $this->pdo->query($userD);
        $this->pdo->query($userT);
        $this->pdo->query($empD);
        $this->pdo->query($empT);
        array_map(fn($x) => $this->pdo->query($x),$user);
        array_map(fn($x) => $this->pdo->query($x),$emp);
        // $this->pdo->query($user);
        // $this->pdo->query($emp);
    }
}
