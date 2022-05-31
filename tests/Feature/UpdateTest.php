<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\DB;
use Src\Query;
use PHPUnit\Framework\TestCase;

class UpdateTest extends TestCase
{
    private Query $sql;

    public function setUp(): void
    {
        $db = DB::conn();
        $this->sql = (new Query($db));
        // echo "setUp\n";
    }
    /**
     * UPDATE文
     *
     * UPDATE users SET "name" = "update taro", "age" = 40 WHERE id = 1
     *
     */
    public function testUpdateUserNameAndAge()
    {
        // Previous UPDATE
        $result = $this->sql->select()->table("users")->where("id", 1)->exec();
        $this->assertSame("suzuki taro1", $result[0]["name"]);
        $this->assertSame(20, $result[0]["age"]);

        // After UPDATE
        $result = $this->sql->update("users")->set(["name"=>"update taro","age"=>40])->where("id", 1)->exec();
        $result = $this->sql->select()->table("users")->where("id", 1)->exec();
        $this->assertSame("update taro", $result[0]["name"]);
        $this->assertSame(40, $result[0]["age"]);
    }
}
