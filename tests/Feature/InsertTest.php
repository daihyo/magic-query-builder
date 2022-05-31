<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\DB;
use Src\Query;
use PHPUnit\Framework\TestCase;

class InsertTest extends TestCase
{
    private Query $sql;

    public function setUp(): void
    {
        $db = DB::conn();
        $this->sql = (new Query($db));
        // echo "setUp\n";
    }

    /**
     * INSERT文
     *
     * INSERT INTO users VALUES (0, "insert taro" , 55, 1);
     *
     */
    public function testInsertNewUser()
    {
        $result = $this->sql->insert("users")->into(["name"=>"insert taro","age"=>55,"gender"=>1])->exec();
        $result = $this->sql->select()->table("users")->where("name", "insert taro")->exec();
        $this->assertSame("insert taro", $result[0]["name"]);
    }
}
