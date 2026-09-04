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
    <style>
        .profile-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 120px 20px 48px;
        }

        .profile-card {
            background: rgba(0, 0, 0, 0.9);
            border: 2px solid var(--main-color);
            box-shadow: 0 0 18px rgba(255, 255, 0, 0.18);
            padding: 28px;
            color: #fff;
        }

        .profile-card h1 {
            margin: 0 0 8px;
            font-size: 2.4rem;
            color: var(--main-color);
            font-family: var(--main-font);
        }

        .profile-card p {
            margin: 0 0 24px;
            color: #ffffff;
            opacity: 0.9;
            font-family: var(--main-font);
        }

        .profile-card dl {
            display: grid;
            grid-template-columns: 160px 1fr;
            gap: 14px 18px;
            margin: 0;
            padding: 18px 0;
            border-top: 1px solid rgba(255, 255, 0, 0.35);
            border-bottom: 1px solid rgba(255, 255, 0, 0.35);
        }

        .profile-card dt {
            font-weight: 700;
            color: var(--main-color);
            font-family: var(--main-font);
        }

        .profile-card dd {
            margin: 0;
            color: #fff;
        }

        .profile-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 28px;
        }

        .profile-actions .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 18px;
            border-radius: 4px;
            text-decoration: none;
            border: 2px solid var(--main-color);
            cursor: pointer;
            font-weight: 600;
            background: var(--main-color);
            color: #000;
        }

        .profile-actions .btn:hover {
            background: var(--new-color);
            color: #fff;
            border-color: var(--new-color);
        }

        .profile-nav {
            max-width: 980px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
            min-height: 80px;
        }

        .profile-nav a {
            text-decoration: none;
            color: var(--main-color);
            font-weight: 700;
            text-shadow: 0 2px 4px #000;
        }

        .profile-nav a.active {
            color: var(--new-color);
        }

        .profile-nav form button {
            padding: 10px 16px;
            border: 2px solid var(--new-color);
            border-radius: 4px;
            background: var(--new-color);
            color: #fff;
            cursor: pointer;
            font-weight: 600;
        }
    </style>
  </head>
  <body>

    <nav class="profile-nav">
      <a href="/">Home</a>
      <a href="/rooms">Rooms</a>
      <a href="/about">About</a>
      <a href="/contact">Contact</a>
      <a href="/profile" class="active">Profile</a>
      <form action="/logout" method="POST" style="display:inline;">
        <button type="submit">Logout</button>
      </form>
    </nav>

    <main class="profile-wrap">
      <section class="profile-card">
        <h1>Your Profile</h1>
        <p>Manage your account and booking history.</p>

        <dl>
          <dt>Name</dt>
          <dd><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></dd>

          <dt>Email</dt>
          <dd><?= htmlspecialchars((string) $email, ENT_QUOTES, 'UTF-8') ?></dd>

          <dt>Phone</dt>
          <dd><?= htmlspecialchars((string) $phone, ENT_QUOTES, 'UTF-8') ?></dd>

          <dt>User ID</dt>
          <dd><?= (int) (Auth::userId() ?? 0) ?></dd>
        </dl>

        <div class="profile-actions">
          <a class="btn" href="/edit-profile">Edit Profile</a>
          <a class="btn" href="/my-bookings">View My Bookings</a>
        </div>
      </section>

    </main>

  </body>
</html>
