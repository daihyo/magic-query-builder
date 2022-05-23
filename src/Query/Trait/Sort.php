<?php

declare(strict_types=1);

namespace Src\Query\Trait;

trait Sort
{
    private array $sorts = [];

    public function orderBy($value)
    {
        return $this;
    }
    public function andOrderBy($value)
    {
        return $this;
    }
    public function orOrderBy($value)
    {
        return $this;
    }

    protected function getSorts()
    {
        return $this->sorts;
    }
}
