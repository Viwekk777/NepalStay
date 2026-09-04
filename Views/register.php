
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
            >

    <title>Register - NepalStay</title>

    <link
        rel="stylesheet"
        href="/Assets/CSS/style.css"
            >
</head>

<body>

    <?php $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); if ($base === '/' || $base === '.') $base = ''; ?>

    <main class="auth-main">
        <section class="auth-card">

        <h1>
Create Your NepalStay Account
</h1>

        <?php if (!empty($errors) && is_array($errors)): ?>
            <div class="auth-field" style="color: #b00020;">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars((string) $error, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form
            class="auth-form"
            action="<?= htmlspecialchars($base . '/register', ENT_QUOTES, 'UTF-8') ?>"
            method="POST"
                >

            <div class="auth-field">
                <label for="name">
Full Name
</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?= htmlspecialchars((string) ($old['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                    required
                    >
            </div>


            <div class="auth-field">
                <label for="email">
Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?= htmlspecialchars((string) ($old['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                    required
                    >
            </div>


            <div class="auth-field">
                <label for="phone">
Phone
                </label>

                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    value="<?= htmlspecialchars((string) ($old['phone'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                    required
                    >
            </div>


            <div class="auth-field">
                <label for="password">
Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    >
            </div>


            <div class="auth-field">
                <label for="password_confirmation">
Confirm Password
</label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    >
            </div>


            <button type="submit" class="auth-btn">
    Register
            </button>

        </form>


        <p class="auth-note">
Already have an account?

            <?php $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'); if ($base === '/' || $base === '.') $base = ''; ?>
            <a href="<?= htmlspecialchars($base . '/login', ENT_QUOTES, 'UTF-8') ?>">
    Login
            </a>
        </p>

        </section>
    </main>

</body>

</html>