<?php if (!empty($errors)): ?>
<div class="alert" role="alert" tabindex="-1"><strong>Please check the following</strong><ul><?php foreach ($errors as $error): ?><li><?= ns_e($error) ?></li><?php endforeach; ?></ul></div>
<?php endif; ?>
