<form class="stay-search" action="/availability" method="POST" data-date-form>
    <div class="field"><label for="search-in"><?= ns_icon('calendar') ?> Check-in</label><input id="search-in" name="check_in" type="date" value="<?= ns_e($checkIn ?? '') ?>" min="<?= date('Y-m-d') ?>" required data-check-in></div>
    <div class="field"><label for="search-out"><?= ns_icon('calendar') ?> Check-out</label><input id="search-out" name="check_out" type="date" value="<?= ns_e($checkOut ?? '') ?>" min="<?= date('Y-m-d') ?>" required data-check-out></div>
    <div class="field"><label for="search-guests"><?= ns_icon('user') ?> Guests</label><input id="search-guests" name="num_guests" type="number" value="<?= max(1, (int) ($numGuests ?? 2)) ?>" min="1" required></div>
    <button class="button" type="submit">Find your stay <?= ns_icon('arrow') ?></button>
</form>
