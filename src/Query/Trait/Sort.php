<?php

declare(strict_types=1);

namespace Src\Query\Trait;

use Src\Log\Log;

trait Sort
{
    private array $sorts = [];

    /**
     *
     * @param string $column
     * @param string $direction
     * @param string $separator
     *
     * @return Sort $this
     *
     */
    public function orderBy(string $column, string $direction="ASC")
    {
        if (!in_array($direction, ["ASC","DESC"])) {
            throw new \InvalidArgumentException();
        }

        $this->sorts[] = compact("column", "direction");
        return $this;
    }

    protected function buildSort()
    {
        $queryArr = [];
        if (empty($this->sorts)) {
            return ["sql"=>$queryArr, "params"=>[]];
        }

        $queryArr = array_map(fn ($x) =>$x["column"]." ".$x["direction"], $this->sorts);
        return ["sql"=>" ORDER BY " . implode(',', $queryArr), "params"=>[]];
    }
}
