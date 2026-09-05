<?php
/**
 * FAQ + Contact Section
 *
 * @package NEXO
 */

$faqs = array(
	array(
		'q' => __( 'How long does a project take?', 'nexo' ),
		'a' => __( 'Most projects take between 2 to 6 weeks depending on scope and complexity.', 'nexo' ),
	),
	array(
		'q' => __( 'Do you provide support after delivery?', 'nexo' ),
		'a' => __( 'Yes, every package includes a support period. Extended support is also available.', 'nexo' ),
	),
	array(
		'q' => __( 'Can you work with my existing website?', 'nexo' ),
		'a' => __( 'Absolutely. I can redesign, improve or extend existing websites.', 'nexo' ),
	),
	array(
		'q' => __( 'What do I need to get started?', 'nexo' ),
		'a' => __( 'Just a brief description of your goals, any existing brand assets, and your preferred timeline.', 'nexo' ),
	),
);
?>

<section id="faq" class="nexo-section" style="background:var(--nexo-color-bg-alt,#f8fafc);">
	<div class="nexo-container">
		<div class="nexo-faq-contact-grid">
			<!-- FAQ -->
			<div>
				<span style="color:var(--nexo-color-primary);font-weight:600;font-size:14px;"><?php esc_html_e( 'FAQ', 'nexo' ); ?></span>
				<h2 class="nexo-section-title"><?php esc_html_e( 'Frequently Asked Questions', 'nexo' ); ?></h2>

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

			<!-- Contact -->
			<div id="contact">
				<span style="color:var(--nexo-color-primary);font-weight:600;font-size:14px;"><?php esc_html_e( 'CONTACT', 'nexo' ); ?></span>
				<h2 class="nexo-section-title"><?php esc_html_e( "Let's Work Together", 'nexo' ); ?></h2>

				<form class="nexo-contact-form" action="#" method="post">
					<input type="text" name="name" placeholder="<?php esc_attr_e( 'Your Name', 'nexo' ); ?>" required>
					<input type="email" name="email" placeholder="<?php esc_attr_e( 'Your Email', 'nexo' ); ?>" required>
					<textarea name="message" placeholder="<?php esc_attr_e( 'Your Message', 'nexo' ); ?>" required></textarea>
					<button type="submit" class="nexo-btn nexo-btn-primary" style="width:100%;justify-content:center;">
						<?php esc_html_e( 'Send Message', 'nexo' ); ?> →
					</button>
				</form>

				<div style="margin-top:28px;font-size:14px;color:var(--nexo-color-text-light);">
					<p>📧 hello@example.com</p>
					<p>📱 +98 912 345 6789</p>
					<p>📍 Tehran, Iran</p>
					<p>🕐 Mon – Fri: 9AM – 6PM</p>
				</div>
			</div>
		</div>
	</div>
</section>
