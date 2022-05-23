<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase
{


    // SELECT * FROM users ;

    // SELECT id,name,age FROM users ;

    // SELECT * FROM users WHERE id = 1;

    // SELECT * FROM users WHERE id <> 1;

    // SELECT * FROM users WHERE gender = 1 AND (name LIKE "suzuki%" AND age < 50);

    // SELECT * FROM users WHERE id IN (1,2,3) ORDER BY id DESC;

    // SELECT * FROM users WHERE id IN (1,2,3) ORDER BY id DESC LIMIT 1,2;


    // SELECT * FROM users WHERE id IN (1,2,3);

    // SELECT * FROM users WHERE id IN (SELECT user_id FROM employees WHERE id IN (1,2,3));

    // SELECT * FROM users WHERE id BETWEEN 2 AND 4;
    
    // SELECT * FROM users WHERE id BETWEEN 2 AND 4;

    // SELECT * FROM users WHERE age IS NULL;

    // SELECT * FROM users WHERE id exists (SELECT * FROM employees WHERE employees.user_id = users.id);

    // SELECT * FROM users INNER JOIN employees ON users.id = employees.user_id;

    // SELECT * FROM users INNER JOIN (SELECT * FROM employees WHERE mail = "suzuki_taro@example.com") as M ON users.id = M.user_id;


}