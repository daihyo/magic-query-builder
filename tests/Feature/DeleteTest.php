<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\DB;
use Src\Query;
use PHPUnit\Framework\TestCase;

class DeleteTest extends TestCase
{
    private Query $sql;

    public function setUp(): void
    {
        $db = DB::conn();
        $this->sql = (new Query($db));
        // echo "setUp\n";
    }

    /**
     * DELETE文
     *
     * DELETE FROM users WHERE id = 1
     *
     */
    public function testDeleteUserId1()
    {
        // Previous UPDATE
        $result = $this->sql->select()->table("users")->where("id", 1)->exec();
        $this->assertSame("suzuki taro1", $result[0]["name"]);
        $this->assertSame(20, $result[0]["age"]);

        // After UPDATE
        $this->sql->delete("users")->where("id", 1)->exec();
        $result = $this->sql->select()->table("users")->where("id", 1)->exec();
        $this->assertFalse(isset($result[0]));
    }


    /**
     * DELETE文(transaction-rollBack)
     *
     * DELETE FROM users WHERE id = 1
     *
     */
    public function testDeleteUserId1UseTransactionRollback()
    {
        $result = $this->sql->select()->table("users")->where("id", 2)->exec();
        $this->assertSame("suzuki taro2", $result[0]["name"]);

        // start transaction
        $this->sql->transaction();
        $this->sql->delete("users")->where("id", 2)->exec();
        $result = $this->sql->select()->table("users")->where("id", 2)->exec();
        $this->assertFalse(isset($result[0]));

        // rollback
        $this->sql->rollBack();
        $result = $this->sql->select()->table("users")->where("id", 2)->exec();
        $this->assertSame("suzuki taro2", $result[0]["name"]);
    }
}
