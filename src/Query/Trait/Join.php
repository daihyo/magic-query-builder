<?php

declare(strict_types=1);

namespace Src\Query\Trait;

use Src\Log\Log;
use Closure;
use Exception;
use Src\Query\Expression;
use Src\Query\SubQuery;

trait Join
{
    private array $joins = [];

    public function join(string|Closure $table, string|Closure $column1, string|null $column2 =null)
    {
        $isClosure = fn ($_) => $_ instanceof Closure;

        if ($isClosure($column1)) {
            $this->joins[] = [
                "table" => $isClosure($table) ? $table(new SubQuery()) : $table,
                "column" => $column1(new Expression())
            ];
            return $this;
        }

        $this->joins[] = [
            "table" => $isClosure($table) ? $table(new SubQuery()) : $table,
            "column" => $this->on($column1, $column2)
        ];
        return $this;
    }

    protected function buildJoin(bool $addClause=false)
    {
        if (empty($this->joins)) {
            return ["sql"=>"", "params"=>[]];
        }

        $sql = $addClause === true ? " INNER JOIN " : "";
        $params = [];

        foreach ($this->joins as $join) {
            $this->buildJoinTable($join, $sql, $params);
            $this->buildJoinColumn($join, $sql, $params);
        }

        return ["sql"=>$sql, "params"=>$params];
    }

    private function buildJoinTable($join, &$sql, &$params)
    {
        if (is_object($join["table"])) {
            $subquery = $join["table"]->exec();
            $sql = " ( " . $subquery["sql"] . " ) ";
            $params = array_merge($params, $subquery["params"]);
        } else {
            $sql = " " . $join["table"] . " ";
        }
    }

    private function buildJoinColumn($join, &$sql, &$params)
    {
        $query = $join["column"]->buildWhere();

        $sql .= "ON" . $query["sql"] . " ";

        $params = array_merge($params, $query["params"]);
    }

    public function on(string $column1, string $column2)
    {
        return (new Expression())->whereColumn($column1, $column2);
    }
}
