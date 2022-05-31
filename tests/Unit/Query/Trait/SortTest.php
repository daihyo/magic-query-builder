<?php

declare(strict_types=1);

namespace Tests\Unit\Query\Trait;

use Src\Query\Trait\Sort;
use PHPUnit\Framework\TestCase;

class SortBeings
{
    use Sort;

    public function testBuildSort()
    {
        return $this->buildSort();
    }
}
class SortTest extends TestCase
{
    /**
     * ORDER BY句の設定
     *
     */
    public function testSortOrderByIdDesc()
    {
        $obj = new SortBeings();
        $obj->orderBy("id", "DESC");
        $data = $obj->testBuildSort();
        $this->assertSame(" ORDER BY id DESC", $data["sql"]);
    }

    /**
     * ORDER BY句を複数設定
     *
     */
    public function testSortOrderByIdDescAndNameAsc()
    {
        $obj = new SortBeings();
        $obj->orderBy("id", "DESC")->orderBy("name", "ASC");
        $data = $obj->testBuildSort();
        $this->assertSame(" ORDER BY id DESC,name ASC", $data["sql"]);
    }
}
