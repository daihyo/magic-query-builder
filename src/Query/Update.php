<?php

declare(strict_types=1);

namespace Src\Query;

use Src\Log\Log;
use Src\Query\Trait\Column;
use Closure;
use Src\Query\SQLStatement;

final class Update extends SQLStatement
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
     * @example name='hoge',age=30 -> ['name'=>'hoge','age'=>30]
     *
     */
    public function set(array $columnValueArr)
    {
        $this->columnValue($columnValueArr, function ($columnArr) {
            return implode(',', array_map(fn ($col) => " " . $col." = ? ", $columnArr["column"]));
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

        $this->sql = "UPDATE";
        $store($this->buildTable());
        $this->sql .= "SET";
        $store($this->buildColumnValue());
        $store($this->buildWhere(true));

        // log
        Log::_()->debug($this->sql);
        Log::_()->debug(print_r($this->params, true));
    }
}
