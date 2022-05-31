<?php

declare(strict_types=1);

namespace Src\Query\Trait;

use Src\Log\Log;
use Closure;
use Src\Query\SubQuery;

trait Table
{
    private array $table = [];


    /**
     *
     * @param string|Closure $table
     * @param string $alias
     *
     * @return Table $this
     *
     */
    public function table(string|Closure $table, string $alias = "")
    {
        $name = $table instanceof Closure ? $table(new SubQuery()) : $table;
        $this->table[] = compact("name", "alias");

        return $this;
    }

    protected function buildTable()
    {
        $queryArr = [];
        $paramArr = [];
        foreach ($this->table as $table) {
            $str = " ";
            if (is_object($table["name"])) {
                $subquery = $table["name"]->exec();
                $str .= "( " . $subquery["sql"] . " )";
                $paramArr = array_merge($paramArr, $subquery["params"]);
            } else {
                $str .= $table["name"];
            }

            if (!empty($table["alias"]) && is_string($table["alias"])) {
                $str .= " AS " . $table["alias"];
            }

            $str .= " ";

            $queryArr[] = $str;
        }

        return ["sql"=>implode(',', $queryArr), "params"=>$paramArr];
    }
}
