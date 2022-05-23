<?php

declare(strict_types=1);

namespace Src\Query;

use Src\Query\Trait\Column;
use Src\Query\Trait\Join;
use Src\Query\Trait\Where;

final class Expression
{

    use Column;
    use Where;
    use Join;

    public function build()
    {
        $str = "SELECT ";
        $str .= $this->buildColumn();
        $str .= "FROM ";
        // $sql .= $this->getJoins(). " ";
        // $sql .= $this->getWheres() . " ";
        // $sql .= $this->getSorts() . " ";
        // $sql .= $this->getLimits() . " ";

        var_dump("---expression---");
        var_dump($str);

        return $str;
    }

}
