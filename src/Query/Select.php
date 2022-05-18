<?php

declare(strict_types=1);

namespace Src\Query;

use Src\Query\Trait\Sort;
use Src\Query\Trait\Limit;
use Src\Query\SQLStatement;

final class Select extends SQLStatement
{

    use Sort;
    use Limit;

    protected $connection;
    protected $columns;

    public function __construct($connection, $columns){

        $this->connection = $connection;

        if (is_array($columns)){
            $this->columns = implode(",", $columns);
        } else {
            $this->columns = $columns;
        }
    }

    protected function build(){
        $sql = "SELECT" . " ";
        $sql .= $this->columns . " ";
        $sql .= "FROM " . " ";
        $sql .= $this->getTable() . " ";
        $sql .= $this->getJoins(). " ";
        $sql .= $this->getWheres() . " ";
        $sql .= $this->getSorts() . " ";
        $sql .= $this->getLimits() . " ";

        return $sql;
    }

    public function exec(){
        return [];
    }

}