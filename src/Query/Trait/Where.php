<?php

declare(strict_types=1);

namespace Src\Query\Trait;
use Closure;

trait Where
{

    private array $wheres = [];

    private array $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>',
        'LIKE', 'NOT LIKE',
    ];



    /**
     * @param string|Closure $value
     */
    public function where($colum, $operator = null,$value=null) {
        if(func_num_args() === 2) [$operator,$value] = ["=",$operator];
    }

    public function andWhere($colum,$operator = null,$value=null) {
        if(func_num_args() === 2) [$operator,$value] = ["=",$operator];
    }

    public function orWhere($colum,$operator = null,$value=null) {
        if(func_num_args() === 2) [$operator,$value] = ["=",$operator];
    }

    public function between($value) {}
    public function andBetween($value) {}
    public function orBetween($value) {}

    public function notBetween($value) {}
    public function andNotBetween($value) {}
    public function orNotBetween($value) {}

    public function in($value) {}
    public function andIn($value) {}
    public function orIn($value) {}

    public function notIn($value) {}
    public function andNotIn($value) {}
    public function orNotIn($value) {}

    public function isNull() {}
    public function andIsNull() {}
    public function orIsNull() {}

    public function isNotNull() {}
    public function andIsNotNull() {}
    public function orIsNotNull() {}

    protected function getWheres() {
        return $this->wheres;
    }

    private function isValidOp(string $op): bool
    {
        return in_array(mb_strtoupper($op), $this->operators);
    }
    
}