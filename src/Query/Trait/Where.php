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
    public function where(string|Closure $column, $value=null, $operator = "=", $separator = "AND")
    {
        $this->isValidOp($operator);

        $isClosure = fn($_) => $_ instanceof Closure;

        // there is no closure pattern for both
        if($isClosure($column) && $isClosure($value)) throw new \InvalidArgumentException();

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

    /**
     * 
     * @param string $column
     * @param string $expr1
     * @param string $expr2
     * @param string $separator
     * 
     * @return Where $this
     * 
     */
    public function between($column, $expr1, $expr2, $separator = "AND")
    {

        $this->wheres[] = [
            "type" => "normal",
            "clause" => "BETWEEN",
            "column" => $column,
            "value" => " ( " . $expr1 ." , ". $expr2 . " ) ",
            "operator" => "",
            "separator" => $separator
        ];

        return $this;
    }
    public function andBetween($column, $expr1, $expr2)
    {
        return $this->between($column, $expr1, $expr2);
    }
    public function orBetween($column, $expr1, $expr2)
    {
        return $this->between($column, $expr1, $expr2,"OR");
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

    public function buildWhere($addClause=false){

        if (empty($this->wheres)) return ["sql"=>"", "params"=>[]];

        $sql = $addClause === true ? self::$_BASE : "";
        $params = [];

        foreach($this->wheres AS $wheres) {

            match($wheres['type']){
                "normal" => $this->buildNomalQuery($wheres,$sql,$params),
                "group" => $this->buildGroupQuery($wheres,$sql,$params),
                "subquery" => $this->buildSubqueryQuery($wheres,$sql,$params),
            };
        }

        return ["sql"=>$sql, "params"=>$params];

    }

    private function buildNomalQuery($wheres,&$sql,&$params){

        // Add a parameter if the condition is already stored.
        $sql .= ($sql !== self::$_BASE && $sql !== "") ? $wheres["separator"] : "";

        $sql .= " " . $wheres["column"];
        $sql .= " " . $wheres["clause"];
        $sql .= " " . $wheres["operator"] . " ? ";

        $params[] = $wheres["value"];

    }

    private function buildGroupQuery($wheres,&$sql,&$params){

         $group = $wheres["column"]->groupBuild();

         $sql .= " " . $wheres["clause"];
         $sql .= " (" . $group["sql"] . ") ";
 
         $params = array_merge($params,$group["params"]);

    }

    private function buildSubqueryQuery($wheres,&$sql,&$params){

        $subquery = $wheres["column"]->exec();

        $sql .= " " . $wheres["clause"];
        $sql .= " (" . $subquery["sql"] . ") ";

       $params = array_merge($params,$subquery["params"]);

    }

    private function isValidOp(string $op)
    {
        if(!in_array(mb_strtoupper($op), $this->operators)){
            throw new \InvalidArgumentException();
        }
    }

}
