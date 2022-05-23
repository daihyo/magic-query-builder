<?php

declare(strict_types=1);

namespace Src\Query\Trait;

trait Limit
{
    private array $limits = [];

    public function limit($value)
    {
    }
    public function andLimit($value)
    {
    }
    public function orLimit($value)
    {
    }

    protected function getLimits()
    {
        return $this->limits;
    }
}
