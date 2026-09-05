/**
 * NEXO Theme - Main JavaScript
 */
(function () {
	'use strict';

	// FAQ Accordion
	document.querySelectorAll('.nexo-faq-question').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var item = this.closest('.nexo-faq-item');
			var wasActive = item.classList.contains('active');

			// Close all
			document.querySelectorAll('.nexo-faq-item').forEach(function (el) {
				el.classList.remove('active');
				var toggle = el.querySelector('.nexo-faq-toggle');
				if (toggle) toggle.textContent = '+';
			});

			if (!wasActive) {
				item.classList.add('active');
				var t = item.querySelector('.nexo-faq-toggle');
				if (t) t.textContent = '−';
			}
		});
	});

	// Portfolio Filter (simple)
	document.querySelectorAll('.nexo-filter-btn').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var filter = this.getAttribute('data-filter');

			document.querySelectorAll('.nexo-filter-btn').forEach(function (b) {
				b.classList.remove('active');
			});
			this.classList.add('active');

			document.querySelectorAll('.nexo-portfolio-item').forEach(function (item) {
				if (filter === '*' || item.classList.contains(filter.replace('.', ''))) {
					item.style.display = '';
				} else {
					item.style.display = 'none';
				}
			});
		});
	});

	// Smooth scroll for anchor links
	document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
		anchor.addEventListener('click', function (e) {
			var targetId = this.getAttribute('href');
			if (targetId.length > 1) {
				var target = document.querySelector(targetId);
				if (target) {
					e.preventDefault();
					target.scrollIntoView({ behavior: 'smooth', block: 'start' });
				}
			}
		});
	});
})();
