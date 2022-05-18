<?php

declare(strict_types=1);

namespace Src\Query;

use Src\Query\Trait\Join;
use Src\Query\Trait\Table;
use Src\Query\Trait\Where;

abstract class SQLStatement
{
    use Table;
    use Where;
    use Join;

    protected $sql;

    abstract protected function build();
    abstract public function exec();

}