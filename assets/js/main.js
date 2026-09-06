/**
 * NEXO front-end scripts
 */
(function () {
  'use strict';

  // FAQ accordion
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

  // Portfolio filters
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

  // Contact form AJAX
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
        btn.textContent = (nexoData.i18n && nexoData.i18n.sending) || '…';
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

  // Smooth scroll for hash links
  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var id = a.getAttribute('href');
      if (!id || id === '#') return;
      var target = document.querySelector(id);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
})();
