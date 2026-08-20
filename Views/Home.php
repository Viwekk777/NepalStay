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

    <div id="first">

      <nav id="nav">

        <a href="/" id="logo">
          <img
            src="/images/ChatGPT Image May 29, 2026, 08_27_52 PM.png"
            alt=""
          />
        </a>

        <div id="links">
          <a href="/">HOME</a>
          <a href="/rooms">ROOMS</a>
          <a href="/about">ABOUT</a>
          <a href="/contact">CONTACT</a>
        </div>

      </nav>

      <div id="hero">

        <div id="location">
          POKHARA , NEPAL
        </div>

        <div id="core">
          Experience Luxury in the Heart of Nepal
        </div>

        <div id="message">
          Where Himalayan serenity meets world-class comfort. Your perfect
          retreat awaits.
        </div>

        <div id="conatiner">

          <a id="Explore_rooms" href="/rooms">
            Explore rooms
          </a>

          <a id="our_story" href="/about">
            Our story
          </a>

        </div>

      </div>

      <div id="blue"></div>

    </div>


<form action="/availability" method="POST" id="checkout">

    <div class="book">
        <label for="check_in">CHECK-IN</label>

        <input
            type="date"
            id="check_in"
            name="check_in"
            class="child"
            required
        />
    </div>


    <div class="book">
        <label for="check_out">CHECK-OUT</label>

        <input
            type="date"
            id="check_out"
            name="check_out"
            class="child"
            required
        />
    </div>


    <div id="guest" class="book">

        <label for="num_guests">
            GUESTS
        </label>

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
        CHECK AVAILABILITY
    </button>

</form>


      <div class="rooms">

        <?php foreach ($rooms as $room): ?>

          <a href="/room?room_id=<?= (int) $room['id'] ?>">

            <div class="room">

              <?php if (!empty($room['main_image'])): ?>

                <img
                  src="<?= htmlspecialchars($room['main_image']) ?>"
                  alt="<?= htmlspecialchars($room['title']) ?>"
                >

              <?php endif; ?>


              <div class="contents">

                <div class="number">
                  <?= htmlspecialchars((string) $room['capacity']) ?>
                </div>

                <h1>
                  <?= htmlspecialchars($room['title']) ?>
                </h1>

                <p>
                  <?= htmlspecialchars($room['description']) ?>
                </p>

                <div class="price-row">

                  <div class="price">

                    <h1>
                      NPR <?= htmlspecialchars((string) $room['price']) ?>
                    </h1>

                    <h3>
                      /night
                    </h3>

                  </div>

                  <div class="view-details">
                    VIEW DETAILS
                  </div>

                </div>

              </div>

            </div>

          </a>

        <?php endforeach; ?>

      </div>


      <!-- FIXED: now goes to PHP /rooms route -->
      <a class="all_rooms" href="/rooms">
        <p>
          VIEW ALL ROOMS
        </p>
      </a>

    </div>


    <div id="third">

      <div class="why_us">

        <div id="hospitality">

          <h2>
            Why NepalStay
          </h2>

          <h1>
            The NepalStay Difference
          </h1>

          <h3>
            We go beyond hospitality to give you a genuine Nepali experience.
          </h3>

        </div>


        <div class="reasons">

          <div class="reason">

            <i class="fa-solid fa-mountain"></i>

            <h1>
              Himalayan views
            </h1>

            <h3>
              Breathtaking panoramic views of the Annapurna range from every
              room and terrace.
            </h3>

          </div>


          <div class="reason" id="Local Cuisine">

            <i class="fa-solid fa-bell-concierge"></i>

            <h1>
              Local Cuisine
            </h1>

            <h3>
              Authentic Nepali dal bhat, momo, and thakali dishes made fresh
              every day by local chefs.
            </h3>

          </div>


          <div class="reason">

            <i class="fa-solid fa-wifi"></i>

            <h1>
              Fast WiFi
            </h1>

            <h3>
              Stay connected with high-speed fiber internet throughout the
              entire property.
            </h3>

          </div>


          <div class="reason">

            <i class="fa-solid fa-bell-concierge"></i>

            <h1>
              24/7 Service
            </h1>

            <h3>
              Our front desk team is available around the clock to ensure your
              perfect stay.
            </h3>

          </div>

        </div>

      </div>


      <div class="flash">

        <div>
          800+ Happy Guests
        </div>

        <div>
          15 Room Types
        </div>

        <div>
          4.9★ Average Rating
        </div>

        <div>
          8 Years Experience
        </div>

      </div>

    </div>


    <div id="reviews">

      <h3>
        Guest Reviews
      </h3>

      <h1>
        What Our Guests Say
      </h1>


      <div class="scrollbar">

        <div class="review-card">

          <div class="stars">
            ★★★★★
          </div>

          <p>
            "Absolutely breathtaking views of Phewa Lake. The staff made us feel
            like royalty."
          </p>

          <div class="reviewer">
            — Ramesh K., Kathmandu
          </div>

        </div>


        <div class="review-card">

          <div class="stars">
            ★★★★★
          </div>

          <p>
            "The Himalayan Family Suite exceeded every expectation. Will be back
            next year."
          </p>

          <div class="reviewer">
            — Sarah M., London
          </div>

        </div>


        <div class="review-card">

          <div class="stars">
            ★★★★☆
          </div>

          <p>
            "Dal bhat by the lake at sunrise — a memory I'll carry forever."
          </p>

          <div class="reviewer">
            — Ankit S., Mumbai
          </div>

        </div>


        <div class="review-card">

          <div class="stars">
            ★★★★★
          </div>

          <p>
            "Seamless booking, warm hospitality, and the WiFi actually worked.
            Perfect."
          </p>

          <div class="reviewer">
            — Julia T., Berlin
          </div>

        </div>


        <div class="review-card">

          <div class="stars">
            ★★★★★
          </div>

          <p>
            "Best hotel experience in Nepal. The mountain view from our balcony
            was unreal."
          </p>

          <div class="reviewer">
            — David L., Sydney
          </div>

        </div>

      </div>

    </div>


    <footer>

      <div id="summary">

        <h1>
          NepalStay
        </h1>

        <h3>
          A luxury boutique hotel nestled in Lakeside, Pokhara. Where Himalayan
          beauty meets heartfelt Nepali hospitality.
        </h3>

      </div>


      <div id="quick_links">

        <h2>
          Home
        </h2>

        <h2>
          Rooms
        </h2>

        <h2>
          About us
        </h2>

        <h2>
          contact
        </h2>

      </div>


      <div id="contact">

        <div>
          <img src="" alt="" />
          <h2>
            Lakeside-6, Pokhara, Gandaki Province, Nepal
          </h2>
        </div>

        <div>
          <img src="" alt="" />
          <h2>
            +977-061-XXXXXX
          </h2>
        </div>

        <div>
          <img src="" alt="" />
          <h2>
            info@nepalstay.com
          </h2>
        </div>

        <div>
          <img src="" alt="" />
          <h2>
            Front Desk: Open 24/7
          </h2>
        </div>

      </div>


      <div id="copyright">

        <h2>
          © 2025 NepalStay. All rights reserved. | Lakeside, Pokhara, Nepal
        </h2>

      </div>

    </footer>

  </body>
</html>