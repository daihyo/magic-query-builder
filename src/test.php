<?php
declare(strict_types=1);

namespace Src;

require_once "vendor/autoload.php";

use Src\Query;

$db = DB::conn();
$a = (new Query($db));

$a->select()->orderBy($bbb)->table("aaa");

