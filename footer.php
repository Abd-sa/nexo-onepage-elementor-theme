<?php
/**
 * Footer template (Persian)
 *
 * @package NEXO
 */

$socials = nexo_get_option( 'social_links', array() );
?>

<footer id="colophon" class="nexo-footer">
	<div class="nexo-container">
		<div class="nexo-footer-grid">
			<div class="nexo-footer-brand">
				<div class="nexo-logo" style="color:#fff;margin-bottom:16px;">
					<span style="color:var(--nexo-color-primary);">N</span>EXO
				</div>
				<p><?php echo esc_html( nexo_get_option( 'footer_about', 'طراحی و توسعه وب‌سایت‌های مدرن برای کسب‌وکارهای ایرانی.' ) ); ?></p>
				<div class="nexo-socials" style="display:flex;gap:12px;margin-top:16px;flex-wrap:wrap;">
					<?php if ( ! empty( $socials['linkedin'] ) ) : ?>
						<a href="<?php echo esc_url( $socials['linkedin'] ); ?>" target="_blank" rel="noopener">LinkedIn</a>
					<?php endif; ?>
					<?php if ( ! empty( $socials['behance'] ) ) : ?>
						<a href="<?php echo esc_url( $socials['behance'] ); ?>" target="_blank" rel="noopener">Behance</a>
					<?php endif; ?>
					<?php if ( ! empty( $socials['dribbble'] ) ) : ?>
						<a href="<?php echo esc_url( $socials['dribbble'] ); ?>" target="_blank" rel="noopener">Dribbble</a>
					<?php endif; ?>
					<?php if ( ! empty( $socials['instagram'] ) ) : ?>
						<a href="<?php echo esc_url( $socials['instagram'] ); ?>" target="_blank" rel="noopener">Instagram</a>
					<?php endif; ?>
				</div>
			</div>

			<div class="nexo-footer-links">
				<h4 style="color:#fff;margin-bottom:16px;">دسترسی سریع</h4>
				<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'nexo-footer-menu',
					'fallback_cb'    => false,
					'depth'          => 1,
				)
			);
				?>
			</div>

			<div class="nexo-footer-links">
				<h4 style="color:#fff;margin-bottom:16px;">بخش‌ها</h4>
				<ul style="list-style:none;padding:0;margin:0;">
					<li><a href="#about">درباره من</a></li>
					<li><a href="#portfolio">نمونه کارها</a></li>
					<li><a href="#testimonials">نظرات</a></li>
					<li><a href="#faq">سوالات متداول</a></li>
					<li><a href="#contact">تماس</a></li>
				</ul>
			</div>

			<div class="nexo-footer-newsletter">
				<h4 style="color:#fff;margin-bottom:16px;">خبرنامه</h4>
				<p>برای دریافت نکات و پروژه‌های جدید ایمیل بگذارید.</p>
				<form class="nexo-newsletter-form" style="display:flex;gap:8px;margin-top:12px;" onsubmit="return false;">
					<input type="email" placeholder="ایمیل شما" style="flex:1;padding:10px 14px;border-radius:8px;border:none;">
					<button type="button" class="nexo-btn nexo-btn-primary" style="padding:10px 16px;">ثبت</button>
				</form>
			</div>
		</div>

		<div class="nexo-footer-bottom">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. همه حقوق محفوظ است.</p>
			<div>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">خانه</a>
				&nbsp;|&nbsp;
				<a href="#contact">تماس</a>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
