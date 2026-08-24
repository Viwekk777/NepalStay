<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NepalStay</title>
    <link rel="stylesheet" href="/Assets/CSS/style.css">
</head>

<body>
    <main class="auth-main">
        <section class="auth-card">
        <h1>Login to NepalStay</h1>

        <form class="auth-form" action="/login" method="POST">
            <div class="auth-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="auth-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="auth-btn">Login</button>
        </form>

        <p class="auth-note">
            Don't have an account?
            <a href="/register">Register</a>
        </p>
        </section>
    </main>
</body>

</html>
