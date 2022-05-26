# [WIP]simple php query builder
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
        // SELECT * FROM users WHERE id = 1
        return $this->sql->select()->table("users")->where("id", 1)->exec();
    }
}
```

### SELECT Example

### UPDATE Example

### INSERT Example

### DELETE Example

## Licence
MIT
