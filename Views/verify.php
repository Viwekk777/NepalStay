<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account - NepalStay</title>
    <link rel="stylesheet" href="/Assets/CSS/style.css">
</head>

<body>
    <main class="auth-main">
        <section class="auth-card">
            <h1>Verify Your Account</h1>

            <?php if (!empty($errors) && is_array($errors)): ?>
                <div class="auth-field" style="color: #b00020;">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars((string) $error, ENT_QUOTES, 'UTF-8') ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" action="/verify" method="POST">
                <div class="auth-field">
                    <label for="otp">OTP Code</label>
                    <input type="text" id="otp" name="otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" value="<?= htmlspecialchars((string) ($old['otp'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <button type="submit" class="auth-btn">Verify Account</button>
            </form>
        </section>
    </main>
</body>

</html>
