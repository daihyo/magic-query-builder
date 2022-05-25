<?php

declare(strict_types=1);

namespace Src\Query;

use Src\Log\Log;
use Src\Query\SQLStatement;

final class Update extends SQLStatement
{
    private function __construct()
    {
    }

    protected function build()
    {
        return true;
    }

    public function exec()
    {
        return true;
    }
}
