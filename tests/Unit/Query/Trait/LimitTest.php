<?php

declare(strict_types=1);

namespace Tests\Unit\Query\Trait;

use Src\Query\Trait\Limit;
use PHPUnit\Framework\TestCase;

class LimitBeings
{
    use Limit;

    public function testBuildLimit()
    {
        return $this->buildLimit();
    }
}
class LimitTest extends TestCase
{
    /**
     * Limit句の設定
     *
     */
    public function testLimit()
    {
        $obj = new LimitBeings();
        $obj->limit(1, 30);
        $data = $obj->testBuildLimit();
        $this->assertSame(" Limit ?  , ? ", $data["sql"]);
        $this->assertSame([1,30], $data["params"]);
    }
}
