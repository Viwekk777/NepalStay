<?php use App\Auth; ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nepal stay project</title>

    <link rel="stylesheet" href="/Assets/CSS/style.css" />
    <script src="/Assets/JS/main.js" defer></script>

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
      integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
  </head>

  <body>
    <header class="home-hero">
      <nav id="nav" class="premium-nav">
        <a href="/" id="logo" class="brand">
          <img
            src="/Assets/images/logo.png"
            alt="NepalStay logo"
          />
          <div class="brand-text">
            <span class="brand-name">NepalStay</span>
            <span class="brand-tag">Boutique Himalayan Retreats</span>
          </div>
        </a>

        <?php if (Auth::check()===true): ?>
          <div id="links" class="nav-links">
            <a href="/">Home</a>
            <a href="/rooms">Rooms</a>
            <a href="/about">About</a>
            <a href="/contact">Contact</a>
            <a href="/profile">Profile</a>
            <a class="nav-cta ghost" href="/logout">Logout</a>
          </div>
        <?php else :?>
          <div id="links" class="nav-links">
            <a href="/">Home</a>
            <a href="/rooms">Rooms</a>
            <a href="/about">About</a>
            <a href="/contact">Contact</a>
            <a href="/register">Register</a>
            <a class="nav-cta" href="/login">Book Now</a>
          </div>
        <?php endif; ?>
      </nav>

      <section id="hero" class="hero-inner">
        <p id="location">Pokhara, Nepal</p>
        <h1 id="core">Find your serene luxury stay in the Himalayas.</h1>
        <p id="message">
          Curated mountain-view rooms, heartfelt Nepali hospitality, and
          effortless booking for your next unforgettable retreat.
        </p>
        <div id="conatiner" class="hero-actions">
          <a id="Explore_rooms" href="/rooms">Explore Rooms</a>
          <a id="our_story" href="/about">Our Story</a>
        </div>
      </section>
    </header>

    <main class="home-main">
      <section class="booking-shell">
        <form action="/availability" method="POST" id="checkout">
          <div class="book">
            <label for="check_in">Check-In</label>
            <input
              type="date"
              id="check_in"
              name="check_in"
              class="child"
              required
            />
          </div>

          <div class="book">
            <label for="check_out">Check-Out</label>
            <input
              type="date"
              id="check_out"
              name="check_out"
              class="child"
              required
            />
          </div>

          <div id="guest" class="book">
            <label for="selector">Guests</label>
            <select
              name="num_guests"
              id="selector"
              class="child"
              required
            >
              <option value="1">1 guest</option>
              <option value="2">2 guests</option>
              <option value="3">3 guests</option>
              <option value="4">4+ guests</option>
            </select>
          </div>

          <button
            type="submit"
            id="available"
            class="child"
          >
            Check Availability
          </button>
        </form>
      </section>

      <section class="rooms-section">
        <div class="section-intro">
          <p class="eyebrow">Signature Collection</p>
          <h2>Rooms crafted for calm, comfort, and mountain living.</h2>
        </div>

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

        <a class="all_rooms" href="/rooms">View All Rooms</a>
      </section>

      <section id="third" class="experience">
        <div class="why_us">
          <div id="hospitality">
            <p class="eyebrow">Why NepalStay</p>
            <h2>The NepalStay Difference</h2>
            <p>
              We blend timeless mountain character with attentive service for
              stays that feel deeply personal.
            </p>
          </div>

          <div class="reasons">
            <article class="reason">
              <i class="fa-solid fa-mountain"></i>
              <h3>Himalayan Views</h3>
              <p>
                Panoramic Annapurna scenery from rooms, terraces, and sunrise
                lounges.
              </p>
            </article>

            <article class="reason">
              <i class="fa-solid fa-utensils"></i>
              <h3>Local Cuisine</h3>
              <p>
                Fresh Nepali classics prepared daily with seasonal regional
                ingredients.
              </p>
            </article>

            <article class="reason">
              <i class="fa-solid fa-wifi"></i>
              <h3>Fast WiFi</h3>
              <p>
                Reliable high-speed internet across every room and shared
                space.
              </p>
            </article>

            <article class="reason">
              <i class="fa-solid fa-bell-concierge"></i>
              <h3>24/7 Service</h3>
              <p>
                Dedicated concierge and front desk support whenever you need
                assistance.
              </p>
            </article>
          </div>
        </div>

        <div class="flash">
          <div><strong>800+</strong><span>Happy Guests</span></div>
          <div><strong>15</strong><span>Room Types</span></div>
          <div><strong>4.9★</strong><span>Average Rating</span></div>
          <div><strong>8</strong><span>Years Experience</span></div>
        </div>
      </section>

      <section id="reviews">
        <div class="section-intro centered">
          <p class="eyebrow">Guest Reviews</p>
          <h2>Stories from memorable stays.</h2>
        </div>

        <div class="scrollbar">
          <article class="review-card">
            <div class="stars">★★★★★</div>
            <p>
              “Absolutely breathtaking views of Phewa Lake. The staff made us
              feel like royalty.”
            </p>
            <div class="reviewer">— Ramesh K., Kathmandu</div>
          </article>

          <article class="review-card">
            <div class="stars">★★★★★</div>
            <p>
              “The Himalayan Family Suite exceeded every expectation. Will be
              back next year.”
            </p>
            <div class="reviewer">— Sarah M., London</div>
          </article>

          <article class="review-card">
            <div class="stars">★★★★☆</div>
            <p>
              “Dal bhat by the lake at sunrise — a memory I'll carry forever.”
            </p>
            <div class="reviewer">— Ankit S., Mumbai</div>
          </article>
        </div>
      </section>
    </main>

    <footer>
      <div id="summary">
        <h2>NepalStay</h2>
        <p>
          A luxury boutique escape in Lakeside, Pokhara — where Himalayan beauty
          meets warm Nepali hospitality.
        </p>
      </div>

      <div id="quick_links">
        <h3>Explore</h3>
        <a href="/">Home</a>
        <a href="/rooms">Rooms</a>
        <a href="/about">About Us</a>
        <a href="/contact">Contact</a>
      </div>

      <div id="contact">
        <h3>Contact</h3>
        <p>Lakeside-6, Pokhara, Gandaki Province, Nepal</p>
        <p>+977-061-XXXXXX</p>
        <p>info@nepalstay.com</p>
        <p>Front Desk: Open 24/7</p>
      </div>

      <div id="copyright">
        <p>© 2025 NepalStay. All rights reserved.</p>
      </div>
    </footer>
  </body>
</html>