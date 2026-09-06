<?php
/**
 * FAQ + Contact Section (Persian)
 *
 * @package NEXO
 */

$faqs = array(
	array(
		'q' => 'مدت زمان انجام یک پروژه چقدر است؟',
		'a' => 'بسته به حجم کار معمولاً بین ۲ تا ۶ هفته طول می‌کشد.',
	),
	array(
		'q' => 'بعد از تحویل پشتیبانی دارید؟',
		'a' => 'بله، هر پکیج دوره پشتیبانی دارد و پشتیبانی تمدیدی هم قابل سفارش است.',
	),
	array(
		'q' => 'روی سایت فعلی‌ام هم کار می‌کنید؟',
		'a' => 'بله؛ می‌توانم سایت موجود را بازطراحی، بهبود یا توسعه دهم.',
	),
	array(
		'q' => 'برای شروع چه چیزی لازم است؟',
		'a' => 'توضیح کوتاه از اهداف، فایل‌های برند (در صورت وجود) و زمان‌بندی مورد نظر شما.',
	),
);
?>

<section id="faq" class="nexo-section" style="background:var(--nexo-color-bg-alt,#f8fafc);">
	<div class="nexo-container">
		<div class="nexo-faq-contact-grid">
			<div>
				<span style="color:var(--nexo-color-primary);font-weight:600;font-size:14px;">سوالات متداول</span>
				<h2 class="nexo-section-title">پرسش‌های پرتکرار</h2>

				<div class="nexo-faq-list">
					<?php foreach ( $faqs as $index => $faq ) : ?>
						<div class="nexo-faq-item <?php echo 0 === $index ? 'active' : ''; ?>">
							<button class="nexo-faq-question" type="button">
								<?php echo esc_html( $faq['q'] ); ?>
								<span class="nexo-faq-toggle">+</span>
							</button>
							<div class="nexo-faq-answer">
								<?php echo esc_html( $faq['a'] ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div id="contact">
				<span style="color:var(--nexo-color-primary);font-weight:600;font-size:14px;">تماس</span>
				<h2 class="nexo-section-title">بیایید همکاری کنیم</h2>

				<form class="nexo-contact-form" method="post" action="#">
					<input type="text" name="name" placeholder="نام شما" required>
					<input type="email" name="email" placeholder="ایمیل شما" required>
					<textarea name="message" placeholder="پیام شما" required></textarea>
					<button type="submit" class="nexo-btn nexo-btn-primary" style="width:100%;justify-content:center;">
						ارسال پیام
					</button>
				</form>

				<div style="margin-top:28px;font-size:14px;color:var(--nexo-color-text-light);">
					<p>📧 hello@example.com</p>
					<p>📱 ۰۹۱۲ ۳۴۵ ۶۷۸۹</p>
					<p>📍 تهران، ایران</p>
					<p>🕐 شنبه تا چهارشنبه ۹ تا ۱۸</p>
				</div>
			</div>
		</div>
	</div>
</section>
