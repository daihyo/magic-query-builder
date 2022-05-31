# simple php query builder
Provides a query builder for DB engines supported by PDO.

## Features
* Easy Usage : 
* Bind Parameter : Use prepare for set of SQL, And value is stored by bind.

## Installation
download a release, or clone this repository, then map namespace to the package ```src/``` directory.

## Dependencies
This package requires PHP 8.1 or later.
For specifics, please examine the package composer.json file.

## Usage
Instantiate the Query class with PDO as an argument.
Then you can write a query.  
(The example below uses a user table for testing. Please examine ```tests/DB.php```)
```PHP
<?php

use PDO;
use Src\Query;

class Example
{
    private $sql;
    
    public function __construct(PDO $pdo)
    {
        $this->sql = new Query($pdo);
    }
    
    public function getUserData()
    {
        // SELECT * FROM users
        return $this->sql->select()->table("users")->exec();
    }
}
```

### SELECT Example

#### FROM
```PHP
// SELECT * FROM users AS u
$this->sql->select()->table("users", 'u');
```
#### FROM Subquery
```PHP
// SELECT * FROM (SELECT * FROM users WHERE id = 1) AS u
$this->sql->select()->table(
    fn ($query) => $query->select()->table("users")->where("id", 1)
    ,"u"
    )->exec();
```

#### FROM INNER JOIN
```PHP
// SELECT * FROM users INNER JOIN employees ON users.id = employees.user_id
$this->sql->select()->table("users")->join("employees", "users.id", "employees.user_id");
```

#### FROM INNER JOIN and WHERE
```PHP
// SELECT * FROM users INNER JOIN employees ON users.id = employees.user_id WHERE employees.mail = 'hoge@examole.com'
$this->sql->select()->table("users")->join("employees", 
    fn ($query) => $query->on("users.id", "employees.user_id")->where("employees.mail", "hoge@examole.com")
    );
```

#### WHERE
```PHP
// SELECT * FROM users WHERE id = 1
$this->sql->select()->table("users")->where('id',1)->exec();

// SELECT * FROM users WHERE id = 1 OR age > 40
$this->sql->select()->table("users")->where('id',1)->where('age',40,'>','OR')->exec();
```

#### WHERE Logic Group
```PHP
// SELECT * FROM users WHERE gender = 1 OR (id = 1 AND age=20)
$this->sql->select()->table("users")->where('gender',1, "=", "OR")->where(
    fn ($query) => $query->where("id", 1)->where("age", 20)
    )->exec();

```

#### WHERE Subquery
```PHP
// SELECT * FROM users WHERE id IN (SELECT users_id FROM employees WHERE mail = 'hoge@examole.com')
$this->sql->select()->table("users")->in('id',
    fn ($query) => $query->select()->table("employees")->where('mail','hoge@examole.com')
    )->exec();

```

#### Sort
```PHP
// SELECT * FROM users ORDER BY id DESC, name ASC
$this->sql->select()->table("users")->orderBy('id','DESC')->orderBy('name')->exec();
```

#### Limit
```PHP
// SELECT * FROM users LIMIT 10
$this->sql->select()->table("users")->limit(10)->exec();

// SELECT * FROM users LIMIT 10,15
$this->sql->select()->table("users")->limit(10,15)->exec();
```

### UPDATE Example
```PHP
// UPDATE users SET "name" = "update taro", "age" = 40 WHERE id = 1
$this->sql->update("users")->set(["name"=>"update taro","age"=>40])->where("id", 1)->exec();
```

### INSERT Example
```PHP
// INSERT INTO users VALUES (0, "insert taro" , 55, 1);
$this->sql->insert("users")->into(["name"=>"insert taro","age"=>55,"gender"=>1])->exec();
```

### DELETE Example
```PHP
// DELETE FROM users WHERE id = 1
$this->sql->delete("users")->where("id", 2)->exec();
```

### Transaction Example
```PHP
// start transaction
$this->sql->transaction();

$this->sql->delete("users")->where("id", 2)->exec();
$this->sql->select()->table("users")->where("name", "insert taro")->exec();
.
.
.

// commit or rollback
$this->sql->commit();
$this->sql->rollBack();

```

### Unsupported
* Outer join, Cross join, All, With, Grouping, Having, Union, Aggregate(SUM,AVG,COUNT,,,etc.), Date Type Record

## Licence
MIT
