<?php
declare(strict_types=1);
namespace CmpDate;
require '../vendor/autoload.php';
// Run app
$app = (new \CmpDate\Api())->get();
$app->run();
