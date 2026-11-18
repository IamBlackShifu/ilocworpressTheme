(() => {
  'use strict';
  document.documentElement.classList.add('js');
  document.body.classList.remove('no-js');
  const header = document.querySelector('.site-header');
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('#primary-navigation');
  const mobile = matchMedia('(max-width: 1100px)');
  const motion = matchMedia('(prefers-reduced-motion: reduce)');
  const setMenu = (open, restore = false) => {
    if (!nav || !toggle) return;
    nav.classList.toggle('is-open', open);
    toggle.setAttribute('aria-expanded', String(open));
    if (restore) toggle.focus();
  };
  toggle?.addEventListener('click', () => setMenu(toggle.getAttribute('aria-expanded') !== 'true'));
  document.addEventListener('keydown', event => {
    if (!mobile.matches || toggle?.getAttribute('aria-expanded') !== 'true') return;
    if (event.key === 'Escape') { setMenu(false, true); return; }
    if (event.key === 'Tab') {
      const links = [toggle, ...nav.querySelectorAll('a,button')];
      const first = links[0], last = links[links.length - 1];
      if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
      else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
    }
  });
  document.addEventListener('click', event => { if (mobile.matches && !header?.contains(event.target)) setMenu(false); });
  nav?.addEventListener('click', event => { if (event.target.closest('a') && mobile.matches) setMenu(false); });
  mobile.addEventListener('change', () => setMenu(false));
  const onScroll = () => header?.classList.toggle('is-scrolled', scrollY > 24);
  addEventListener('scroll', onScroll, { passive: true }); onScroll();
  document.querySelectorAll('.project-filters').forEach(filters => {
    const grid = filters.nextElementSibling?.nextElementSibling;
    if (!grid) return;
    filters.addEventListener('click', event => {
      const selected = event.target.closest('[data-filter]'); if (!selected) return;
      filters.querySelectorAll('button').forEach(button => { const active = button === selected; button.classList.toggle('is-active', active); button.setAttribute('aria-pressed', String(active)); });
      let count = 0;
      grid.querySelectorAll('[data-categories]').forEach(card => { card.hidden = selected.dataset.filter !== 'all' && !card.dataset.categories.split(' ').includes(selected.dataset.filter); if (!card.hidden) count++; });
      const status = filters.nextElementSibling;
      status.textContent = count + ' ' + (document.documentElement.lang.startsWith('en') ? 'projects shown' : selected.textContent);
    });
  });
  document.querySelectorAll('[data-carousel]').forEach(carousel => {
    const track = carousel.querySelector('.client-track');
    const pause = carousel.querySelector('[data-pause]');
    const originals = [...track.children];
    if (track.scrollWidth > track.clientWidth && originals.length > 1) {
      originals.forEach(item => { const clone = item.cloneNode(true); clone.setAttribute('aria-hidden', 'true'); clone.setAttribute('inert', ''); clone.dataset.clone = 'true'; track.appendChild(clone); });
    }
    let position = track.scrollLeft;
    track.addEventListener('scroll', () => { position = track.scrollLeft; }, { passive: true });
    let paused = motion.matches, hover = false, focused = false, touching = false, visible = true, frame = 0, previous = 0;
    const label = () => { pause.textContent = paused ? pause.dataset.playLabel : pause.dataset.pauseLabel; pause.setAttribute('aria-pressed', String(paused)); };
    const stop = () => { cancelAnimationFrame(frame); frame = 0; previous = 0; };
    const run = time => {
      frame = 0;
      if (paused || hover || focused || touching || !visible || document.hidden || motion.matches) return;
      if (previous && track.scrollWidth > track.clientWidth) {
        const clone = track.querySelector('[data-clone]');
        const span = clone ? clone.offsetLeft - track.firstElementChild.offsetLeft : track.scrollWidth - track.clientWidth;
        position += Math.min(time - previous, 40) * .025;
        if (position >= span) position -= span;
        track.scrollLeft = position;
      }
      previous = time; frame = requestAnimationFrame(run);
    };
    const start = () => { if (!frame && !paused && !hover && !focused && !touching && visible && !document.hidden && !motion.matches) frame = requestAnimationFrame(run); };
    pause.addEventListener('click', () => { paused = !paused; label(); paused ? stop() : start(); });
    carousel.addEventListener('mouseenter', () => { hover = true; stop(); });
    carousel.addEventListener('mouseleave', () => { hover = false; start(); });
    carousel.addEventListener('focusin', () => { focused = true; stop(); });
    carousel.addEventListener('focusout', event => { if (!carousel.contains(event.relatedTarget)) { focused = false; start(); } });
    track.addEventListener('pointerdown', () => { touching = true; stop(); });
    addEventListener('pointerup', () => { touching = false; start(); });
    track.addEventListener('pointercancel', () => { touching = false; start(); });
    carousel.querySelector('[data-prev]').addEventListener('click', () => track.scrollBy({ left: -240, behavior: motion.matches ? 'instant' : 'smooth' }));
    carousel.querySelector('[data-next]').addEventListener('click', () => track.scrollBy({ left: 240, behavior: motion.matches ? 'instant' : 'smooth' }));
    motion.addEventListener('change', () => { if (motion.matches) { paused = true; label(); stop(); } });
    document.addEventListener('visibilitychange', () => document.hidden ? stop() : start());
    if ('IntersectionObserver' in window) new IntersectionObserver(entries => { visible = entries[0].isIntersecting; visible ? start() : stop(); }).observe(carousel);
    label(); start();
  });
})();
