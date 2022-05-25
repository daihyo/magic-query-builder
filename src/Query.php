<?php

declare(strict_types=1);

namespace Src;

use PDO;
use PDOException;
use Src\DB;
use Src\Log\Log;
use Src\Query\Select;
use Src\Query\Insert;
use Src\Query\Update;
use Src\Query\Delete;

class Query
{
    private $conn;
    public static $instance = null;

    public function __construct($pdo)
    {
        $this->conn = $pdo;
    }

    public function getConnection()
    {
        return $this;
    }

    /**
     *
     * @param string|array $collums
     */
    public function select($columns=["*"])
    {
        return new Select($columns,function($sql,$params){
            $sth = $this->conn->pdo->prepare($sql);
            $sth->execute($params);
            return $sth->fetchAll();});
    }

    public function insert($table)
    {
        return $this->dml = new Insert($this->connection, $table);
    }

    public function update($table)
    {
        return $this->dml = new Update($this->connection, $table);
    }

    public function delete($table)
    {
        return $this->dml = new Delete($this->connection, $table);
    }
}
