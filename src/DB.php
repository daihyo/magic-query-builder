<?php

declare(strict_types=1);

namespace Src;

use \PDO;
use \PDOException;


class DB
{

    public $pdo;

    private function __construct(){
        try{
            $this->pdo = new PDO('sqlite:sample.sqlite');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }catch(PDOException $e){
          die('ERROR: '.$e->getMessage());
        }
      }

    public static function conn(){
      return new static;
    }

}