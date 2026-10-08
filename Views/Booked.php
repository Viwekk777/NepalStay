<?php
declare(strict_types=1);

$bookingId = (int) $booking['id'];
$roomTitle = (string) $booking['room_title'];
$guestName = (string) $booking['guest_name'];
$guestEmail = (string) $booking['guest_email'];
$guestPhone = (string) $booking['guest_phone'];
$checkIn = (string) $booking['check_in'];
$checkOut = (string) $booking['check_out'];
$numGuests = (int) $booking['num_guests'];
$totalPrice = (float) $booking['total_price'];
$status = (string) $booking['status'];
$nights = (new DateTimeImmutable($checkIn))->diff(new DateTimeImmutable($checkOut))->days;
$escape = static fn(string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
$formatDate = static fn(string $value): string => (new DateTimeImmutable($value))->format('d M Y');
$statusClass = in_array($status, ['pending', 'confirmed', 'cancelled'], true) ? $status : 'other';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Received - NepalStay</title>
    <link rel="stylesheet" href="/Assets/CSS/style.css">
    <style>
        .receipt-page { background: radial-gradient(ellipse at top, #e5e9df 0, var(--ivory) 65%); }
        .receipt-nav { max-width: 1080px; margin: auto; padding: 28px 24px; display: flex; justify-content: space-between; align-items: center; gap: 20px; border-bottom: 1px solid var(--line); }
        .receipt-brand { display: flex; align-items: center; gap: 12px; }
        .receipt-mark { width: 42px; height: 42px; display: grid; place-items: center; border-radius: 50%; background: var(--charcoal); color: var(--ivory); font: 24px "Playfair Display", serif; }
        .receipt-brand strong { font: 22px "Playfair Display", serif; color: var(--charcoal); }
        .receipt-brand small { display: block; font-size: 10px; letter-spacing: .14em; text-transform: uppercase; color: var(--text-muted); }
        .receipt-nav > a:last-child { font-size: 13px; font-weight: 600; }
        .receipt-shell { width: min(960px, calc(100% - 40px)); margin: 48px auto 64px; }
        .receipt-heading { text-align: center; margin-bottom: 32px; }
        .receipt-symbol { width: 56px; height: 56px; margin: 0 auto 18px; display: grid; place-items: center; color: var(--sage); background: #e0e8dc; border: 1px solid #cbd8c5; border-radius: 50%; }
        .receipt-symbol svg { width: 25px; height: 25px; }
        .receipt-heading h1 { margin: 8px 0 12px; font: clamp(30px, 5vw, 46px)/1.15 "Playfair Display", serif; color: var(--charcoal); }
        .receipt-heading > p:last-child { max-width: 550px; margin: auto; color: var(--text-muted); font-size: 14px; }
        .receipt-card { background: #fffdf9; border: 1px solid var(--line); border-radius: 24px; overflow: hidden; box-shadow: 0 18px 48px rgba(31,36,35,.07); }
        .receipt-card-top { padding: 22px 30px; display: flex; align-items: center; justify-content: space-between; gap: 16px; border-bottom: 1px solid var(--line); }
        .receipt-label { display: block; font-size: 10px; font-weight: 700; letter-spacing: .13em; text-transform: uppercase; color: var(--text-muted); }
        .receipt-reference { font-size: 17px; color: var(--charcoal); letter-spacing: .04em; }
        .receipt-status { display: inline-flex; align-items: center; gap: 8px; border-radius: 999px; padding: 7px 13px; background: #edf0eb; color: var(--charcoal); font-size: 12px; font-weight: 700; }
        .receipt-status::before { content: ""; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .receipt-status.pending { background: #faf0d9; color: #825a12; }
        .receipt-status.confirmed { background: #e5eee2; color: #395c35; }
        .receipt-status.cancelled { background: #f8e6e2; color: #923e32; }
        .receipt-body { display: grid; grid-template-columns: minmax(0, 1.7fr) minmax(0, 1fr); }
        .receipt-stay { padding: 32px 30px; }
        .receipt-room { font: 26px/1.3 "Playfair Display", serif; color: var(--charcoal); margin: 8px 0 8px; overflow-wrap: anywhere; }
        .receipt-duration { font-size: 13px; color: var(--text-muted); }
        .receipt-dates { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 26px 0; padding: 22px 0; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
        .receipt-dates dd { margin: 7px 0 0; color: var(--charcoal); font-size: 16px; font-weight: 600; }
        .receipt-guest h3 { font-size: 14px; margin-bottom: 15px; }
        .receipt-guest dl { display: grid; gap: 12px; }
        .receipt-guest dl > div { display: grid; grid-template-columns: 70px minmax(0,1fr); gap: 16px; font-size: 13px; }
        .receipt-guest dt { color: var(--text-muted); }
        .receipt-guest dd { margin: 0; overflow-wrap: anywhere; }
        .receipt-summary { padding: 32px 26px; background: #f5f3ec; border-left: 1px solid var(--line); }
        .receipt-summary h2 { font-size: 16px; margin-bottom: 22px; }
        .receipt-summary dl { display: grid; gap: 15px; font-size: 13px; }
        .receipt-summary dl > div { display: flex; justify-content: space-between; gap: 16px; }
        .receipt-summary dt { color: var(--text-muted); }
        .receipt-summary dd { margin: 0; font-weight: 600; text-align: right; }
        .receipt-total { margin-top: 24px; padding-top: 22px; border-top: 1px solid var(--line); }
        .receipt-total strong { display: block; font-size: clamp(24px, 4vw, 30px); line-height: 1.4; color: var(--charcoal); overflow-wrap: anywhere; }
        .receipt-total strong span { font-size: 12px; font-weight: 500; margin-right: 5px; }
        .receipt-note { margin-top: 22px; padding: 14px; border: 1px solid #ddd9cd; border-radius: 12px; font-size: 12px; color: var(--text-muted); }
        .receipt-note strong { display: block; color: var(--charcoal); margin-bottom: 5px; }
        .receipt-bottom { padding: 18px 30px; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; gap: 14px; }
        .receipt-bottom p { color: var(--text-muted); font-size: 12px; }
        .receipt-print { background: transparent; border: 0; font: inherit; font-size: 12px; font-weight: 700; color: var(--sage); cursor: pointer; padding: 8px; white-space: nowrap; }
        .receipt-actions { display: flex; justify-content: center; flex-wrap: wrap; gap: 12px; margin-top: 28px; }
        .receipt-button { min-height: 46px; display: inline-flex; align-items: center; justify-content: center; padding: 12px 24px; border: 1px solid var(--charcoal); border-radius: 999px; font-size: 13px; font-weight: 600; background: var(--charcoal); color: #fff; }
        .receipt-button.secondary { background: transparent; color: var(--charcoal); border-color: #c9c9bf; }
        .receipt-button:hover { background: var(--sage); color: #fff; border-color: var(--sage); }
        .receipt-page a:focus-visible, .receipt-page button:focus-visible { outline: 3px solid var(--accent); outline-offset: 4px; }
        @media (max-width: 640px) {
            .receipt-nav { padding: 20px; }
            .receipt-brand small { font-size: 8px; }
            .receipt-shell { margin-top: 32px; width: calc(100% - 28px); }
            .receipt-body { grid-template-columns: 1fr; }
            .receipt-card-top, .receipt-stay { padding: 22px; }
            .receipt-summary { padding: 24px 22px; border-left: 0; border-top: 1px solid var(--line); }
            .receipt-bottom { padding: 16px 22px; align-items: flex-start; flex-direction: column; gap: 6px; }
            .receipt-dates { gap: 12px; }
            .receipt-actions a { flex: 1 1 170px; }
        }
        @media print {
            .receipt-page { background: #fff; }
            .receipt-nav > a:last-child, .receipt-actions, .receipt-print { display: none; }
            .receipt-shell { width: 100%; margin: 20px 0; }
            .receipt-card { box-shadow: none; break-inside: avoid; }
            .receipt-body { grid-template-columns: minmax(0, 1.7fr) minmax(0, 1fr); }
        }
    </style>
</head>
<body class="receipt-page">
    <nav class="receipt-nav" aria-label="Reservation navigation">
        <a class="receipt-brand" href="/">
            <span class="receipt-mark" aria-hidden="true">N</span>
            <span><strong>NepalStay</strong><small>Boutique Himalayan Retreats</small></span>
        </a>
        <a href="/">Back to home</a>
    </nav>

    <main class="receipt-shell">
        <header class="receipt-heading">
            <div class="receipt-symbol" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none"><path d="m5 12 4 4L19 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <p class="eyebrow">Your Himalayan stay</p>
            <h1>Reservation received.</h1>
            <p>Thank you, <?= $escape($guestName) ?>. Your reservation has been recorded. Keep these details for your stay.</p>
        </header>

        <article class="receipt-card" aria-label="Reservation receipt">
            <header class="receipt-card-top">
                <div><span class="receipt-label">Booking reference</span><strong class="receipt-reference">#<?= str_pad((string) $bookingId, 6, '0', STR_PAD_LEFT) ?></strong></div>
                <span class="receipt-status <?= $statusClass ?>"><?= $escape(ucfirst($status)) ?></span>
            </header>
            <div class="receipt-body">
                <section class="receipt-stay" aria-labelledby="receipt-room-title">
                    <p class="receipt-label">Your room</p>
                    <h2 class="receipt-room" id="receipt-room-title"><?= $escape($roomTitle) ?></h2>
                    <p class="receipt-duration"><?= $nights ?> <?= $nights === 1 ? 'night' : 'nights' ?> &middot; <?= $numGuests ?> <?= $numGuests === 1 ? 'guest' : 'guests' ?></p>
                    <dl class="receipt-dates">
                        <div><dt class="receipt-label">Check-in</dt><dd><time datetime="<?= $escape($checkIn) ?>"><?= $formatDate($checkIn) ?></time></dd></div>
                        <div><dt class="receipt-label">Check-out</dt><dd><time datetime="<?= $escape($checkOut) ?>"><?= $formatDate($checkOut) ?></time></dd></div>
                    </dl>
                    <section class="receipt-guest" aria-labelledby="receipt-guest-title">
                        <h3 id="receipt-guest-title">Guest information</h3>
                        <dl>
                            <div><dt>Name</dt><dd><?= $escape($guestName) ?></dd></div>
                            <div><dt>Email</dt><dd><?= $escape($guestEmail) ?></dd></div>
                            <div><dt>Phone</dt><dd><?= $escape($guestPhone) ?></dd></div>
                        </dl>
                    </section>
                </section>
                <section class="receipt-summary" aria-labelledby="receipt-summary-title">
                    <h2 id="receipt-summary-title">Reservation summary</h2>
                    <dl>
                        <div><dt>Length of stay</dt><dd><?= $nights ?> <?= $nights === 1 ? 'night' : 'nights' ?></dd></div>
                        <div><dt>Guests</dt><dd><?= $numGuests ?></dd></div>
                        <div><dt>Status</dt><dd><?= $escape(ucfirst($status)) ?></dd></div>
                    </dl>
                    <div class="receipt-total">
                        <span class="receipt-label">Reservation total</span>
                        <strong><span>NPR</span><?= number_format($totalPrice, 2) ?></strong>
                    </div>
                    <div class="receipt-note">
                        <?php if ($status === 'pending'): ?>
                            <strong>Awaiting confirmation</strong>
                            Your reservation is pending. Please contact us if you need help with your booking.
                        <?php elseif ($status === 'confirmed'): ?>
                            <strong>Your stay is confirmed</strong>
                            We look forward to welcoming you to NepalStay.
                        <?php elseif ($status === 'cancelled'): ?>
                            <strong>Reservation cancelled</strong>
                            This reservation is cancelled. Browse our rooms to plan another stay.
                        <?php else: ?>
                            <strong>Reservation recorded</strong>
                            Please contact us for help with your reservation status.
                        <?php endif; ?>
                    </div>
                </section>
            </div>
            <div class="receipt-bottom">
                <p>Keep your booking reference handy when contacting us.</p>
                <button class="receipt-print" type="button" onclick="window.print()">Print receipt</button>
            </div>
        </article>
        <div class="receipt-actions">
            <a class="receipt-button" href="/rooms">Browse more rooms</a>
            <a class="receipt-button secondary" href="/">Return to home</a>
        </div>
    </main>
</body>
</html>
