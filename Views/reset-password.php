<?php $pageTitle='Reset your password'; require __DIR__.'/partials/header.php'; ?>
<main id="main" class="shell section"><section class="surface verify-card">
<div class="verification-symbol"><?= ns_icon($success?'check':'shield') ?></div>
<?php if ($success): ?>
<h1>A fresh start.</h1><p>Your password has been updated. Sign in with your new password to return to your account.</p>
<a class="button button-full" href="/login">Continue to sign in <?= ns_icon('arrow') ?></a>
<?php elseif (!$valid): ?>
<h1>Let’s try a new link.</h1><p>This reset link is invalid, expired, or has already been used. Request a new one to continue.</p>
<?php require __DIR__.'/partials/errors.php'; ?>
<a class="button button-full" href="/forgot-password">Request a new link <?= ns_icon('arrow') ?></a>
<?php else: ?>
<h1>Choose a new password.</h1><p>Make it something unique that you haven’t used for another account.</p>
<?php require __DIR__.'/partials/errors.php'; ?>
<form class="form-stack" action="/reset-password" method="POST">
<input type="hidden" name="csrf" value="<?= ns_e($csrf) ?>"><input type="hidden" name="token" value="<?= ns_e($token) ?>">
<div class="field"><label for="password">New password</label><div class="password-wrap"><input id="password" name="password" type="password" autocomplete="new-password" minlength="8" maxlength="72" aria-describedby="password-help" required><button type="button" class="password-toggle" data-toggle-password="password" aria-pressed="false">Show</button></div><small id="password-help">Use 8–72 characters with uppercase and lowercase letters, a number, and a special character. No spaces.</small></div>
<div class="field"><label for="password_confirmation">Confirm new password</label><input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" maxlength="72" required></div>
<button class="button" type="submit">Save new password <?= ns_icon('arrow') ?></button>
</form>
<?php endif; ?>
<p class="auth-switch"><a href="/login">Back to sign in</a></p>
</section></main><?php require __DIR__.'/partials/footer.php'; ?>
