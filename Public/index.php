<?php

declare(strict_types=1);

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once __DIR__ . '/../vendor/autoload.php';
use App\Container;
use App\Controllers\BookingController;
use App\Controllers\Router;
use App\Controllers\HomeController;
use App\Controllers\RoomController;
use App\Controllers\UserController;
use App\Models\DB;
use App\Models\Booking;
use App\Models\User;
use App\Models\Rooms;
use App\Services\Mailer;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$container = new Container();

$container->set(DB::class, fn() => new DB
(
     dsn: "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset=utf8mb4",
    username: $_ENV['DB_USER'],
    password: $_ENV['DB_PASS']

));

$container->set(PDO::class, fn(Container $c) => $c->get(DB::class)->getConnection());
$container->set(User::class, fn(Container $c) => new User($c->get(PDO::class)));
$container->set(Booking::class, fn(Container $c) => new Booking($c->get(DB::class)));
$container->set(Mailer::class, fn() => new Mailer());




$router = new Router($container);

$router->registerRoutes('GET','/',[HomeController::class,'home']);
$router->registerRoutes('GET','/rooms',[RoomController::class, 'rooms']);
$router->registerRoutes('POST','/rooms',[RoomController::class,'rooms']);
$router->registerRoutes('GET', '/room', [RoomController::class, 'getRoom']);
$router->registerRoutes('GET','/about', [HomeController::class,'about']);
$router->registerRoutes('GET','/book', [BookingController::class,'book']);
$router->registerRoutes('POST','/booking', [BookingController::class,'booked']);
$router->registerRoutes('POST','/availability',[BookingController::class, 'checkAvailability']);
$router->registerRoutes('GET','/register', [UserController::class, 'register']);
$router->registerRoutes('POST','/register', [UserController::class, 'register']);
$router->registerRoutes('GET','/login', [UserController::class, 'login']);
$router->registerRoutes('POST','/login', [UserController::class, 'login']);
// Logout should be a POST route to avoid accidental logouts via links
$router->registerRoutes('POST','/logout', [UserController::class, 'logout']);
$router->registerRoutes('GET','/logout', [UserController::class, 'logout']);

$router->registerRoutes('GET','/profile', [UserController::class, 'profile']);
$router->registerRoutes('GET','/my-bookings', [UserController::class, 'myBookings']);
$router->registerRoutes('GET','/edit-profile', [UserController::class, 'editProfile']);
$router->registerRoutes('POST','/edit-profile', [UserController::class, 'editProfile']);
$router->registerRoutes('GET','/verify-email-change', [UserController::class, 'verifyEmailChange']);
$router->registerRoutes('POST','/verify-email-change', [UserController::class, 'verifyEmailChange']);


$router->registerRoutes('GET','/verify', [UserController::class, 'verifyUser']);
$router->registerRoutes('POST','/verify', [UserController::class, 'verifyUser']);





$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$method = $_SERVER['REQUEST_METHOD'];



$container->get(DB::class)->getConnection();

$router ->resolve($method, $uri);