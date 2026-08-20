<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
use App\Container;
use App\Controllers\Router;
use App\Controllers\HomeController;
use App\Models\DB;
use App\Models\Rooms;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$container = new Container();

$container->set(DB::class, fn() => new DB
(
     dsn: "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8mb4",
    username: $_ENV['DB_USER'],
    password: $_ENV['DB_PASS']

));




$router = new Router($container);

$router->registerRoutes('GET','/',[HomeController::class,'home']);
$router->registerRoutes('GET', '/index', [HomeController::class, 'index']);
$router->registerRoutes(
    'GET',
    '/rooms',
    [HomeController::class, 'rooms']
);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$method = $_SERVER['REQUEST_METHOD'];



$container->get(DB::class)->getConnection();

$router ->resolve($method, $uri);