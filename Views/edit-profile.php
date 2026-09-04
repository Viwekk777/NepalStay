<?php use App\Auth; ?>
<?php
if (!Auth::check()) {
    header('Location: /login');
    exit();
}

$name = $user['name'] ?? '';
$email = $user['email'] ?? '';
$phone = $user['phone'] ?? '';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Profile - NepalStay</title>
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
            color: #fff;
            opacity: 0.9;
            font-family: var(--main-font);
        }

        .profile-form {
            display: grid;
            gap: 18px;
        }

        .profile-form .book {
            display: grid;
            gap: 8px;
            width: 100%;
        }

        .profile-form label {
            color: var(--main-color);
            font-family: var(--main-font);
            font-weight: 700;
        }

        .profile-form input {
            width: 100%;
            min-height: 48px;
            padding: 0 14px;
            border: 2px solid var(--main-color);
            background: #ffffff;
            color: #000;
            font-family: var(--main-font);
            font-weight: 700;
        }

        .profile-form small {
            color: #ff8080;
            font-weight: 700;
            font-family: var(--main-font);
        }

        .profile-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 10px;
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
            font-family: var(--main-font);
        }

        .profile-actions .btn:hover {
            background: var(--new-color);
            color: #fff;
            border-color: var(--new-color);
        }
    </style>
</head>
<body>
    <main class="profile-wrap">
        <section class="profile-card">
            <h1>Edit Profile</h1>
            <p>Update your account details below.</p>

            <form action="/edit-profile" method="POST" class="profile-form">
                <div class="book">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars((string) $name, ENT_QUOTES, 'UTF-8') ?>" required>
                    <?php if (!empty($errors['name'])): ?>
                        <small><?= htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8') ?></small>
                    <?php endif; ?>
                </div>

                <div class="book">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars((string) $email, ENT_QUOTES, 'UTF-8') ?>" required>
                    <?php if (!empty($errors['email'])): ?>
                        <small><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></small>
                    <?php endif; ?>
                </div>

                <div class="book">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" value="<?= htmlspecialchars((string) $phone, ENT_QUOTES, 'UTF-8') ?>" required>
                    <?php if (!empty($errors['phone'])): ?>
                        <small><?= htmlspecialchars($errors['phone'], ENT_QUOTES, 'UTF-8') ?></small>
                    <?php endif; ?>
                </div>

                <div class="profile-actions">
                    <button type="submit" class="btn">Save Changes</button>
                    <a href="/profile" class="btn">Cancel</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
