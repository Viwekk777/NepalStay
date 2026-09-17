<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account - NepalStay</title>
    <link rel="stylesheet" href="/Assets/CSS/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ivory: #f4f0e8;
            --ivory-soft: #ebe4d8;
            --stone: #d8d2c6;
            --sage: #5e6f63;
            --charcoal: #1f2423;
            --charcoal-soft: #2b3230;
            --accent: #b08c62;
            --text-main: #252a29;
            --text-muted: #5f6764;
            --line: rgba(31, 36, 35, 0.14);
            --shadow-soft: 0 20px 55px rgba(30, 35, 33, 0.13);
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Manrope", sans-serif;
            color: var(--text-main);
            background: linear-gradient(180deg, #f7f1e8 0%, #f1ece3 100%);
        }

        a { text-decoration: none; }

        .verify-shell {
            min-height: 100vh;
            background-image: linear-gradient(
                to bottom right,
                rgba(17, 22, 21, 0.72),
                rgba(25, 30, 28, 0.4)
            ), url("/Assets/images/bg.jpg");
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .verify-card {
            width: min(540px, 100%);
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 28px;
            box-shadow: var(--shadow-soft);
            padding: clamp(1.5rem, 3vw, 2.5rem);
            backdrop-filter: blur(8px);
        }

        .brand-row {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1.5rem;
        }

        .brand-mark {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, var(--accent), #d8c4a5);
            color: #fff;
            font-weight: 800;
            font-size: 1.1rem;
        }

        .brand-copy {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .brand-name {
            font-family: "Playfair Display", serif;
            font-size: 1.15rem;
            letter-spacing: 0.04em;
            color: var(--charcoal);
        }

        .brand-tag {
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .verify-card h1 {
            margin: 0 0 0.6rem;
            font-family: "Playfair Display", serif;
            font-size: clamp(2rem, 4vw, 2.8rem);
            line-height: 1.1;
            color: var(--charcoal);
        }

        .verify-card .subtitle {
            margin: 0 0 1.5rem;
            color: var(--text-muted);
            font-size: 1rem;
        }

        .alert-box {
            margin-bottom: 1.25rem;
            padding: 0.9rem 1rem;
            border-radius: 14px;
            background: rgba(176, 140, 98, 0.08);
            border: 1px solid rgba(176, 140, 98, 0.18);
            color: #7d4e1d;
        }

        .alert-box p {
            margin: 0.2rem 0;
            font-weight: 600;
        }

        .auth-form {
            display: grid;
            gap: 1rem;
        }

        .auth-field {
            display: grid;
            gap: 0.45rem;
        }

        .auth-field label {
            font-size: 0.78rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 700;
        }

        .auth-field input {
            width: 100%;
            min-height: 52px;
            border-radius: 14px;
            border: 1px solid rgba(31, 36, 35, 0.14);
            padding: 0.8rem 0.95rem;
            font: inherit;
            color: var(--text-main);
            background: #fff;
            transition: border-color 180ms ease, box-shadow 180ms ease;
        }

        .auth-field input:focus {
            outline: none;
            border-color: rgba(176, 140, 98, 0.65);
            box-shadow: 0 0 0 4px rgba(176, 140, 98, 0.14);
        }

        .auth-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 52px;
            border: none;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--charcoal), var(--charcoal-soft));
            color: #fff;
            font: inherit;
            font-weight: 700;
            letter-spacing: 0.03em;
            cursor: pointer;
            transition: transform 180ms ease, box-shadow 180ms ease;
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(31, 36, 35, 0.22);
        }

        .meta-link {
            margin-top: 1rem;
            display: inline-block;
            color: var(--text-muted);
            font-weight: 600;
        }

        @media (max-width: 540px) {
            .verify-card {
                padding: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <main class="verify-shell">
        <section class="verify-card">
            <div class="brand-row">
                <div class="brand-mark">N</div>
                <div class="brand-copy">
                    <span class="brand-name">NepalStay</span>
                    <span class="brand-tag">Boutique Himalayan Retreats</span>
                </div>
            </div>

            <h1>Verify Your Account</h1>
            <p class="subtitle">Enter the 6-digit verification code sent to you.</p>

            <?php if (!empty($errors) && is_array($errors)): ?>
                <div class="alert-box">
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
