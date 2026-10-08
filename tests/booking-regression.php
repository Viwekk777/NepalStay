<?php
declare(strict_types=1);

namespace {
    if (is_file(__DIR__ . '/../vendor/autoload.php')) {
        require __DIR__ . '/../vendor/autoload.php';
    } else {
        spl_autoload_register(function (string $class): void {
            $path = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
            if (is_file($path)) {
                require $path;
            }
        });
    }
}

namespace Psr\Container {
    if (!interface_exists(ContainerInterface::class)) {
        interface ContainerInterface {
            public function get(string $id);
            public function has(string $id): bool;
        }
    }
}

namespace {
    use App\Container;
    use App\Controllers\BookingController;
    use App\Controllers\Router;
    use App\Exceptions\RouteNotFoundException;
    use App\Models\Booking;
    use App\Models\DB;
    use App\Models\Rooms;

    set_error_handler(function (int $severity, string $message, string $file, int $line): never {
        throw new ErrorException($message, 0, $severity, $file, $line);
    });

    function check(bool $condition, string $message): void {
        if (!$condition) {
            throw new RuntimeException($message);
        }
    }

    function capture(callable $action): string {
        ob_start();
        try {
            $action();
            return (string) ob_get_contents();
        } finally {
            ob_end_clean();
        }
    }

    $db = new DB('sqlite::memory:', '', '');
    $pdo = $db->getConnection();
    $pdo->exec("CREATE TABLE rooms (id INTEGER PRIMARY KEY, title TEXT, price REAL, capacity INTEGER, description TEXT, amenities TEXT)");
    $pdo->exec("CREATE TABLE room_images (id INTEGER PRIMARY KEY, room_id INTEGER, image_path TEXT, is_primary INTEGER)");
    $pdo->exec("CREATE TABLE bookings (
        id INTEGER PRIMARY KEY AUTOINCREMENT, room_id INTEGER, guest_name TEXT,
        guest_email TEXT, guest_phone TEXT, num_guests INTEGER, check_in TEXT,
        check_out TEXT, total_price REAL, status TEXT, user_id INTEGER,
        created_at TEXT DEFAULT CURRENT_TIMESTAMP
    )");
    $pdo->exec("INSERT INTO rooms VALUES (1, 'Mountain Suite', 1500, 2, 'A quiet room', '[]')");
    $rooms = new Rooms($db);
    $bookings = new Booking($db);
    $controller = new BookingController($rooms, $bookings);
    $_SESSION = [];
    $_GET = [];
    $_SERVER['SCRIPT_NAME'] = '/Public/index.php';

    // Execute the actual route registrations from the front controller without loading production .env.
    $container = new Container();
    $container->set(BookingController::class, fn() => $controller);
    $router = new Router($container);
    $frontController = file_get_contents(__DIR__ . '/../Public/index.php');
    $start = strpos($frontController, "\$router->registerRoutes");
    $end = strpos($frontController, "\$uri =");
    check($start !== false && $end !== false, 'Could not locate application routes.');
    preg_match_all('/^use [^;]+;/m', $frontController, $imports);
    eval(implode("\n", $imports[0]) . "\n" . substr($frontController, $start, $end - $start));

    foreach (['/booking', '/booking/', '/book', '/Public/booking'] as $path) {
        http_response_code(200);
        $html = capture(fn() => $router->resolve('GET', $path));
        check(str_contains($html, 'Choose a room') && str_contains($html, 'Mountain Suite'), 'GET booking route must render a room selector.');
        check(http_response_code() === 200, 'Booking page should return 200.');
    }

    $zone = new DateTimeZone('Asia/Kathmandu');
    $arrival = (new DateTime('tomorrow', $zone))->format('Y-m-d');
    $departure = (new DateTime('+3 days', $zone))->format('Y-m-d');
    $_GET = ['room_id' => '1', 'check_in' => $arrival, 'check_out' => $departure, 'num_guests' => '2'];
    $html = capture(fn() => $controller->book());
    check(str_contains($html, 'value="1" selected') && str_contains($html, $arrival), 'Selected room and dates must be prefilled.');

