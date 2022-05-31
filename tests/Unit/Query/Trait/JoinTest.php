<?php

declare(strict_types=1);

namespace Tests\Unit\Query\Trait;

use Src\Query\Trait\Join;
use Src\Query\SubQuery;
use Src\Query\Expression;
use PHPUnit\Framework\TestCase;

class JoinBeings
{
    use Join;

    public function testBuildJoin()
    {
        return $this->buildJoin();
    }
}
class JoinTest extends TestCase
{
    /**
     * シンプルな結合条件のJOIN
     *
     */
    public function testNomalConditionJoinTable()
    {
        $obj = new JoinBeings();
        $obj->join("employees", "user.id", "employees.user_id");
        $data = $obj->testBuildJoin();
        $this->assertSame(" employees ON user.id = employees.user_id  ", $data["sql"]);
    }

    /**
     * JOINの結合条件がクロージャ
     *
     */
    public function testClosureConditionJoinTable()
    {
        $obj = new JoinBeings();
        $obj->join("employees", fn ($query) => $query->on("user.id", "employees.user_id"));
        $data = $obj->testBuildJoin();
        $this->assertSame(" employees ON user.id = employees.user_id  ", $data["sql"]);
    }

    /**
     * JOINの結合条件が複数
     *
     */
    public function testMultipleConditionJoinTable()
    {
        $obj = new JoinBeings();
        $obj->join("employees", fn ($query) => $query->on("user.id", "employees.user_id")->where("mail", "suzuki_taro1@examole.com"));
        $data = $obj->testBuildJoin();
        $this->assertSame(" employees ON user.id = employees.user_id AND mail  = ?   ", $data["sql"]);
        $this->assertSame(["suzuki_taro1@examole.com"], $data["params"]);
    }
}
