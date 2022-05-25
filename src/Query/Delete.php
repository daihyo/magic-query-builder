<?php

declare(strict_types=1);

namespace Src\Query;

use Src\Log\Log;
use Src\Query\SQLStatement;

final class Delete extends SQLStatement
{
    private function __construct()
    {
    }

    public function exec()
    {
        return true;
    }

    protected function build()
    {
        return true;
    }
}
