<?php

declare(strict_types=1);

namespace Src\Query;

use Src\Log\Log;
use Closure;
use Src\Query\SQLStatement;

final class Delete extends SQLStatement
{
    public function __construct(string $table, Closure|null $execHandler=null)
    {
        $this->table($table);
        $this->execHandler = $execHandler;
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

        $this->sql = "DELETE FROM";
        $store($this->buildTable());
        $store($this->buildWhere(true));

        // log
        Log::_()->debug($this->sql);
        Log::_()->debug(print_r($this->params, true));
    }
}
