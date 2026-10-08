<?php

declare(strict_types=1);

$bookingId = (int) $booking['id'];
$roomTitle = (string) $booking['room_title'];
$roomId = (int) $booking['room_id'];
$guestName = (string) $booking['guest_name'];
$guestEmail = (string) $booking['guest_email'];
$guestPhone = (string) $booking['guest_phone'];
$checkIn = (string) $booking['check_in'];
$checkOut = (string) $booking['check_out'];
$numGuests = (int) $booking['num_guests'];
$totalPrice = (float) $booking['total_price'];
$status = (string) $booking['status'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Reservation Received - NepalStay</title>

    <link
        rel="stylesheet"
        href="/Assets/CSS/style.css"
    >

</head>

<body>

    <main class="page-shell">

        <section>

            <h1>
                Reservation Received!
            </h1>

            <p>
                Welcome, <?= htmlspecialchars($guestName) ?>.
            </p>

            <p>
                Your reservation has been recorded with NepalStay. Please check its status below.
            </p>

        </section>


        <section>

            <h2>
                Booking Details
            </h2>

            <p>
                <strong>Booking ID:</strong>
                <?= isset($bookingId) ? (int) $bookingId : 'N/A' ?>
            </p>

            <p>
                <strong>Room:</strong>
                <?= htmlspecialchars($roomTitle ?? 'Room ' . $roomId) ?>
            </p>

            <p>
                <strong>Check-in:</strong>
                <?= htmlspecialchars($checkIn) ?>
            </p>

            <p>
                <strong>Check-out:</strong>
                <?= htmlspecialchars($checkOut) ?>
            </p>

            <p>
                <strong>Guests:</strong>
                <?= (int) $numGuests ?>
            </p>

        </section>


        <section>

            <h2>
                Guest Information
            </h2>

            <p>
                <strong>Name:</strong>
                <?= htmlspecialchars($guestName) ?>
            </p>

            <p>
                <strong>Email:</strong>
                <?= htmlspecialchars($guestEmail) ?>
            </p>

            <p>
                <strong>Phone:</strong>
                <?= htmlspecialchars($guestPhone) ?>
            </p>

        </section>


        <section>

            <h2>
                Bill
            </h2>

            <p>
                <strong>Total Price:</strong>

                NPR
                <?= isset($totalPrice)
                    ? htmlspecialchars(number_format((float) $totalPrice, 2))
                    : 'N/A'
                ?>
            </p>

            <p>
                <strong>Status:</strong>
                <?= htmlspecialchars(ucfirst($status), ENT_QUOTES, 'UTF-8') ?>
            </p>

        </section>


        <section>

            <h2>
                Thank You for Choosing NepalStay
            </h2>

            <p>
                Your booking details have been recorded successfully.
            </p>

            <a href="/">
                Return to Home
            </a>

            <br>

            <a href="/rooms">
                Browse More Rooms
            </a>

        </section>

    </main>

</body>

</html>
