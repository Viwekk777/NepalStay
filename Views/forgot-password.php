<?php $pageTitle='Forgot password'; require __DIR__.'/partials/header.php'; ?>
<main id="main" class="shell section"><section class="surface verify-card">
<div class="verification-symbol"><?= ns_icon('shield') ?></div>
<?php if ($submitted): ?>
<h1>Check your inbox.</h1><p>If an account matches that email and a reset is available, we’ll send a link to choose a new password. The link expires in 15 minutes.</p>
<div class="info-note" role="status">Check your spam folder too. If you recently requested a link, use the latest email or wait at least a minute before trying again.</div>
<p class="auth-switch"><a href="/forgot-password">Try another email or request again</a></p>
<?php else: ?>
<h1>Let’s get you back in.</h1><p>Enter the email address you used for your NepalStay account. We’ll help you choose a new password.</p>
<?php require __DIR__.'/partials/errors.php'; ?>
<form class="form-stack" action="/forgot-password" method="POST">
<input type="hidden" name="csrf" value="<?= ns_e($csrf) ?>">
<div class="field"><label for="email">Email address</label><input id="email" name="email" type="email" autocomplete="email" maxlength="254" value="<?= ns_e($email) ?>" required></div>
<button class="button" type="submit">Send reset link <?= ns_icon('arrow') ?></button>
</form>
<?php endif; ?>
<p class="auth-switch"><a href="/login">Back to sign in</a></p>
</section></main><?php require __DIR__.'/partials/footer.php'; ?>
