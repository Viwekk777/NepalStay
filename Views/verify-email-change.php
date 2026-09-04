<?php use App\Auth; ?>
<?php
if (!Auth::check()) {
    header('Location: /login');
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Verify Email Change - NepalStay</title>
    <link rel="stylesheet" href="/Assets/CSS/style.css" />
</head>
<body>
    <main class="auth-main">
        <section class="auth-card">
            <h1>Verify Email Change</h1>
            <p>We sent a code to your new email address.</p>

            <?php if (!empty($errors) && is_array($errors)): ?>
                <div class="auth-field" style="color: #b00020;">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars((string) $error, ENT_QUOTES, 'UTF-8') ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" action="/verify-email-change" method="POST">
                <div class="auth-field">
                    <label for="otp">OTP Code</label>
                    <input type="text" id="otp" name="otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" value="<?= htmlspecialchars((string) ($old['otp'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <button type="submit" class="auth-btn">Verify & Save</button>
            </form>
        </section>
    </main>
</body>
</html>
