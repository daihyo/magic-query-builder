<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\DB;
use Src\Query;
use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase
{
    private Query $sql;

    public function setUp(): void
    {
        $db = DB::conn();
        $this->sql = (new Query($db));
        // echo "setUp\n";
    }

    public function tearDown(): void
    {
        // echo "tearDown\n";
    }

    /**
     * シンプルなSELECT文(WHERE句指定)
     *
     * SELECT * FROM users WHERE name = 'suzuki taro1'
     *
     */
    public function testWhereName()
    {
        $result = $this->sql->select()->table("users")->where("name","suzuki taro1")->exec();
        $this->assertSame("suzuki taro1", $result[0]["name"]);
    }

    /**
     * シンプルなSELECT文(WHERE句にBETWEEN指定)
     *
     * SELECT * FROM users WHERE name = 'suzuki taro1'
     *
     */
    public function testWhereBetweenAge()
    {
        $result = $this->sql->select()->table("users")->between("age",10,30)->exec();
        $this->assertSame("suzuki taro1", $result[0]["name"]);
    }


    /**
     * テーブルがサブクエリのSELECT文
     *
     * SELECT * FROM (SELECT * FROM users WHERE id = 1) u'
     *
     */
    public function testSelectFromUsers_tableSubquery()
    {
        $result = $this->sql->select()->table(
            fn ($query) => $query->select()->table("users")->where("id", 1)->andWhere("id",1),
            "u"
        )->where("name","suzuki taro1")->exec();
        $this->assertSame("suzuki taro1", $result[0]["name"]);
    }

    /**
     * WHERE句にグループクエリがあるSELECT文
     *
     * SELECT * FROM users WHERE ( id = 1 AND age = 20)
     *
     */
    public function testSelectFromUsers_whereGroup()
    {
        $result = $this->sql->select()->table("users")->where(
            fn ($query) => $query->where("id", 1)->andWhere("age",20)
            )->exec();
        $this->assertSame("suzuki taro1", $result[0]["name"]);
    }

    /**
     * WHERE句にサブクエリがあるSELECT文
     *
     * 
     *
     */
    public function testSelectFromUsers_whereSubquery()
    {
        $result = $this->sql->select()->table("users")->where(
            fn ($query) => $query->where("id", 1)->andWhere("age",20)
            )->exec();
        $this->assertSame("suzuki taro1", $result[0]["name"]);
    }

}
