<?php

declare(strict_types=1);

namespace Src\Query;

use Src\Log\Log;
use Closure;
use Src\Query\Trait\Column;
use Src\Query\Trait\Sort;
use Src\Query\Trait\Limit;
use Src\Query\SQLStatement;

final class Select extends SQLStatement
{
    use Column;
    use Sort;
    use Limit;

    public function __construct($columns, Closure|null $execHandler=null)
    {
        $this->column($columns);
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

        $this->sql = "SELECT";
        $store($this->buildColumn());
        $this->sql .= "FROM";
        $store($this->buildTable());
        $store($this->buildJoin(true));
        $store($this->buildWhere(true));
        $store($this->buildSort());
        $store($this->buildLimit());

        // log
        // Log::_()->debug($this->sql);
        // Log::_()->debug(print_r($this->params, true));
    }
}
