<?php

declare(strict_types=1);

namespace Src\Query\Trait;

use Closure;
use Src\Query\Expression;
use Src\Query\SubQuery;

trait Where
{
    private array $wheres = [];

    private array $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>',
        'LIKE', 'NOT LIKE',
    ];

    private string $sql = " WHERE ";
    private array $params = [];

    /**
     * @param string|Closure $value
     */
    public function where(string|Closure $column, $value=null, $operator = "=", $separator = "AND")
    {
        $this->isValidOp($operator);

        $isClosure = fn($_) => $_ instanceof Closure;

        // if($column instanceof Closure && $value instanceof Closure){
        //     throw new \InvalidArgumentException();
        // } 

        if($isClosure($column)) {
            $this->wheres[] = [
                "type" => "group",
                "clause" => "",
                "column" => $column(new Expression),
                "value" => $value,
                "operator" => $operator,
                "separator" => $separator
            ];
            return $this;
        }

        if($isClosure($value)) {
            $this->wheres[] = [
                "type" => "subquery",
                "clause" => "",
                "column" => $column,
                "value" => $value(new SubQuery),
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
            "operator" => $operator,
            "separator" => $separator
        ];

        return $this;
    }

    public function andWhere($colum, $value=null, $operator = "=")
    {
        return $this->where($colum, $value, $operator);
    }

    public function orWhere($colum, $value=null, $operator = "=")
    {
        return $this->where($colum, $value, $operator, "OR");
    }

    public function between($value)
    {
    }
    public function andBetween($value)
    {
    }
    public function orBetween($value)
    {
    }

    public function notBetween($value)
    {
    }
    public function andNotBetween($value)
    {
    }
    public function orNotBetween($value)
    {
    }

    public function in($value)
    {
    }
    public function andIn($value)
    {
    }
    public function orIn($value)
    {
    }

    public function notIn($value)
    {
    }
    public function andNotIn($value)
    {
    }
    public function orNotIn($value)
    {
    }

    public function isNull()
    {
    }
    public function andIsNull()
    {
    }
    public function orIsNull()
    {
    }

    public function isNotNull()
    {
    }
    public function andIsNotNull()
    {
    }
    public function orIsNotNull()
    {
    }


    public function exists($subquery)
    {
    }
    public function andExists($subquery)
    {
    }
    public function orExists($subquery)
    {
    }
    public function notExists($subquery)
    {
    }
    public function andNotExists($subquery)
    {
    }
    public function orNotExists($subquery)
    {
    }

    public function whereColumn()
    {

    }

    public function andWhereColumn()
    {
        
    }

    public function orWhereColumn()
    {
        
    }

    protected function getWheres()
    {
        return $this->wheres;
    }

    public function buildWhere(){

        if (empty($this->wheres)) return "";
        
        foreach($this->wheres AS $wheres) {

            match($wheres['type']){
                "normal" => $this->buildNomalQuery($wheres),
                "group" => $this->buildGroupQuery($wheres),
                "subquery" => $this->buildSubqueryQuery($wheres),
            };
        }

        var_dump("-----where句-----");
        var_dump($this->sql);
        var_dump($this->params);

        return " WHERE id = 2 ";

    }

    private function buildNomalQuery($wheres){

        if ($this->sql !== " WHERE ") $this->sql .= " " . $wheres["separator"];
        $this->sql .= " " . $wheres["clause"];
        $this->sql .= " " . $wheres["column"];
        $this->sql .= " " . $wheres["operator"] . " ? ";

        $this->params[] = $wheres["value"];

    }

    private function buildGroupQuery($wheres){

    }

    private function buildSubqueryQuery($wheres){

    }

    private function isValidOp(string $op)
    {
        if(!in_array(mb_strtoupper($op), $this->operators)){
            throw new \InvalidArgumentException();
        }
    }

}
