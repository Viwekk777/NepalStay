<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Booking - NepalStay</title>
    <link rel="stylesheet" href="/Assets/CSS/style.css">
</head>
<body>
    <header class="inner-hero short">
        <nav id="nav" class="premium-nav">
            <a href="/" id="logo" class="brand">
                <img src="/Assets/images/logo.png" alt="NepalStay Logo">
                <div class="brand-text">
                    <span class="brand-name">NepalStay</span>
                    <span class="brand-tag">Boutique Himalayan Retreats</span>
                </div>
            </a>
            <div id="links" class="nav-links">
                <a href="/">Home</a>
                <a href="/rooms">Rooms</a>
                <a href="/about">About</a>
                <a href="/contact">Contact</a>
            </div>
        </nav>
    </header>

    <main class="page-shell">
        <section class="form-card">
            <p class="eyebrow">Reservation</p>
            <h1>Complete Your Booking</h1>

            <form action="/booking" method="POST" class="stack-form">
                <input type="hidden" name="room_id" value="<?= (int) $roomId ?>">

                <div class="input-group">
                    <label for="check_in">Check-In</label>
                    <input
                        type="date"
                        id="check_in"
                        name="check_in"
                        value="<?= htmlspecialchars($checkIn) ?>"
                        required
                    >
                </div>

                <div class="input-group">
                    <label for="check_out">Check-Out</label>
                    <input
                        type="date"
                        id="check_out"
                        name="check_out"
                        value="<?= htmlspecialchars($checkOut) ?>"
                        required
                    >
                </div>

                <div class="input-group">
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

                <div class="input-group">
                    <label for="guest_name">Full Name</label>
                    <input type="text" id="guest_name" name="guest_name" required>
                </div>

                <div class="input-group">
                    <label for="guest_email">Email</label>
                    <input type="email" id="guest_email" name="guest_email" required>
                </div>

                <div class="input-group">
                    <label for="guest_phone">Phone</label>
                    <input type="tel" id="guest_phone" name="guest_phone" required>
                </div>

                <button type="submit" class="instant-book-btn">Confirm Booking</button>
            </form>
        </section>
    </main>
</body>
</html>