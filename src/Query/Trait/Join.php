<?php

declare(strict_types=1);

namespace Src\Query\Trait;

trait Join
{

    private array $joins = [];

    public function join(string $join) {
        $this->joins = [$join];
        return $this;
    }

    protected function getJoins() {
        return $this->joins;
    }

}