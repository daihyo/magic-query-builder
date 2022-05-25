<?php

declare(strict_types=1);

namespace Src\Query\Trait;

trait Column
{
    private array $columns = [];

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
            if(!is_string($key)) {
                $this->columns[] = ["column"=>$val,"alias"=>""];
            } else {
                $this->columns[] = ["column"=>$key,"alias"=>$val];
            }
        }

        return $this;
    }

    protected function getColumn()
    {
        return $this->columns;
    }

    protected function buildColumn()
    {
        if (empty($this->columns)) return null;

        $str = "";
        foreach ($this->columns as $val) {
            $str .= $val["column"] . " ";
            if (!empty($val["alias"]) && is_string($val["alias"])) {
                $str .= " AS " . $val["alias"] . " ";
            }
            if ($val !== end($this->columns)) {
                $str .= " , ";
            }
        }

        return ["sql"=>$str, "params"=>[]];
    }
}
