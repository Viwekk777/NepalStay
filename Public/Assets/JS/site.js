(() => {
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.site-nav');
  function closeMenu() { if (!toggle || !nav) return; toggle.setAttribute('aria-expanded', 'false'); nav.classList.remove('open'); }
  toggle?.addEventListener('click', () => { const open = toggle.getAttribute('aria-expanded') !== 'true'; toggle.setAttribute('aria-expanded', String(open)); nav?.classList.toggle('open', open); });
  document.addEventListener('keydown', e => { if (e.key === 'Escape' && toggle?.getAttribute('aria-expanded') === 'true') { closeMenu(); toggle.focus(); } });
  document.addEventListener('click', e => { if (!e.target.closest('.site-header')) closeMenu(); });
  nav?.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));
  document.querySelectorAll('[data-toggle-password]').forEach(button => button.addEventListener('click', () => { const input = document.getElementById(button.dataset.togglePassword); if (!input) return; const show = input.type === 'password'; input.type = show ? 'text' : 'password'; button.textContent = show ? 'Hide' : 'Show'; button.setAttribute('aria-pressed', String(show)); }));
  document.querySelectorAll('[data-gallery-image]').forEach(button => button.addEventListener('click', () => { const image = document.querySelector('.detail-main-image'); if (!image) return; image.src = button.dataset.galleryImage; document.querySelectorAll('[data-gallery-image]').forEach(b => b.setAttribute('aria-pressed', String(b === button))); }));
  document.querySelectorAll('[data-date-form]').forEach(form => {
    const checkIn = form.querySelector('[data-check-in]');
    const checkOut = form.querySelector('[data-check-out]');
    const room = form.querySelector('[data-room-select]');
    const guests = form.querySelector('[name="num_guests"]');
    function update() {
      if (checkIn?.value && checkOut) { const next = new Date(checkIn.value + 'T00:00:00Z'); if (!Number.isNaN(next.getTime())) { next.setUTCDate(next.getUTCDate() + 1); checkOut.min = next.toISOString().slice(0,10); } }
      if (!room) return;
      const option = room.selectedOptions[0];
      if (guests) { if (option?.dataset.capacity) guests.max = option.dataset.capacity; else guests.removeAttribute('max'); }
      const roomLabel = document.querySelector('[data-summary-room]');
      if (roomLabel) roomLabel.textContent = option?.dataset.title || 'Choose your room';
      const nights = checkIn?.value && checkOut?.value ? Math.round((Date.parse(checkOut.value + 'T00:00:00Z') - Date.parse(checkIn.value + 'T00:00:00Z')) / 86400000) : 0;
      const price = Number(option?.dataset.price || 0);
      const total = document.querySelector('[data-summary-total]');
      const stay = document.querySelector('[data-summary-nights]');
      if (stay) stay.textContent = nights > 0 ? `${nights} ${nights === 1 ? 'night' : 'nights'}` : 'Select your dates';
      if (total) total.textContent = nights > 0 && room.value && Number.isFinite(price) ? 'NPR ' + (nights * price).toLocaleString('en-US', {minimumFractionDigits:2, maximumFractionDigits:2}) : 'Select room & dates';
    }
    form.addEventListener('input', update); form.addEventListener('change', update); update();
  });
  document.querySelector('[data-print-receipt]')?.addEventListener('click', () => window.print());
})();