    $valid = [
        'room_id' => '1', 'check_in' => $arrival, 'check_out' => $departure,
        'num_guests' => '2', 'guest_name' => 'Test Guest',
        'guest_email' => 'guest@example.test', 'guest_phone' => '+977 980-1234567'
    ];
    $cases = [
        [[], 'Please choose a room'],
        [array_replace($valid, ['guest_phone' => []]), 'valid phone'],
        [array_replace($valid, ['guest_email' => '<script>bad</script>']), 'valid email'],
        [array_replace($valid, ['check_in' => '2099-02-30']), 'valid check-in'],
        [array_replace($valid, ['check_in' => "2099-01\0-01"]), 'valid check-in'],
        [array_replace($valid, ['check_in' => '2000-01-01']), 'in the past'],
        [array_replace($valid, ['check_out' => $arrival]), 'after check-in'],
        [array_replace($valid, ['num_guests' => '0']), 'at least one guest'],
        [array_replace($valid, ['num_guests' => '3']), 'exceeds room capacity'],
        [array_replace($valid, ['room_id' => '99']), 'no longer exists'],
    ];
    foreach ($cases as [$input, $message]) {
        $_POST = $input;
        http_response_code(200);
        $html = capture(fn() => $router->resolve('POST', '/booking'));
        check(http_response_code() === 422 && str_contains($html, $message), 'Invalid submission should render a useful 422 error: ' . $message . ' (status ' . http_response_code() . ', input ' . json_encode($input) . ')');
        check((int) $pdo->query('SELECT COUNT(*) FROM bookings')->fetchColumn() === 0, 'Invalid input must not create a booking.');
        check(!str_contains($html, '<script>bad</script>'), 'Old input must be escaped.');
    }

    $_POST = $valid;
    http_response_code(200);
    $html = capture(fn() => $router->resolve('POST', '/booking'));
    check(http_response_code() === 200, 'Valid booking should succeed.');
    check(str_contains($html, '3,000.00') && str_contains($html, 'Mountain Suite') && str_contains($html, 'Pending'), 'Receipt must display saved room, total, and status.');
    check(!str_contains($html, 'N/A'), 'Receipt must display the saved booking ID and bill.');
    $stored = $bookings->getBookingById(1);
    check($stored !== false && $stored['guest_phone'] === '+9779801234567' && $stored['user_id'] === null, 'Guest booking must preserve nullable user and normalized phone.');
    check((float) $stored['total_price'] === 3000.0, 'Price must use server-side room rate.');

    $_POST = $valid;
    $html = capture(fn() => $controller->booked());
    check(http_response_code() === 422 && str_contains($html, 'not available'), 'Overlapping booking must be rejected.');
    check((int) $pdo->query('SELECT COUNT(*) FROM bookings')->fetchColumn() === 1, 'Rejected overlap must not insert a booking.');
    check($bookings->checkAvailability(1, new DateTime($departure), new DateTime('+5 days', $zone)), 'Back-to-back stays must remain available.');

    $_POST = ['check_in' => $arrival, 'check_out' => $departure, 'num_guests' => '2'];
    $html = capture(fn() => $controller->checkAvailability());
    check(str_contains($html, 'No rooms are available'), 'Unavailable search needs an empty-state message.');
    $_POST['num_guests'] = '0';
    $html = capture(fn() => $controller->checkAvailability());
    check(http_response_code() === 422 && str_contains($html, 'at least one guest'), 'Availability search must reject invalid guest counts.');

    $pdo->exec("UPDATE bookings SET status = 'cancelled' WHERE id = 1");
    check($bookings->checkAvailability(1, new DateTime($arrival), new DateTime($departure)), 'Cancelled stays must not block availability.');
    $_SESSION['user_id'] = 42;
    $_POST = $valid;
    capture(fn() => $controller->booked());
    check(count($bookings->getBookingsByUserId(42)) === 1, 'Signed-in booking must link to user history.');

    $router->get('/health-test', fn() => 'ok');
    check($router->resolve('GET', '/health-test') === 'ok', 'Callable routes must still work.');
    try {
        $router->resolve('GET', '/missing');
        throw new RuntimeException('Missing route did not throw.');
    } catch (RouteNotFoundException $e) {
        // Missing routes should not emit undefined-array/destructuring warnings.
    }
    echo "Booking regression checks passed.\n";
}
