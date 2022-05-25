<?php

declare(strict_types=1);

namespace Src\Query;

use Src\Log\Log;
use Src\Query\Select;

final class SubQuery
{

    public function select($columns=["*"])
    {
        return new Select($columns,function($sql,$params)
        {
            return ["sql"=>$sql, "params"=>$params];
        });
    }

}
