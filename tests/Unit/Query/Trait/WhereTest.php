<?php

declare(strict_types=1);

namespace Tests\Unit\Query\Trait;

use Src\Query\Trait\Where;
use Src\Query\SubQuery;
use PHPUnit\Framework\TestCase;

class WhereBeings
{
    use Where;

    public function testBuildWhere()
    {
        return $this->buildWhere();
    }
}


class WhereTest extends TestCase
{
    /**
     * simple where search
     */
    public function testSimpleWhere()
    {
        $obj = new WhereBeings();
        $obj->where("name", "suzuki taro1");
        $data = $obj->buildWhere();
        $this->assertSame(" name  = ?  ", $data["sql"]);
        $this->assertSame(["suzuki taro1"], $data["params"]);
    }

    /**
     * logic group
     */
    public function testLogicalGroupWhere()
    {
        $obj = new WhereBeings();
        $obj->where("name", "suzuki taro1")->where(fn ($query) => $query->where("id", 1)->where("age", 30, ">"));
        $data = $obj->buildWhere();
        $this->assertSame(" name  = ?    ( id  = ?  AND age  > ?  ) ", $data["sql"]);
        $this->assertSame(["suzuki taro1",1,30], $data["params"]);
    }

    /**
     * correlation subquery
     */
    public function testSubqueryWhere()
    {
        $obj = new WhereBeings();
        $obj->where("id", fn ($query) => $query->select(["user_id"])->table("employees")->where("mail", "suzuki_taro1@examole.com"))->where("age", 30);
        $data = $obj->buildWhere();
        $this->assertSame(" id =  (SELECT user_id FROM employees  WHERE  mail  = ?  ) AND age  = ?  ", $data["sql"]);
        $this->assertSame(["suzuki_taro1@examole.com",30], $data["params"]);
    }

    /**
     * between
     */
    public function testBetweenWhere()
    {
        $obj = new WhereBeings();
        $obj->between("age", 20, 30)->where("id", 1);
        $data = $obj->buildWhere();
        $this->assertSame(" age BETWEEN ? AND ? AND id  = ?  ", $data["sql"]);
        $this->assertSame([20,30,1], $data["params"]);
    }

    /**
     * in
     */
    public function testInWhere()
    {
        $obj = new WhereBeings();
        $obj->in("age", [20,30])->where("id", 1);
        $data = $obj->buildWhere();
        $this->assertSame(" age IN  (  ? , ?  )  AND id  = ?  ", $data["sql"]);
        $this->assertSame([20,30,1], $data["params"]);
    }

    /**
     * in use subquery
     */
    public function testInSubqueryWhere()
    {
        $obj = new WhereBeings();
        $obj->in("id", fn ($query) => $query->select(["user_id"])->table("employees")->where("mail", "suzuki_taro1@examole.com"));
        $data = $obj->buildWhere();
        $this->assertSame(" id  IN (SELECT user_id FROM employees  WHERE  mail  = ?  ) ", $data["sql"]);
        $this->assertSame(["suzuki_taro1@examole.com"], $data["params"]);
    }

    /**
     * is null
     */
    public function testIsNullWhere()
    {
        $obj = new WhereBeings();
        $obj->isNull("name");
        $data = $obj->buildWhere();
        $this->assertSame(" name IS NULL  ", $data["sql"]);
        $this->assertSame([], $data["params"]);
    }


    /**
     * Exists (and whereColumn method)
     *
     */
    public function testExistsWhere()
    {
        $obj = new WhereBeings();
        $obj->exists("id", fn ($query) => $query->select([1])->table("employees")->whereColumn("user.id", "employees.user_id"));
        $data = $obj->buildWhere();
        $this->assertSame(" id  EXISTS (SELECT 1 FROM employees  WHERE  user.id = employees.user_id ) ", $data["sql"]);
    }
}
