<?php use App\Auth; ?>
<?php
if (!Auth::check()) {
    header('Location: /login');
    exit();
}

$name = isset($user['name']) ? (string) $user['name'] : ('User ' . (Auth::userId() ?? ''));
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Bookings - NepalStay</title>
    <link rel="stylesheet" href="/Assets/CSS/style.css" />
    <style>
        .bookings-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 120px 20px 48px;
        }

        .bookings-header {
            margin-bottom: 24px;
            color: #fff;
            text-shadow: 0 2px 6px #000;
        }

        .bookings-header h1 {
            color: var(--main-color);
            font-family: var(--main-font);
            margin-bottom: 8px;
        }

        .booking-card {
            background: rgba(0, 0, 0, 0.9);
            border: 2px solid var(--main-color);
            color: #fff;
            padding: 20px;
            margin-bottom: 16px;
        }

        .booking-card h3 {
            color: var(--main-color);
            font-family: var(--main-font);
            margin-bottom: 12px;
        }

        .booking-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 10px 16px;
        }

        .booking-grid p {
            margin: 0;
        }

        .booking-grid strong {
            color: var(--main-color);
        }
    </style>
</head>
<body>
    <main class="bookings-wrap">
        <div class="bookings-header">
            <h1>My Bookings</h1>
            <p><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></p>
        </div>

        <?php if (empty($bookings)): ?>
            <p>No bookings found.</p>
        <?php else: ?>
            <?php foreach ($bookings as $booking): ?>
                <div class="booking-card">
                    <h3><?= htmlspecialchars((string) $booking['room_title'], ENT_QUOTES, 'UTF-8') ?></h3>
                    <div class="booking-grid">
                        <p><strong>Check-in:</strong> <?= htmlspecialchars((string) $booking['check_in'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p><strong>Check-out:</strong> <?= htmlspecialchars((string) $booking['check_out'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p><strong>Guests:</strong> <?= (int) $booking['num_guests'] ?></p>
                        <p><strong>Total Price:</strong> NPR <?= htmlspecialchars(number_format((float) $booking['total_price'], 2), ENT_QUOTES, 'UTF-8') ?></p>
                        <p><strong>Status:</strong> <?= htmlspecialchars((string) $booking['status'], ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
</body>
</html>
