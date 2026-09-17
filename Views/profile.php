<?php use App\Auth; ?>
<?php
// Require authentication (session already started centrally in index.php)
if (!Auth::check()) {
    header('Location: /login');
    exit();
}

$name = isset($user['name']) ? (string) $user['name'] : ('User ' . (Auth::userId() ?? ''));
$email = $user['email'] ?? '';
$phone = $user['phone'] ?? '';
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profile - NepalStay</title>
    <link rel="stylesheet" href="/Assets/CSS/style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
      integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <style>
      body {
        background: var(--ivory);
      }

      .profile-page {
        color: var(--text-main);
        background: var(--ivory);
      }

      .nav-links .active-link {
        color: #fff;
        font-weight: 700;
      }

      .logout-form {
        display: inline-flex;
        margin: 0;
      }

      .logout-form button {
        min-height: 42px;
        padding: 0 1.1rem;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.45);
        background: transparent;
        color: #fff;
        font: inherit;
        font-weight: 700;
        cursor: pointer;
      }

      .profile-hero {
        min-height: 430px;
        background-image: linear-gradient(
            to bottom right,
            rgba(17, 22, 21, 0.7),
            rgba(25, 30, 28, 0.45)
          ),
          url("/Assets/images/bg.jpg");
        background-size: cover;
        background-position: center;
        color: #fff;
      }

      .profile-hero-inner {
        width: min(1220px, calc(100% - 2rem));
        margin: 0 auto;
        padding: clamp(4rem, 12vh, 7.5rem) 0 4rem;
      }

      .profile-main {
        margin-top: -2.6rem;
      }

      .profile-shell {
        width: min(1220px, calc(100% - 2rem));
        margin: 0 auto;
      }

      .profile-card {
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid rgba(31, 36, 35, 0.1);
        border-radius: 28px;
        box-shadow: 0 28px 60px rgba(30, 35, 33, 0.12);
        padding: clamp(1.4rem, 3vw, 2.3rem);
      }

      .profile-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--line);
      }

      .profile-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, var(--accent), #d9c7a6);
        color: #fff;
        font-size: 1.4rem;
        font-weight: 700;
      }

      .profile-header h2 {
        margin-top: 0.25rem;
        font-size: clamp(1.6rem, 3vw, 2.4rem);
        line-height: 1.2;
        font-family: "Playfair Display", serif;
        color: var(--text-main);
      }

      .eyebrow {
        display: inline-block;
        margin: 0;
        font-size: 0.72rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 700;
      }

      .profile-grid {
        display: grid;
        grid-template-columns: minmax(220px, 280px) 1fr;
        gap: 2rem;
        margin-top: 1.8rem;
      }

      .profile-side {
        background: #f7f3eb;
        border: 1px solid var(--line);
        border-radius: 20px;
        padding: 1.2rem;
      }

      .profile-side h3 {
        margin-bottom: 0.9rem;
        font-size: 1rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--text-muted);
      }

      .profile-side-list {
        display: grid;
        gap: 0.7rem;
      }

      .profile-side-list a {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0.9rem;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid transparent;
        color: var(--text-main);
        font-weight: 600;
      }

      .profile-side-list a.active {
        color: var(--charcoal);
        background: rgba(176, 140, 98, 0.12);
        border-color: rgba(176, 140, 98, 0.25);
      }

      .profile-side-list i {
        width: 1.6rem;
        text-align: center;
        color: var(--accent);
      }

      .profile-content {
        display: grid;
        gap: 1.25rem;
      }

      .info-card {
        border: 1px solid var(--line);
        border-radius: 20px;
        overflow: hidden;
        background: #fff;
      }

      .info-card-header {
        padding: 1rem 1.2rem;
        background: rgba(176, 140, 98, 0.08);
        border-bottom: 1px solid var(--line);
        font-size: 0.8rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-muted);
        font-weight: 700;
      }

      .info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0;
      }

      .info-row {
        padding: 1rem 1.2rem;
        border-bottom: 1px solid var(--line);
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
      }

      .info-row:nth-child(odd) {
        border-right: 1px solid var(--line);
      }

      .info-row label {
        font-size: 0.72rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--text-muted);
        font-weight: 700;
      }

      .info-row strong {
        font-size: 1rem;
        color: var(--text-main);
        font-weight: 700;
      }

      .profile-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.85rem;
      }

      .profile-actions .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 48px;
        padding: 0 1.15rem;
        border-radius: 999px;
        font-weight: 700;
        transition: transform 180ms ease, background-color 180ms ease;
      }

      .profile-actions .btn.primary {
        background: var(--charcoal);
        color: #fff;
      }

      .profile-actions .btn.secondary {
        background: var(--accent);
        color: #fff;
      }

      .profile-actions .btn:hover {
        transform: translateY(-2px);
      }

      @media (max-width: 820px) {
        .profile-grid {
          grid-template-columns: 1fr;
        }

        .info-grid {
          grid-template-columns: 1fr;
        }

        .info-row:nth-child(odd) {
          border-right: 0;
        }
      }
    </style>
  </head>
  <body class="profile-page">
    <header class="profile-hero">
      <nav id="nav" class="premium-nav">
        <a href="/" id="logo" class="brand">
          <img src="/Assets/images/logo.png" alt="NepalStay logo" />
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
          <a href="/profile" class="active-link">Profile</a>
          <form action="/logout" method="POST" class="logout-form">
            <button type="submit">Logout</button>
          </form>
        </div>
      </nav>

      <section class="profile-hero-inner">
        <p id="location">Member Dashboard</p>
        <h1 id="core">Welcome back, <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>.</h1>
        <p id="message">Manage your stay details, contact information, and upcoming plans from one place.</p>
      </section>
    </header>

    <main class="profile-main">
      <div class="profile-shell">
        <section class="profile-card">
          <div class="profile-header">
            <div class="profile-avatar">N</div>
            <div>
              <p class="eyebrow">Account Summary</p>
              <h2><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></h2>
            </div>
          </div>

          <div class="profile-grid">
            <aside class="profile-side">
              <h3>Quick Access</h3>
              <div class="profile-side-list">
                <a href="/profile" class="active"><i class="fa-solid fa-user"></i>Profile</a>
                <a href="/my-bookings"><i class="fa-solid fa-calendar-check"></i>My Bookings</a>
                <a href="/edit-profile"><i class="fa-solid fa-pen-to-square"></i>Edit Profile</a>
              </div>
            </aside>

            <div class="profile-content">
              <div class="info-card">
                <div class="info-card-header">Personal details</div>
                <div class="info-grid">
                  <div class="info-row">
                    <label>Name</label>
                    <strong><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></strong>
                  </div>

                  <div class="info-row">
                    <label>Email</label>
                    <strong><?= htmlspecialchars((string) $email, ENT_QUOTES, 'UTF-8') ?></strong>
                  </div>

                  <div class="info-row">
                    <label>Phone</label>
                    <strong><?= htmlspecialchars((string) $phone, ENT_QUOTES, 'UTF-8') ?></strong>
                  </div>

                  <div class="info-row">
                    <label>User ID</label>
                    <strong><?= (int) (Auth::userId() ?? 0) ?></strong>
                  </div>
                </div>
              </div>

              <div class="profile-actions">
                <a class="btn secondary" href="/edit-profile">Edit Profile</a>
                <a class="btn primary" href="/my-bookings">View My Bookings</a>
              </div>
            </div>
          </div>
        </section>
      </div>
    </main>
  </body>
</html>
