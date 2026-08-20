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

    <title>
        <?= htmlspecialchars($title) ?> - Nepal Stay Project
    </title>

    <link rel="stylesheet" href="../Assets/CSS/annapurna.css" />
    <link rel="stylesheet" href="../Assets/CSS/style.css" />

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
</head>

<body>

    <div id="detail-header">

        <nav id="nav">

            <a href="/" id="logo">
                <img
                    src="../images/ChatGPT Image May 29, 2026, 08_27_52 PM.png"
                    alt="NepalStay Logo"
                />
            </a>

            <div id="links">

                <a href="/">
                    HOME
                </a>

                <a href="/rooms" class="active-page">
                    ROOMS
                </a>

                <a href="/about">
                    ABOUT
                </a>

                <a href="/contact">
                    CONTACT
                </a>

            </div>

        </nav>

    </div>


    <main class="detail-container">

        <section class="detail-main-content">

            <a href="/rooms" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Rooms
            </a>


            <h3 id="room-category-label">
                LUXURY / CROWN JEWEL
            </h3>


            <h1 id="room-title-display">
                <?= htmlspecialchars($title) ?>
            </h1>


            <div class="price-badge">

                <span id="room-price-display">
                    NPR <?= htmlspecialchars($price) ?>
                </span>

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
                            onclick="
                                document.getElementById('main-detail-img').src = this.src
                            "
                        />

                    <?php endforeach; ?>

                </div>

            </div>


            <div class="room-long-description">

                <h2>
                    Overview
                </h2>

                <p id="room-description-para">
                    <?= htmlspecialchars($room['description']) ?>
                </p>

            </div>


            <div class="amenities-checklist-section">

                <h2>
                    What this ultra-luxury room offers
                </h2>


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

                <h3>
                    Reserve <?= htmlspecialchars($title) ?>
                </h3>


                <form
                    class="sidebar-form"
                    onsubmit="
                        event.preventDefault();

                        alert(
                            'Thank you for reserving <?= htmlspecialchars($title, ENT_QUOTES) ?>!'
                        );
                    "
                >

                    <div class="input-group">

                        <label>
                            CHECK-IN
                        </label>

                        <input
                            type="date"
                            required
                        />

                    </div>


                    <div class="input-group">

                        <label>
                            CHECK-OUT
                        </label>

                        <input
                            type="date"
                            required
                        />

                    </div>


                    <div class="input-group">

                        <label>
                            GUESTS
                        </label>


                        <select>

                            <?php for ($i = 1; $i <= $capacity; $i++): ?>

                                <option>

                                    <?= $i ?>

                                    <?= $i === 1 ? 'Guest' : 'Guests' ?>

                                </option>

                            <?php endfor; ?>

                        </select>

                    </div>


                    <button
                        type="submit"
                        class="instant-book-btn"
                    >
                        PROCEED TO CONFIRM
                    </button>

                </form>


                <div class="card-guarantee">

                    <p>
                        <i class="fa-solid fa-shield-halved"></i>
                        Best Price Guarantee
                    </p>


                    <p>
                        <i class="fa-solid fa-rotate-left"></i>
                        Free cancellation up to 48 hours prior
                    </p>

                </div>

            </div>

        </aside>

    </main>


    <footer>

        <div id="summary">

            <h1>
                NepalStay
            </h1>

            <h3>
                A luxury boutique hotel nestled in Lakeside, Pokhara.
                Where Himalayan beauty meets heartfelt Nepali hospitality.
            </h3>

        </div>


        <div id="quick_links">

            <h2>
                <a href="/">
                    Home
                </a>
            </h2>

            <h2>
                <a href="/rooms">
                    Rooms
                </a>
            </h2>

            <h2>
                <a href="/about">
                    About us
                </a>
            </h2>

            <h2>
                <a href="/contact">
                    Contact
                </a>
            </h2>

        </div>


        <div id="contact">

            <div>
                <h2>
                    Lakeside-6, Pokhara, Gandaki Province, Nepal
                </h2>
            </div>

            <div>
                <h2>
                    +977-061-XXXXXX
                </h2>
            </div>

            <div>
                <h2>
                    info@nepalstay.com
                </h2>
            </div>

        </div>


        <div id="copyright">

            <h2>
                © 2025 NepalStay.
                All rights reserved.
                | Lakeside, Pokhara, Nepal
            </h2>

        </div>

    </footer>

</body>

</html>