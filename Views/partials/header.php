<?php
require_once __DIR__ . '/helpers.php';
$pageTitle = $pageTitle ?? 'A little closer to the Himalayas';
$activeNav = $activeNav ?? '';
$isSignedIn = isset($_SESSION['user_id']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#243c32">
    <meta name="description" content="Discover NepalStay. Explore rooms, plan your dates, and reserve your Himalayan escape in Pokhara, Nepal.">
    <title><?= ns_e($pageTitle) ?> — NepalStay</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Gloock&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Assets/CSS/style.css?v=20261008-design1">
    <script src="/Assets/JS/site.js?v=20261008-design1" defer></script>
</head>
<body class="<?= ns_e($pageClass ?? '') ?>">
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header">
    <div class="nav-shell">
        <a class="brand" href="/" aria-label="NepalStay home"><?= ns_icon('mountain') ?><span>NepalStay<small>STAY A LITTLE CLOSER</small></span></a>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-navigation"><span></span><span></span><span class="sr-only">Open navigation</span></button>
        <nav class="site-nav" id="site-navigation" aria-label="Main navigation">
            <?php foreach (['home' => ['/', 'Home'], 'rooms' => ['/rooms', 'Our rooms'], 'about' => ['/about', 'Our story'], 'contact' => ['/contact', 'Contact']] as $key => [$url, $label]): ?>
                <a href="<?= $url ?>" <?= $activeNav === $key ? 'aria-current="page"' : '' ?>><?= $label ?></a>
            <?php endforeach; ?>
            <div class="nav-actions">
                <a class="nav-account" href="<?= $isSignedIn ? '/profile' : '/login' ?>"><?= ns_icon('user') ?><span><?= $isSignedIn ? 'My account' : 'Sign in' ?></span></a>
                <a class="button button-small" href="/booking">Book a stay <?= ns_icon('arrow') ?></a>
            </div>
        </nav>
    </div>
</header>
