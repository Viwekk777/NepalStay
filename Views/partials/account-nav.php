<aside class="account-sidebar">
    <p class="label">Your NepalStay</p>
    <nav aria-label="Account navigation">
        <?php foreach (['profile' => ['/profile', 'Account overview', 'user'], 'bookings' => ['/my-bookings', 'My bookings', 'calendar'], 'edit' => ['/edit-profile', 'Personal details', 'shield']] as $key => [$url, $label, $icon]): ?>
            <a href="<?= $url ?>" <?= ($accountActive ?? '') === $key ? 'aria-current="page"' : '' ?>><?= ns_icon($icon) ?><?= $label ?></a>
        <?php endforeach; ?>
        <?php if (($_SESSION['role'] ?? '') === 'admin'): ?><a href="/admin/dashboard"><?= ns_icon('bed') ?>Admin overview</a><?php endif; ?>
        <form action="/logout" method="POST"><button type="submit">Sign out <span aria-hidden="true">↗</span></button></form>
    </nav>
    <div class="sidebar-note"><span class="label">A new view awaits</span><p>Find a room for your next escape.</p><a class="text-link" href="/rooms">Explore rooms <?= ns_icon('arrow') ?></a></div>
</aside>
