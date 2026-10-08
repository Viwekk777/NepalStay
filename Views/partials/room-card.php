<?php
$roomLink = '/room?' . http_build_query(array_filter(['room_id' => (int) $room['id'], 'check_in' => $checkIn ?? '', 'check_out' => $checkOut ?? '', 'num_guests' => $numGuests ?? ''], static fn($v) => $v !== '' && $v !== null));
?>
<article class="room-card">
    <a class="room-photo" href="<?= ns_e($roomLink) ?>"><img src="<?= ns_e(($room['main_image'] ?? '') ?: '/Assets/images/DoubleSuite.jpg') ?>" alt="<?= ns_e($room['title']) ?>" loading="lazy"><span class="photo-tag">Up to <?= (int) $room['capacity'] ?> guests</span></a>
    <div class="room-card-body"><p class="label">The stay collection</p><h3><a href="<?= ns_e($roomLink) ?>"><?= ns_e($room['title']) ?></a></h3><p class="room-description"><?= ns_e($room['description']) ?></p><div class="room-card-bottom"><p><strong>NPR <?= ns_money($room['price']) ?></strong><span> / night</span></p><a class="circle-link" href="<?= ns_e($roomLink) ?>" aria-label="View <?= ns_e($room['title']) ?>"><?= ns_icon('arrow') ?></a></div></div>
</article>
