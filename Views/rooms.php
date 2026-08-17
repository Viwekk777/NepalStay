<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Our Accommodations - Nepal Stay Project</title>
    <link rel="stylesheet" href="Assets/CSS/style.css" />
    <script src="JS/main.js"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
      integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <style>
      /* Quick inline addition to keep the anchor tags acting like blocks */
      a.room {
        display: flex;
        flex-direction: column;
        color: inherit;
        text-decoration: none;
      }
    </style>
  </head>
  <body>
    <div id="rooms-header">
      <nav id="nav">
        <a href="index.html" id="logo">
          <img
            src="images/ChatGPT Image May 29, 2026, 08_27_52 PM.png"
            alt="NepalStay Logo"
          />
        </a>
        <div id="links">
          <a href="index.html">HOME</a>
          <a href="rooms.html" class="active-page">ROOMS</a>
          <a href="about.html">ABOUT</a>
          <a href="contact.html">CONTACT</a>
        </div>
      </nav>

      <div id="rooms-hero">
        <div id="location">ACCOMMODATIONS</div>
        <div id="core">Find Your Perfect Sanctuary</div>
      </div>
    </div>

    <div id="checkout">
      <div class="book">
        <label for="date">CHECK-IN</label>
        <input type="date" class="child" />
      </div>
      <div class="book">
        <label for="date">CHECK-OUT</label>
        <input type="date" class="child" />
      </div>
      <div id="guest" class="book">
        <label for="guest">GUESTS</label>
        <select name="" id="selector" class="child">
          <option value="">1 guest</option>
          <option value="">2 guests</option>
          <option value="">3 guests</option>
          <option value="">4+ guests</option>
        </select>
      </div>
      <div id="available" class="child">FILTER ROOMS</div>
    </div>

    <div id="second" class="extended-rooms-view">
      <div id="detials">
        <h3>DISCOVER LUXURY</h3>
        <h1>Our Sanctuary Suites</h1>
        <h4>
          All reservations include complimentary local organic breakfast,
          high-speed fiber internet, and terminal pickups.
        </h4>
      </div>

      <div class="rooms directory-grid">
        <a href="roomdetials/deluxeSingleRoom.html" id="DSR" class="room">
          <img src="images/DSR.jpg" alt="Deluxe Single Room" />
          <div class="contents">
            <div class="number">SINGLE</div>
            <h1>Deluxe Single Room</h1>
            <p>
              A cozy retreat featuring a plush king-size bed, a scenic private
              lake view balcony, and custom handcrafted timber finishes built
              for solo adventurers.
            </p>
            <div class="room-amenities">
              <span><i class="fa-solid fa-wifi"></i> Free WiFi</span>
              <span><i class="fa-solid fa-tv"></i> Smart TV</span>
              <span><i class="fa-solid fa-mug-hot"></i> Coffee Maker</span>
            </div>
            <div class="price-row">
              <div class="price">
                <h1>NPR 3,500</h1>
                <h3>/night</h3>
              </div>
              <div class="view-details">BOOK NOW</div>
            </div>
          </div>
        </a>

        <a href="roomdetials/mountainViewDouble.html" id="MVD" class="room">
          <img src="images/MVD.webp" alt="Double Mountain View" />
          <div class="contents">
            <div class="number">DOUBLE</div>
            <h1>Mountain View Double</h1>
            <p>
              Wake directly up to the golden Annapurna range reflections every
              morning. A spacious twin-bed setup with custom local accents.
            </p>
            <div class="room-amenities">
              <span><i class="fa-solid fa-mountain"></i> Range View</span>
              <span><i class="fa-solid fa-snowflake"></i> AC</span>
              <span><i class="fa-solid fa-sheet-plastic"></i> Balcony</span>
            </div>
            <div class="price-row">
              <div class="price">
                <h1>NPR 5,500</h1>
                <h3>/night</h3>
              </div>
              <div class="view-details">BOOK NOW</div>
            </div>
          </div>
        </a>

        <a href="roomdetials/himalayanFamilySuite.html" id="HFS" class="room">
          <img src="images/family suite.jpg" alt="Himalayan Family Suite" />
          <div class="contents">
            <div class="number">SUITE</div>
            <h1>Himalayan Family Suite</h1>
            <p>
              Our grand masterpiece floorplan. Complete with two distinct luxury
              bedrooms, private dining lounges, and pristine unhindered
              panoramic mountain views.
            </p>
            <div class="room-amenities">
              <span><i class="fa-solid fa-users"></i> Up to 5 Guests</span>
              <span><i class="fa-solid fa-couch"></i> Lounge</span>
              <span><i class="fa-solid fa-bath"></i> Luxury Tub</span>
            </div>
            <div class="price-row">
              <div class="price">
                <h1>NPR 9,500</h1>
                <h3>/night</h3>
              </div>
              <div class="view-details">BOOK NOW</div>
            </div>
          </div>
        </a>

        <a href="roomdetials/lakesidePremiumStudio.html" id="LPS" class="room">
          <img src="images/MVD.webp" alt="Lakeside Premium Studio" />
          <div class="contents">
            <div class="number">PREMIUM</div>
            <h1>Lakeside Premium Studio</h1>
            <p>
              Perfect for long-term remote workers or couples. Features an
              integrated private working den, mini-kitchenette bar, and dynamic
              lake vistas.
            </p>
            <div class="room-amenities">
              <span><i class="fa-solid fa-kitchen-set"></i> Kitchenette</span>
              <span><i class="fa-solid fa-briefcase"></i> Workspace</span>
              <span><i class="fa-solid fa-water"></i> Lake View</span>
            </div>
            <div class="price-row">
              <div class="price">
                <h1>NPR 7,000</h1>
                <h3>/night</h3>
              </div>
              <div class="view-details">BOOK NOW</div>
            </div>
          </div>
        </a>

        <a href="roomdetials/annapurnaPenthouse.html" id="APP" class="room">
          <img src="images/family suite.jpg" alt="Annapurna Penthouse" />
          <div class="contents">
            <div class="number">LUXURY</div>
            <h1>Annapurna Penthouse</h1>
            <p>
              The crown jewel of Lakeside. Top-floor architectural marvel
              offering a wrapping private observation deck, stone fireplace, and
              elite butler service access.
            </p>
            <div class="room-amenities">
              <span><i class="fa-solid fa-fire"></i> Fireplace</span>
              <span><i class="fa-solid fa-bell"></i> Butler Service</span>
              <span><i class="fa-solid fa-expand"></i> Wrap Deck</span>
            </div>
            <div class="price-row">
              <div class="price">
                <h1>NPR 15,000</h1>
                <h3>/night</h3>
              </div>
              <div class="view-details">BOOK NOW</div>
            </div>
          </div>
        </a>
      </div>
    </div>

    <footer>
      <div id="summary">
        <h1>NepalStay</h1>
        <h3>
          A luxury boutique hotel nestled in Lakeside, Pokhara. Where Himalayan
          beauty meets heartfelt Nepali hospitality.
        </h3>
      </div>
      <div id="quick_links">
        <h2><a href="index.html">Home</a></h2>
        <h2><a href="rooms.html">Rooms</a></h2>
        <h2><a href="about.html">About us</a></h2>
        <h2><a href="contact.html">Contact</a></h2>
      </div>
      <div id="contact">
        <div>
          <h2>Lakeside-6, Pokhara, Gandaki Province, Nepal</h2>
        </div>
        <div>
          <h2>+977-061-XXXXXX</h2>
        </div>
        <div>
          <h2>info@nepalstay.com</h2>
        </div>
        <div>
          <h2>Front Desk: Open 24/7</h2>
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
