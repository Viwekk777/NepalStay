<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Complete Booking - NepalStay</title>

    <link rel="stylesheet" href="/Assets/CSS/style.css">
</head>

<body>

    <main>

        <h1>Complete Your Booking</h1>

        <form action="/booking" method="POST">

            <!-- Room -->
            <input
                type="hidden"
                name="room_id"
                value="<?= (int) $roomId ?>"
            >

            <!-- Booking dates -->
            <div>
                <label for="check_in">Check-in</label>

                <input
                    type="date"
                    id="check_in"
                    name="check_in"
                    value="<?= htmlspecialchars($checkIn) ?>"
                    required
                >
            </div>

            <div>
                <label for="check_out">Check-out</label>

                <input
                    type="date"
                    id="check_out"
                    name="check_out"
                    value="<?= htmlspecialchars($checkOut) ?>"
                    required
                >
            </div>

            <!-- Guests -->
            <div>
                <label for="num_guests">Guests</label>

                <input
                    type="number"
                    id="num_guests"
                    name="num_guests"
                    value="<?= (int) $numGuests ?>"
                    min="1"
                    max="<?= (int) $capacity ?>"
                    required
                >
            </div>

            <!-- Guest information -->
            <div>
                <label for="guest_name">Full Name</label>

                <input
                    type="text"
                    id="guest_name"
                    name="guest_name"
                    required
                >
            </div>

            <div>
                <label for="guest_email">Email</label>

                <input
                    type="email"
                    id="guest_email"
                    name="guest_email"
                    required
                >
            </div>

            <div>
                <label for="guest_phone">Phone</label>

                <input
                    type="tel"
                    id="guest_phone"
                    name="guest_phone"
                    required
                >
            </div>

            <button type="submit">
                Confirm Booking
            </button>

        </form>

    </main>

</body>
</html>