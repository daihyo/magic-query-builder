<?php

declare(strict_types=1);

namespace Src\Query;
use Src\Query\SQLStatement;

final class Insert extends SQLStatement
{

    private function __construct(){}

    public function exec(){
        return 1;
    }

    protected function build(){
        return true;
    }

}