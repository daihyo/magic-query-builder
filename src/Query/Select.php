<?php

declare(strict_types=1);

namespace Src\Query;

use Src\Query\Trait\Column;
use Src\Query\Trait\Sort;
use Src\Query\Trait\Limit;
use Src\Query\SQLStatement;

final class Select extends SQLStatement
{
    use Column;
    use Sort;
    use Limit;

    public function __construct($connection, $columns)
    {
        $this->connection = $connection;
        $this->column($columns);
    }

    protected function build()
    {
        $str = "SELECT ";
        $str .= $this->buildColumn();
        $str .= "FROM ";
        $str .= $this->buildTable();
        // $sql .= $this->getJoins(). " ";
        $str .= $this->buildWhere() . " ";
        // $sql .= $this->getSorts() . " ";
        // $sql .= $this->getLimits() . " ";

        var_dump($str);

        return $str;
    }

    public function exec()
    {
        $sth = $this->connection->pdo->prepare($this->build());
        $sth->execute();
        return $sth->fetchAll();
    }
}
