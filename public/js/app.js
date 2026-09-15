/* Portfolio Dany Dauberton — interactions (JS natif, sans dépendance) */
(function () {
  'use strict';

  /* ---------- Thème clair / sombre ---------- */
  var root = document.documentElement;
  var toggle = document.getElementById('themeToggle');
  if (toggle) {
    toggle.addEventListener('click', function () {
      var next = root.dataset.theme === 'dark' ? 'light' : 'dark';
      root.dataset.theme = next;
      localStorage.setItem('theme', next);
    });
  }

  /* ---------- Menu mobile ---------- */
  var burger = document.getElementById('burger');
  var panel = document.getElementById('mobilePanel');
  function closeMenu() {
    if (!panel) return;
    panel.classList.remove('open');
    burger.classList.remove('open');
    burger.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
    setTimeout(function () { if (!panel.classList.contains('open')) panel.hidden = true; }, 300);
  }
  if (burger && panel) {
    burger.addEventListener('click', function () {
      var isOpen = panel.classList.contains('open');
      if (isOpen) { closeMenu(); return; }
      panel.hidden = false;
      requestAnimationFrame(function () { panel.classList.add('open'); });
      burger.classList.add('open');
      burger.setAttribute('aria-expanded', 'true');
      document.body.style.overflow = 'hidden';
    });
    panel.querySelectorAll('a').forEach(function (a) { a.addEventListener('click', closeMenu); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeMenu(); });
  }

  /* ---------- Barre de progression + header compact ---------- */
  var bar = document.getElementById('scrollBar');
  var header = document.getElementById('siteHeader');
  function onScroll() {
    var h = document.documentElement;
    var max = h.scrollHeight - h.clientHeight;
    var p = max > 0 ? (h.scrollTop / max) * 100 : 0;
    if (bar) bar.style.width = p + '%';
    if (header) header.classList.toggle('scrolled', h.scrollTop > 12);

    // Parallaxe très légère (hero uniquement)
    document.querySelectorAll('[data-parallax]').forEach(function (el) {
      var f = parseFloat(el.getAttribute('data-parallax')) || 0;
      el.style.transform = 'translate3d(0,' + (h.scrollTop * f) + 'px,0)';
    });
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* ---------- Reveal au scroll ---------- */
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var items = document.querySelectorAll('.reveal');
  if (reduce || !('IntersectionObserver' in window)) {
    items.forEach(function (el) { el.classList.add('visible'); });
  } else {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var el = entry.target;
        var d = parseInt(el.getAttribute('data-delay') || '0', 10);
        setTimeout(function () { el.classList.add('visible'); }, d);
        io.unobserve(el);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });
    items.forEach(function (el) { io.observe(el); });
  }

  /* ---------- Carte des compétences ---------- */
  document.querySelectorAll('.skill-group').forEach(function (group) {
    var note = group.querySelector('.skill-note');
    var chips = group.querySelectorAll('.skill-chip');
    function show(chip) {
      chips.forEach(function (c) { c.classList.toggle('active', c === chip); });
      note.textContent = chip.getAttribute('data-note');
    }
    chips.forEach(function (chip) {
      chip.addEventListener('mouseenter', function () { show(chip); });
      chip.addEventListener('focus', function () { show(chip); });
      chip.addEventListener('click', function () { show(chip); });
    });
    group.addEventListener('mouseleave', function () {
      chips.forEach(function (c) { c.classList.remove('active'); });
      note.textContent = note.getAttribute('data-default');
    });
  });

  /* ---------- Légère inclinaison des cartes projet ---------- */
  if (!reduce && window.matchMedia('(hover: hover)').matches) {
    document.querySelectorAll('.project-card').forEach(function (card) {
      card.addEventListener('mousemove', function (e) {
        var r = card.getBoundingClientRect();
        var x = (e.clientX - r.left) / r.width - 0.5;
        var y = (e.clientY - r.top) / r.height - 0.5;
        card.style.transform = 'perspective(1200px) rotateX(' + (-y * 2.2) + 'deg) rotateY(' + (x * 2.2) + 'deg) translateY(-4px)';
      });
      card.addEventListener('mouseleave', function () { card.style.transform = ''; });
    });
  }

  /* ---------- Défilement doux vers les ancres (SEULEMENT ancres pures sans path) ---------- */
  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var hash = a.getAttribute('href').substring(1);
      
      if (!hash) return;
      
      var target = document.getElementById(hash);
      if (!target) return;
      
      e.preventDefault();
      window.scrollTo({ 
        top: target.getBoundingClientRect().top + window.scrollY - 80, 
        behavior: reduce ? 'auto' : 'smooth' 
      });
      history.replaceState(null, '', '#' + hash);
    });
  });
})();