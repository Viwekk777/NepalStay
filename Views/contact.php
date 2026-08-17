<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us - NepalStay Project</title>
    <!-- Link directly into your global master stylesheet -->
    <link rel="stylesheet" href="Assets/CSS/contact.css" />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
  </head>
  <body>
    <!-- FIXED NAVBAR CONTAINER -->
    <div id="detail-header">
      <nav id="nav">
        <a href="index.html" id="logo">
          <img
            src="images/ChatGPT Image May 29, 2026, 08_27_52 PM.png"
            alt="NepalStay Logo"
          />
        </a>
        <div id="links">
          <a href="index.html">HOME</a>
          <a href="rooms.html">ROOMS</a>
          <a href="about.html">ABOUT</a>
          <a href="contact.html" class="active-page">CONTACT</a>
        </div>
      </nav>
    </div>

    <!-- CONTACT HERO SPLASH SECTION -->
    <header id="contact-hero-banner">
      <div class="contact-hero-content">
        <h3>GET IN TOUCH</h3>
        <h1>We Are Here For You</h1>
      </div>
    </header>

    <!-- MAIN TWO-COLUMN CONTACT LAYOUT -->
    <main class="contact-wrapper">
      <!-- LEFT SIDE: Core Contact Information Cards -->
      <section class="contact-info-panel">
        <div class="info-intro">
          <h2>Reach Out Directly</h2>
          <p>
            Have questions about bookings, amenities, or corporate travel
            packages? Drop us a line or visit our desk.
          </p>
        </div>

        <div class="contact-card-grid">
          <div class="info-item-card">
            <i class="fa-solid fa-location-dot"></i>
            <div>
              <h3>Our Address</h3>
              <p>Lakeside-6, Pokhara, Gandaki Province, 33700, Nepal</p>
            </div>
          </div>

          <div class="info-item-card">
            <i class="fa-solid fa-phone-volume"></i>
            <div>
              <h3>Phone & Reservations</h3>
              <p>+977-061-XXXXXX</p>
              <p>+977-98XXXXXXXX (Mobile)</p>
            </div>
          </div>

          <div class="info-item-card">
            <i class="fa-solid fa-envelope-open-text"></i>
            <div>
              <h3>Electronic Mail</h3>
              <p>info@nepalstay.com</p>
              <p>bookings@nepalstay.com</p>
            </div>
          </div>

          <div class="info-item-card">
            <i class="fa-solid fa-clock"></i>
            <div>
              <h3>Desk Hours</h3>
              <p>Front Desk: 24/7 Service</p>
              <p>Management: 9:00 AM - 6:00 PM</p>
            </div>
          </div>
        </div>
      </section>

      <!-- RIGHT SIDE: Premium Interactive Form Module -->
      <section class="contact-form-panel">
        <div class="form-container-box">
          <h2>Send Us A Message</h2>
          <form
            class="contact-interactive-form"
            onsubmit="
              event.preventDefault();
              alert(
                'Message successfully sent! Our hospitality desk will get back to you within 3 business hours.',
              );
              this.reset();
            "
          >
            <div class="form-input-group">
              <label for="contact-name">FULL NAME</label>
              <input
                type="text"
                id="contact-name"
                placeholder="John Doe"
                required
              />
            </div>

            <div class="form-input-group">
              <label for="contact-email">EMAIL ADDRESS</label>
              <input
                type="email"
                id="contact-email"
                placeholder="john@example.com"
                required
              />
            </div>

            <div class="form-input-group">
              <label for="contact-subject">SUBJECT</label>
              <select id="contact-subject">
                <option value="general">General Inquiry</option>
                <option value="booking">Room Reservation Help</option>
                <option value="event">Events & Group Booking</option>
                <option value="feedback">Feedback & Suggestions</option>
              </select>
            </div>

            <div class="form-input-group">
              <label for="contact-message">YOUR MESSAGE</label>
              <textarea
                id="contact-message"
                rows="5"
                placeholder="Write your message details here..."
                required
              ></textarea>
            </div>

            <button type="submit" class="contact-submit-btn">
              SEND MESSAGE
            </button>
          </form>
        </div>
      </section>
    </main>

    <!-- FULL WIDTH MAP WRAPPER -->
    <section class="map-container-fluid">
      <!-- Replace the src URL path with an actual Google Maps iframe src if needed -->
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1m4!1m2!1d83.9575!2d28.2096!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3995937b2d555555%3A0xb56c9a2955555555!2sLakeside%2C%20Pokhara!5e0!3m2!1sen!2snp!4v1680000000000!5m2!1sen!2snp"
        width="100%"
        height="450"
        style="border: 0"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
      >
      </iframe>
    </section>

    <!-- FOOTER GRID MODULE -->
    <footer>
      <div id="summary">
        <h1>NepalStay</h1>
        <h3>
          A luxury boutique hotel nestled in Lakeside, Pokhara. Where Himalayan
          beauty meets heartfelt hospitality.
        </h3>
      </div>
      <div id="quick_links">
        <h2><a href="index.html">Home</a></h2>
        <h2><a href="rooms.html">Rooms</a></h2>
        <h2><a href="about.html">About us</a></h2>
        <h2><a href="contact.html">Contact</a></h2>
      </div>
      <div id="contact">
        <div><h2>Lakeside-6, Pokhara, Gandaki Province, Nepal</h2></div>
        <div><h2>+977-061-XXXXXX</h2></div>
        <div><h2>info@nepalstay.com</h2></div>
      </div>
      <div id="copyright">
        <h2>
          © 2025 NepalStay. All rights reserved. | Lakeside, Pokhara, Nepal
        </h2>
      </div>
    </footer>
  </body>
</html>
