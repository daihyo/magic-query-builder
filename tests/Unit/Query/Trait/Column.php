<?php

declare(strict_types=1);

namespace Tests\Unit\Query\Trait;

use Src\Query\Trait\Column;
use Src\Query\SubQuery;
use PHPUnit\Framework\TestCase;

class ColumnBeings
{
    use Column;


    public function testColumn(array $arg)
    {
        return $this->column($arg);
    }

    public function testBuildColumn()
    {
        return $this->buildColumn();
    }
}

class ColumnTest extends TestCase
{
    /**
     * カラムのクエリ作成
     *
     */
    public function testNomalTable()
    {
        $obj = new ColumnBeings();
        $obj->testColumn(["*"]);
        $data = $obj->testBuildColumn();
        $this->assertSame(" * ", $data["sql"]);
    }
}
