<?php

declare(strict_types=1);

namespace Src;

use \PDO;
use \PDOException;
use Src\DB;
use Src\Query\Select;
use Src\Query\Insert;
use Src\Query\Update;
use Src\Query\Delete;

class Query
{

    private $connection;
    private $dml;
    static $instance = null;

    public function __construct(DB $connection)
    {
      $this->connection = $connection;
    }

    public function getConnection(){
      return $this;
    }

    /**
     * 
     * @param string|array $collums
     */
    public function select($columns="*") {
      return new Select($this->connection,$columns);
    }

    public function insert($table) {
      return $this->dml = new Insert($this->connection,$table);
    }

    public function update($table) {
      return $this->dml = new Update($this->connection,$table);
    }

    public function delete($table) {
      return $this->dml = new Delete($this->connection,$table);
    }

}