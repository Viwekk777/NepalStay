<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact - NepalStay</title>
  <link rel="stylesheet" href="/Assets/CSS/style.css" />
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
        <a href="/login" class="nav-cta">Book Now</a>
      </div>
    </nav>

    <section class="inner-headline">
      <p class="eyebrow">Get in Touch</p>
      <h1>We're here to make your NepalStay effortless.</h1>
    </section>
  </header>

  <main class="page-shell">
    <section class="section-card split">
      <div>
        <p class="eyebrow">Contact Details</p>
        <h2>Reach out directly.</h2>
        <div class="feature-grid two">
          <article class="feature-item">
            <i class="fa-solid fa-location-dot"></i>
            <h3>Address</h3>
            <p>Lakeside-6, Pokhara, Gandaki Province, 33700, Nepal</p>
          </article>
          <article class="feature-item">
            <i class="fa-solid fa-phone-volume"></i>
            <h3>Phone</h3>
            <p>+977-061-XXXXXX</p>
            <p>+977-98XXXXXXXX (Mobile)</p>
          </article>
          <article class="feature-item">
            <i class="fa-solid fa-envelope-open-text"></i>
            <h3>Email</h3>
            <p>info@nepalstay.com</p>
            <p>bookings@nepalstay.com</p>
          </article>
          <article class="feature-item">
            <i class="fa-solid fa-clock"></i>
            <h3>Hours</h3>
            <p>Front Desk: 24/7 Service</p>
            <p>Management: 9:00 AM - 6:00 PM</p>
          </article>
        </div>
      </div>

      <div class="section-card">
        <p class="eyebrow">Send a Message</p>
        <h2>We'll respond quickly.</h2>
        <form
          class="stack-form"
          onsubmit="event.preventDefault(); alert('Message successfully sent! Our hospitality desk will get back to you within 3 business hours.'); this.reset();"
        >
          <div class="input-group">
            <label for="contact-name">Full Name</label>
            <input type="text" id="contact-name" placeholder="John Doe" required />
          </div>
          <div class="input-group">
            <label for="contact-email">Email Address</label>
            <input type="email" id="contact-email" placeholder="john@example.com" required />
          </div>
          <div class="input-group">
            <label for="contact-subject">Subject</label>
            <select id="contact-subject">
              <option value="general">General Inquiry</option>
              <option value="booking">Room Reservation Help</option>
              <option value="event">Events & Group Booking</option>
              <option value="feedback">Feedback & Suggestions</option>
            </select>
          </div>
          <div class="input-group">
            <label for="contact-message">Your Message</label>
            <textarea id="contact-message" rows="5" placeholder="Write your message details here..." required></textarea>
          </div>
          <button type="submit" class="instant-book-btn">Send Message</button>
        </form>
      </div>
    </section>

    <section class="section-card">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1m4!1m2!1d83.9575!2d28.2096!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3995937b2d555555%3A0xb56c9a2955555555!2sLakeside%2C%20Pokhara!5e0!3m2!1sen!2snp!4v1680000000000!5m2!1sen!2snp"
        width="100%"
        height="420"
        style="border: 0; border-radius: 16px;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
      ></iframe>
    </section>
  </main>
</body>
</html>
