<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

class InsertTest extends TestCase
{

    public function testInsert()
    {
        $this->assertTrue(true);
    }
    /**
     * //////users TABLE//////
     *
     * id (int, PK, auto_increment)
     * name (text)
     * age (int)
     * gender (int 1:male,2:female,99:other)
     *
     */
    // INSERT INTO users VALUES (0, "suzuki taro" , 35, 1);


    /**
     * //////employees TABLE//////
     *
     * id (int, PK, auto_increment)
     * mail (text)
     * user_id (int)
     *
     */
    // INSERT INTO employees VALUES (0, "suzuki_taro@example.com" , 1);
}
