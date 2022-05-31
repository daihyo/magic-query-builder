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

    public function __construct($pdo)
    {
        $this->conn = $pdo;
    }

    public function getConnection()
    {
        return $this;
    }

    /**
     * SELECT SQL Statement
     *
     * @param array $collums
     * @return object Select
     */
    public function select(array $columns=["*"])
    {
        return new Select($columns, function ($sql, $params) {
            $sth = $this->conn->pdo->prepare($sql);
            $sth->execute($params);
            return $sth->fetchAll();
        });
    }

    /**
     * INSERT SQL Statement
     *
     * @param string $table
     * @return object Insert
     */
    public function insert(string $table)
    {
        return new Insert($table, function ($sql, $params) {
            $sth = $this->conn->pdo->prepare($sql);
            return $sth->execute($params);
        });
    }

    /**
     * UPDATE SQL Statement
     *
     * @param string $table
     * @return object Update
     */
    public function update(string $table)
    {
        return new Update($table, function ($sql, $params) {
            $sth = $this->conn->pdo->prepare($sql);
            return $sth->execute($params);
        });
    }

    /**
     * DELETE SQL Statement
     *
     * @param string $table
     * @return object Delete
     */
    public function delete(string $table)
    {
        return new Delete($table, function ($sql, $params) {
            $sth = $this->conn->pdo->prepare($sql);
            return $sth->execute($params);
        });
    }

    public function transaction()
    {
        $this->conn->pdo->beginTransaction();
    }

    public function commit()
    {
        $this->conn->pdo->commit();
    }

    public function rollBack()
    {
        $this->conn->pdo->rollBack();
    }
}
