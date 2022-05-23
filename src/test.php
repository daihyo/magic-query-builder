<?php

declare(strict_types=1);

namespace Src;

require_once "vendor/autoload.php";

use Src\Query;

$db = DB::conn();
$sql = (new Query($db));

$_ = [];
// $_[] = $sql->select()->table("users")->exec();

// $_[] = $sql->select()->where("a")->where("a")->table("a");

// $_[] = $sql->select()->table("users","u")->exec();

$_[] = $sql->select()->table("users","u")->where("name","3")->exec();

// $_[] = $sql->select()->table(fn($query) => $query->select(["id"])->table("users"),"u")->exec();

// $_[] = $sql->select()->table("users","u")->where()->exec();

// $_[] = $sql->select()->table(fn($query) => $query->select()->table("users")->where("id", "=", 1),"u")->exec();

var_dump(array_map(fn($sql)=>var_dump($sql),$_));
