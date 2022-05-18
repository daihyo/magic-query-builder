<?php

declare(strict_types=1);

namespace Src\Query\Trait;

trait Table
{
    private string $table = "";

    public function table(string $table) {
        $this->table = $table;
        return $this;
    }

    protected function getTable() {
        return $this->table;
    }
}