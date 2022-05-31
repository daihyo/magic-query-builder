<?php

declare(strict_types=1);

namespace Src\Query;

use Src\Log\Log;
use Src\Query\Trait\Column;
use Closure;
use Src\Query\SQLStatement;

final class Insert extends SQLStatement
{
    use Column;

    public function __construct(string $table, Closure|null $execHandler=null)
    {
        $this->table($table);
        $this->execHandler = $execHandler;
    }

    /**
     *
     * @param Array $columnValueArr
     * @return Insert $this
     *
     * @example (name,age) VALUE ('hoge',30) -> ['name'=>'hoge','age'=>30]
     *
     */
    public function into(array $columnValueArr)
    {
        $this->columnValue($columnValueArr, function ($columnArr) {
            $str = "( ". implode(',', $columnArr["column"]) . " )";
            $str .= " VALUES ";
            $str .= "( ". implode(',', array_map(fn () =>"?", $columnArr["value"])) . " )";

            return $str;
        });
        return $this;
    }

    protected function build()
    {
        $store = function ($arr) {
            if (!empty($arr["sql"])) {
                $this->sql .= $arr["sql"];
            }
            if (!empty($arr["params"])) {
                $this->params = array_merge($this->params, $arr["params"]);
            }
        };

        $this->sql = "INSERT INTO";
        $store($this->buildTable());
        $store($this->buildColumnValue());

        // log
        Log::_()->debug($this->sql);
        Log::_()->debug(print_r($this->params, true));
    }
}
