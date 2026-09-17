<?php
$amenities = is_string($amenities)
    ? json_decode($amenities, true)
    : $amenities;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($title) ?> - NepalStay</title>
    <link rel="stylesheet" href="/Assets/CSS/style.css" />
    <link rel="stylesheet" href="/Assets/CSS/room-details.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
</head>
<body>
    <header class="inner-hero">
        <nav id="nav" class="premium-nav">
            <a href="/" id="logo" class="brand">
                <img src="/Assets/images/logo.png" alt="NepalStay Logo" />
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

    <main class="detail-shell">
        <section class="detail-main-content">
            <a href="/rooms" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Rooms
            </a>

            <p class="eyebrow">Signature Stay</p>
            <h1 id="room-title-display"><?= htmlspecialchars($title) ?></h1>

            <div class="price-badge">
                <span id="room-price-display">NPR <?= htmlspecialchars($price) ?></span>
                / night
            </div>

            <div class="detail-gallery">
                <div class="main-img-box">
                    <?php if (!empty($images)): ?>
                        <img
                            id="main-detail-img"
                            src="<?= htmlspecialchars($images[0]['image_path']) ?>"
                            alt="<?= htmlspecialchars($title) ?>"
                        />
                    <?php endif; ?>
                </div>
                <div class="thumb-box">
                    <?php foreach ($images as $image): ?>
                        <img
                            src="<?= htmlspecialchars($image['image_path']) ?>"
                            alt="<?= htmlspecialchars($title) ?>"
                            onclick="document.getElementById('main-detail-img').src = this.src"
                        />
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="room-long-description">
                <h2>Overview</h2>
                <p id="room-description-para"><?= htmlspecialchars($room['description']) ?></p>
            </div>

            <div class="amenities-checklist-section">
                <h2>Amenities</h2>
                <div class="checklist-grid">
                    <?php foreach ($amenities as $amenity): ?>
                        <div>
                            <i class="fa-solid fa-check"></i>
                            <?= htmlspecialchars($amenity) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <aside class="booking-sidebar">
            <div class="reservation-card">
                <h3>Reserve <?= htmlspecialchars($title) ?></h3>
                <form class="sidebar-form" action="/booking" method="POST">
                    <input
                        type="hidden"
                        name="room_id"
                        value="<?= (int) $room['id'] ?>"
                    >

                    <div class="input-group">
                        <label for="check_in">Check-In</label>
                        <input type="date" id="check_in" name="check_in" required>
                    </div>

                    <div class="input-group">
                        <label for="check_out">Check-Out</label>
                        <input type="date" id="check_out" name="check_out" required>
                    </div>

                    <div class="input-group">
                        <label for="num_guests">Guests</label>
                        <select id="num_guests" name="num_guests" required>
                            <?php for ($i = 1; $i <= $capacity; $i++): ?>
                                <option value="<?= $i ?>">
                                    <?= $i ?> <?= $i === 1 ? 'Guest' : 'Guests' ?>
                                </option>
                            <?php endfor; ?>
                        </select>
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

                <div class="card-guarantee">
                    <p><i class="fa-solid fa-shield-halved"></i> Best Price Guarantee</p>
                    <p><i class="fa-solid fa-rotate-left"></i> Free cancellation up to 48 hours prior</p>
                </div>
            </div>
        </aside>
    </main>
</body>
</html>
