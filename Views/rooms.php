<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rooms - NepalStay</title>
    <link rel="stylesheet" href="/Assets/CSS/style.css">
</head>
<body>
    <header class="inner-hero">
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
                <a class="nav-cta" href="/login">Book Now</a>
            </div>
        </nav>

        <section class="inner-headline">
            <p class="eyebrow">Stay Collection</p>
            <h1>Curated rooms for every kind of Himalayan escape.</h1>
        </section>
    </header>

    <main class="home-main">
        <section class="rooms-section">
            <div class="rooms">
                <?php foreach ($rooms as $room): ?>
                    <a class="room-link" href="/room?room_id=<?= (int) $room['id'] ?>">
                        <article class="room">
                            <?php if (!empty($room['main_image'])): ?>
                                <img
                                    src="<?= htmlspecialchars($room['main_image']) ?>"
                                    alt="<?= htmlspecialchars($room['title']) ?>"
                                >
                            <?php endif; ?>
                            <div class="contents">
                                <span class="number">
                                    Up to <?= htmlspecialchars((string) $room['capacity']) ?> Guests
                                </span>
                                <h3>
                                    <?= htmlspecialchars($room['title']) ?>
                                </h3>
                                <p>
                                    <?= htmlspecialchars($room['description']) ?>
                                </p>
                                <div class="price-row">
                                    <div class="price">
                                        <strong>NPR <?= htmlspecialchars((string) $room['price']) ?></strong>
                                        <span>/night</span>
                                    </div>
                                    <span class="view-details">View Room</span>
                                </div>
                            </div>
                        </article>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>
</html>