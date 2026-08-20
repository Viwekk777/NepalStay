<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
use App\Container;
use App\Controllers\BookingController;
use App\Controllers\Router;
use App\Controllers\HomeController;
use App\Controllers\RoomController;
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
$router->registerRoutes('GET','/rooms',[RoomController::class, 'rooms']);
$router->registerRoutes('POST','/rooms',[RoomController::class,'rooms']);
$router->registerRoutes('GET', '/room', [RoomController::class, 'getRoom']);
$router->registerRoutes('GET','/about', [HomeController::class,'about']);
$router->registerRoutes('GET','/book', [BookingController::class,'book']);
$router->registerRoutes('POST','/booking', [BookingController::class,'booked']);
$router->registerRoutes('POST','/availability',[BookingController::class, 'checkAvailability']
);





$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$method = $_SERVER['REQUEST_METHOD'];



$container->get(DB::class)->getConnection();

$router ->resolve($method, $uri);