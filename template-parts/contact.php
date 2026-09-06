<?php
/**
 * Contact section (always available)
 *
 * @package NEXO
 */
?>
<section id="contact" class="nexo-section nexo-contact-section">
	<div class="nexo-container">
		<div class="nexo-contact-wrap">
			<span class="nexo-eyebrow">تماس</span>
			<h2 class="nexo-section-title">بیایید همکاری کنیم</h2>
			<p class="nexo-section-subtitle">پیام بفرستید؛ در کوتاه‌ترین زمان پاسخ می‌دهیم.</p>

			<form class="nexo-contact-form" method="post" action="#" novalidate>
				<input type="text" name="name" placeholder="نام شما" required autocomplete="name">
				<input type="email" name="email" placeholder="ایمیل شما" required autocomplete="email">
				<textarea name="message" placeholder="پیام شما" required rows="5"></textarea>
				<button type="submit" class="nexo-btn nexo-btn-primary" style="width:100%;justify-content:center;">ارسال پیام</button>
				<div class="nexo-form-msg" aria-live="polite"></div>
			</form>

			<div class="nexo-contact-meta">
				<p>hello@example.com</p>
				<p>0912 345 6789</p>
				<p>تهران، ایران</p>
			</div>
		</div>
	</div>
</section>
