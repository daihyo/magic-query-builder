<?php

declare(strict_types=1);

namespace Src\Query\Trait;

use Src\Log\Log;
use Closure;
use Src\Query\Expression;
use Src\Query\SubQuery;

trait Where
{
    private array $wheres = [];

    private static string $_BASE = " WHERE ";

    private array $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>',
        'LIKE', 'NOT LIKE',
    ];

    /**
     *
     * @param string|Closure $column
     * @param string|Closure $value
     * @param string $operator
     * @param string $separator
     *
     * @return Where $this
     *
     */
    public function where(string|Closure $column, string|int|Closure $value="", string $operator = "=", string $separator = "AND")
    {
        $isClosure = fn ($_) => $_ instanceof Closure;

        if ($isClosure($column)) {
            $this->wheres[] = [
                "type" => "group",
                "clause" => "",
                "column" => $column(new Expression()),
                "value" => $value,
                "operator" => "",
                "separator" => $separator
            ];
            return $this;
        }

        if ($isClosure($value)) {
            $this->wheres[] = [
                "type" => "subquery",
                "clause" => "",
                "column" => $column,
                "value" => $value(new SubQuery()),
                "operator" => $operator,
                "separator" => $separator
            ];
            return $this;
        }

        $this->wheres[] = [
            "type" => "normal",
            "clause" => "",
            "column" => $column,
            "value" => $value,
            "operator" => $operator ." ? ",
            "separator" => $separator
        ];

        return $this;
    }

    /**
     *
     * @param string $column
     * @param string|int $expr1
     * @param string|int $expr2
     * @param string $separator
     *
     * @return Where $this
     *
     */
    public function between(string $column, string|int $expr1, string|int $expr2, string $separator = "AND")
    {
        $this->wheres[] = [
            "type" => "normal",
            "clause" => "BETWEEN",
            "column" => $column,
            "value" => [$expr1 , $expr2 ],
            "operator" => "? AND ?",
            "separator" => $separator
        ];

        return $this;
    }

    /**
     *
     * @param string $column
     * @param string|int $expr1
     * @param string|int $expr2
     * @param string $separator
     *
     * @return Where $this
     *
     */
    public function notBetween(string $column, string|int $expr1, string|int $expr2, string $separator = "AND")
    {
        $this->wheres[] = [
            "type" => "normal",
            "clause" => "NOT BETWEEN",
            "column" => $column,
            "value" => [$expr1 , $expr2 ],
            "operator" => "? AND ?",
            "separator" => $separator
        ];

        return $this;
    }

    /**
     *
     * @param string $column
     * @param array|Closure $value
     * @param string $separator
     *
     * @return Where $this
     *
     */
    public function in(string $column, array|Closure $value, string $separator = "AND")
    {
        if ($value instanceof Closure) {
            $this->wheres[] = [
                "type" => "subquery",
                "clause" => "IN",
                "column" => $column,
                "value" => $value(new SubQuery()),
                "operator" => "",
                "separator" => $separator
            ];
            return $this;
        }

        $this->wheres[] = [
            "type" => "normal",
            "clause" => "IN",
            "column" => $column,
            "value" => $value,
            "operator" => " ( ".implode(",", array_map(fn () => " ? ", $value))." ) ",
            "separator" => $separator
        ];
        return $this;
    }

    /**
     *
     * @param string $column
     * @param array|Closure $value
     * @param string $separator
     *
     * @return Where $this
     *
     */
    public function notIn(string $column, array|Closure $value, string $separator = "AND")
    {
        if ($value instanceof Closure) {
            $this->wheres[] = [
                "type" => "subquery",
                "clause" => "NOT IN",
                "column" => $column,
                "value" => $value(new SubQuery()),
                "operator" => "",
                "separator" => $separator
            ];
            return $this;
        }

        $this->wheres[] = [
            "type" => "normal",
            "clause" => "NOT IN",
            "column" => $column,
            "value" => $value,
            "operator" => " ( ".implode(",", array_map(fn () => " ? ", $value))." ) ",
            "separator" => $separator
        ];
        return $this;
    }

    /**
     *
     * @param string $column
     * @param string $separator
     *
     * @return Where $this
     *
     */
    public function isNull(string $column, string $separator = "AND")
    {
        $this->wheres[] = [
            "type" => "normal",
            "clause" => "IS NULL",
            "column" => $column,
            "value" => "",
            "operator" => "",
            "separator" => $separator
        ];
        return $this;
    }

    /**
     *
     * @param string $column
     * @param string $separator
     *
     * @return Where $this
     *
     */
    public function isNotNull(string $column, string $separator = "AND")
    {
        $this->wheres[] = [
            "type" => "normal",
            "clause" => "IS NOT NULL",
            "column" => $column,
            "value" => "",
            "operator" => "",
            "separator" => $separator
        ];
        return $this;
    }

    /**
     *
     * @param string $column
     * @param Closure $value
     * @param string $separator
     *
     * @return Where $this
     *
     */
    public function exists(string $column, Closure $value, string $separator = "AND")
    {
        $this->wheres[] = [
            "type" => "subquery",
            "clause" => "EXISTS",
            "column" => $column,
            "value" => $value(new SubQuery()),
            "operator" => "",
            "separator" => $separator
        ];
        return $this;
    }

    /**
     *
     * @param string $column
     * @param Closure $value
     * @param string $separator
     *
     * @return Where $this
     *
     */
    public function notExists(string $column, Closure $value, string $separator = "AND")
    {
        $this->wheres[] = [
            "type" => "subquery",
            "clause" => "NOT EXISTS",
            "column" => $column,
            "value" => $value(new SubQuery()),
            "operator" => "",
            "separator" => $separator
        ];
        return $this;
    }

    /**
     *
     * @param string $column1
     * @param string $column1
     * @param string $operator
     * @param string $separator
     *
     * @return Where $this
     *
     */
    public function whereColumn(string $column1, string $column2, string $operator = "=", string $separator = "AND")
    {
        $this->wheres[] = [
            "type" => "correlation",
            "clause" => "",
            "column" => [$column1,$column2],
            "value" => "",
            "operator" => $operator,
            "separator" => $separator
        ];

        return $this;
    }

    /**
     *
     * @param bool $addClause
     *
     * @return array ["sql"=>$sql,"params"=>$param]
     *
     * if $addClause is true , "WHERE" is added to the beginning of SQL.
     *
     */
    public function buildWhere(bool $addClause=false)
    {
        if (empty($this->wheres)) {
            return ["sql"=>"", "params"=>[]];
        }

        $sql = $addClause === true ? self::$_BASE : "";
        $params = [];

        foreach ($this->wheres as $where) {
            match ($where['type']) {
                "normal" => $this->buildNomalQuery($where, $sql, $params),
                "correlation" => $this->buildCorrelationQuery($where, $sql),
                "group" => $this->buildGroupQuery($where, $sql, $params),
                "subquery" => $this->buildSubqueryQuery($where, $sql, $params),
            };
        }

        return ["sql"=>$sql, "params"=>$params];
    }

    private function buildNomalQuery($where, &$sql, &$params)
    {
        $sql .= ($sql !== self::$_BASE && $sql !== "") ? $where["separator"] : "";

        $sql .= " " . $where["column"];
        $sql .= " " . $where["clause"];
        $sql .= " " . $where["operator"] . " ";

        $params = !empty($where["value"]) ? array_merge($params, (array) $where["value"]) : [];
    }

    private function buildCorrelationQuery($where, &$sql)
    {
        $sql .= ($sql !== self::$_BASE && $sql !== "") ? $where["separator"] : "";

        $sql .= " " . $where["column"][0];
        $sql .= " " . $where["operator"];
        $sql .= " " . $where["column"][1] . " ";
    }

    private function buildGroupQuery($where, &$sql, &$params)
    {
        $group = $where["column"]->buildWhere();

        $sql .= " " . $where["clause"];
        $sql .= " (" . $group["sql"] . ") ";

        $params = array_merge($params, $group["params"]);
    }

    private function buildSubqueryQuery($where, &$sql, &$params)
    {
        $subquery = $where["value"]->exec();

        $sql .= " " . $where["column"];
        $sql .= " " . $where["operator"];
        $sql .= " " . $where["clause"];
        $sql .= " (" . $subquery["sql"] . ") ";

        $params = array_merge($params, $subquery["params"]);
    }

    private function isValidOp(string $op)
    {
        if (!in_array(mb_strtoupper($op), $this->operators)) {
            throw new \InvalidArgumentException();
        }
    }
}
