<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
use App\Container;
use App\Controllers\Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$container = new Container();
$router = new Router($container);



echo'Hello from index'. PHP_EOL;