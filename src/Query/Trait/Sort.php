<?php

declare(strict_types=1);

namespace Src\Query\Trait;

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
    public function orderBy($column,$direction="ASC",$separator = "")
    {
        $this->sorts[] = compact("column","direction", "separator");
        return $this;
    }
    public function andOrderBy($column,$direction="ASC",$separator = "")
    {
        return $this->between($column,$direction,",");
        return $this;
    }

    protected function getSorts()
    {
        return $this->sorts;
    }
    protected function buildSort()
    {

    }
}
