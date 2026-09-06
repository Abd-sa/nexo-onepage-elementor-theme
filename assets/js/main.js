/**
 * NEXO front-end scripts
 */
(function () {
  'use strict';

  document.querySelectorAll('.nexo-faq-question').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var item = btn.closest('.nexo-faq-item');
      if (!item) return;
      var wasActive = item.classList.contains('active');
      document.querySelectorAll('.nexo-faq-item').forEach(function (el) {
        el.classList.remove('active');
      });
      if (!wasActive) item.classList.add('active');
    });
  });

  document.querySelectorAll('.nexo-filter-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var filter = btn.getAttribute('data-filter') || '*';
      var root = btn.closest('.elementor-widget') || document;
      var parent = btn.parentElement;
      if (parent) {
        parent.querySelectorAll('.nexo-filter-btn').forEach(function (b) {
          b.classList.remove('active');
        });
      }
      btn.classList.add('active');

      var grid = root.querySelector('.nexo-portfolio-grid');
      if (!grid) grid = document.querySelector('.nexo-portfolio-grid');
      if (!grid) return;

      grid.querySelectorAll('.nexo-portfolio-item').forEach(function (item) {
        if (filter === '*' || item.classList.contains(filter.replace('.', ''))) {
          item.style.display = '';
        } else {
          item.style.display = 'none';
        }
      });
    });
  });

  document.querySelectorAll('.nexo-contact-form').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (typeof nexoData === 'undefined') return;

      var btn = form.querySelector('button[type="submit"]');
      var msg = form.querySelector('.nexo-form-msg');
      if (!msg) {
        msg = document.createElement('div');
        msg.className = 'nexo-form-msg';
        form.appendChild(msg);
      }

      var fd = new FormData(form);
      fd.append('action', 'nexo_contact');
      fd.append('nonce', nexoData.nonce);

      if (btn) {
        btn.disabled = true;
        btn.dataset.oldText = btn.textContent;
        btn.textContent = (nexoData.i18n && nexoData.i18n.sending) || '...';
      }

      fetch(nexoData.ajaxUrl, { method: 'POST', body: fd, credentials: 'same-origin' })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          msg.className = 'nexo-form-msg ' + (data.success ? 'success' : 'error');
          msg.textContent = (data.data && data.data.message) || (nexoData.i18n && nexoData.i18n.error) || '';
          if (data.success) form.reset();
        })
        .catch(function () {
          msg.className = 'nexo-form-msg error';
          msg.textContent = (nexoData.i18n && nexoData.i18n.error) || 'Error';
        })
        .finally(function () {
          if (btn) {
            btn.disabled = false;
            btn.textContent = btn.dataset.oldText || btn.textContent;
          }
        });
    });
  });

  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var id = a.getAttribute('href');
      if (!id || id === '#') return;
      var target = document.querySelector(id);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        var panel = document.getElementById('nexo-mobile-panel');
        var toggle = document.getElementById('nexo-menu-toggle');
        if (panel) {
          panel.classList.remove('is-open');
          panel.hidden = true;
        }
        if (toggle) toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }
    });
  });

  var menuToggle = document.getElementById('nexo-menu-toggle');
  var mobilePanel = document.getElementById('nexo-mobile-panel');
  if (menuToggle && mobilePanel) {
    menuToggle.addEventListener('click', function () {
      var open = menuToggle.getAttribute('aria-expanded') === 'true';
      menuToggle.setAttribute('aria-expanded', open ? 'false' : 'true');
      if (open) {
        mobilePanel.classList.remove('is-open');
        mobilePanel.hidden = true;
        document.body.style.overflow = '';
      } else {
        mobilePanel.hidden = false;
        mobilePanel.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }
    });
  }

  var themeToggle = document.getElementById('nexo-theme-toggle');
  function applyDark(on) {
    document.documentElement.classList.toggle('nexo-dark', !!on);
    document.body.classList.toggle('nexo-dark', !!on);
    document.documentElement.style.backgroundColor = on ? '#0b1220' : '';
    document.body.style.backgroundColor = on ? '#0b1220' : '';
    if (themeToggle) themeToggle.textContent = on ? '\u2600\uFE0F' : '\uD83C\uDF19';
    try {
      localStorage.setItem('nexo_dark', on ? '1' : '0');
    } catch (err) {}
  }
  if (themeToggle) {
    var saved = null;
    try {
      saved = localStorage.getItem('nexo_dark');
    } catch (err) {}
    if (saved === '1') applyDark(true);
    else if (saved === '0') applyDark(false);
    else if (document.documentElement.classList.contains('nexo-dark') || document.body.classList.contains('nexo-dark')) {
      applyDark(true);
    }

    themeToggle.addEventListener('click', function () {
      applyDark(!document.documentElement.classList.contains('nexo-dark'));
    });
  }

  var header = document.getElementById('masthead');
  if (header) {
    window.addEventListener(
      'scroll',
      function () {
        if (window.scrollY > 12) header.classList.add('is-scrolled');
        else header.classList.remove('is-scrolled');
      },
      { passive: true }
    );
  }

  if (document.body.classList.contains('nexo-anim')) {
    var targets = document.querySelectorAll(
      '.nexo-section, .nexo-service-card, .nexo-portfolio-item, .nexo-testimonial-card, .nexo-price-card'
    );
    targets.forEach(function (el) {
      el.classList.add('nexo-reveal');
    });
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              entry.target.classList.add('is-visible');
              io.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.12 }
      );
      targets.forEach(function (el) {
        io.observe(el);
      });
    } else {
      targets.forEach(function (el) {
        el.classList.add('is-visible');
      });
    }
  }
})();
