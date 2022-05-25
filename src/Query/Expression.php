<?php

declare(strict_types=1);

namespace Src\Query;

use Src\Log\Log;
use Src\Query\Trait\Column;
use Src\Query\Trait\Join;
use Src\Query\Trait\Where;

final class Expression
{

    use Column;
    use Where;
    use Join;

    public function groupBuild()
    {
        return $this->buildWhere();
    }

}
