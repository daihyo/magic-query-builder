<?php

declare(strict_types=1);

namespace Tests\Unit\Query\Trait;

use Src\Query\Trait\Table;
use Src\Query\SubQuery;
use PHPUnit\Framework\TestCase;

class TableBeings {
    use Table;

    public function testBuildTable(){
        return $this->buildTable();
    }
}

class TableTest extends TestCase
{

    /**
     * テーブルのクエリ作成
     * 
     */
    public function testNomalTable()
    {
        $obj = new TableBeings();
        $obj->table("test","t");
        $data = $obj->testBuildTable();
        $this->assertSame("test AS t ", $data["sql"]);
    }

    /**
     * サブクエリを含むテーブルのクエリ作成
     * 
     */
    public function testSubqueryTable()
    {
        $obj = new TableBeings();
        $sqObj = new SubQuery();
        $query = fn()=>$sqObj->select()->table("test")->where("id", 1);
        $obj->table($query , "t");
        $data = $obj->testBuildTable();
        $this->assertSame(" ( SELECT *  FROM test  WHERE  id  = ?   )  AS t ", $data["sql"]);
        $this->assertSame([1], $data["params"]);
    }
}
