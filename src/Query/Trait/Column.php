<?php

declare(strict_types=1);

namespace Src\Query\Trait;

use Closure;

trait Column
{
    private array $columns = [];
    private array $columnValues = [];

    /**
     * add colum and alias
     *
     * @param Array $columnArr
     * @return Colum $this
     *
     */
    protected function column(array $columnArr = [])
    {
        foreach ($columnArr as $key => $val) {
            if (!is_string($key)) {
                $this->columns[] = ["column"=>$val,"alias"=>""];
            } else {
                $this->columns[] = ["column"=>$key,"alias"=>$val];
            }
        }

        return $this;
    }

    protected function buildColumn()
    {
        if (empty($this->columns)) {
            return ["sql"=>"", "params"=>[]];
        }

        $str = "";
        foreach ($this->columns as $val) {
            $str .= " " . $val["column"] . " ";
            if (!empty($val["alias"]) && is_string($val["alias"])) {
                $str .= " AS " . $val["alias"] . " ";
            }
            if ($val !== end($this->columns)) {
                $str .= " , ";
            }
        }

        return ["sql"=>$str, "params"=>[]];
    }


    /**
     * add colum and value array
     *
     * @param Array $columnValueArr
     * @param Closure $buildHandler
     * @return Colum $this
     *
     */
    protected function columnValue(array $columnValueArr, Closure $buildHandler)
    {
        $this->columnValues["buildHandler"] = $buildHandler;
        foreach ($columnValueArr as $key => $val) {
            $this->columnValues["column"][] = $key;
            $this->columnValues["value"][] = $val;
        }

        return $this;
    }

    protected function buildColumnValue()
    {
        if (empty($this->columnValues)) {
            return ["sql"=>"", "params"=>[]];
        }

        $handler = $this->columnValues["buildHandler"];
        $str = $handler($this->columnValues);

        return ["sql"=>$str, "params"=>$this->columnValues["value"]];
    }
}
