<?php

declare(strict_types=1);

namespace Src\Query\Trait;

use Closure;
use Src\Query\SubQuery;

trait Table
{
    private $table = [];


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
        $name = $table instanceof Closure ? $table(new SubQuery) : $table;
        $this->table[] = compact("name","alias");

        return $this;
    }

    protected function getTable()
    {
        return $this->table;
    }

    protected function buildTable()
    {

        $arr = [];
        foreach($this->table AS $table) {
            $str = "";
            if ($table["name"] instanceof SubQuery) {
                $str = " ( " . $table["name"]->build() . " ) ";
            }else {
                $str = $table["name"];
            }
    
            if (!empty($table["alias"])) {
                $str .= " AS " . $table["alias"]. " ";
            }
            $arr[] = $str;
        }

        return implode(',', $arr);
    }
}
