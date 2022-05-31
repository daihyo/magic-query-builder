<?php

declare(strict_types=1);

namespace Src\Query\Trait;

trait Limit
{
    private int $limit;

    private int|null $offset=null;

    public function limit(int $limit, int|null $offset=null)
    {
        $this->limit = $limit;
        $this->offset = $offset;

        return $this;
    }

    protected function buildLimit()
    {
        if (!isset($this->limit)) {
            return ["sql"=>"", "params"=>[]];
        }

        $query = " Limit ? ";
        $paramArr[] = $this->limit;

        if (isset($this->offset)) {
            $query .= " , ? ";
            $paramArr[] = $this->offset;
        }

        return ["sql"=>$query, "params"=>$paramArr];
    }
}
