<?php

declare(strict_types=1);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Booking Confirmed - NepalStay</title>

    <link
        rel="stylesheet"
        href="/Assets/CSS/style.css"
    >

</head>

<body>

    <main>

        <section>

            <h1>
                Booking Confirmed!
            </h1>

            <p>
                Welcome, <?= htmlspecialchars($guestName) ?>.
            </p>

            <p>
                Your room has been successfully booked with NepalStay.
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
                Confirmed
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