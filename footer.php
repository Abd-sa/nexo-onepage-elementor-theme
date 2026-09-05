<?php
/**
 * Footer template
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
				<p><?php echo esc_html( nexo_get_option( 'footer_about', __( 'Design and build digital products that make a difference.', 'nexo' ) ) ); ?></p>
				<div class="nexo-socials" style="display:flex;gap:12px;margin-top:16px;">
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
				<h4 style="color:#fff;margin-bottom:16px;"><?php esc_html_e( 'Quick Links', 'nexo' ); ?></h4>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'nexo-footer-menu',
					'fallback_cb'    => false,
					'depth'          => 1,
				) );
				?>
			</div>

			<div class="nexo-footer-links">
				<h4 style="color:#fff;margin-bottom:16px;"><?php esc_html_e( 'More Links', 'nexo' ); ?></h4>
				<ul style="list-style:none;padding:0;margin:0;">
					<li><a href="#experience"><?php esc_html_e( 'Experience', 'nexo' ); ?></a></li>
					<li><a href="#testimonials"><?php esc_html_e( 'Testimonials', 'nexo' ); ?></a></li>
					<li><a href="#faq"><?php esc_html_e( 'FAQ', 'nexo' ); ?></a></li>
					<li><a href="#contact"><?php esc_html_e( 'Contact', 'nexo' ); ?></a></li>
				</ul>
			</div>

			<div class="nexo-footer-newsletter">
				<h4 style="color:#fff;margin-bottom:16px;"><?php esc_html_e( 'Newsletter', 'nexo' ); ?></h4>
				<p><?php esc_html_e( 'Subscribe to get updates on new projects and tips.', 'nexo' ); ?></p>
				<form class="nexo-newsletter-form" style="display:flex;gap:8px;margin-top:12px;">
					<input type="email" placeholder="<?php esc_attr_e( 'Your email address', 'nexo' ); ?>" style="flex:1;padding:10px 14px;border-radius:8px;border:none;">
					<button type="submit" class="nexo-btn nexo-btn-primary" style="padding:10px 16px;">→</button>
				</form>
			</div>
		</div>

		<div class="nexo-footer-bottom">
			<p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'nexo' ); ?></p>
			<div>
				<a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'nexo' ); ?></a>
				&nbsp;|&nbsp;
				<a href="<?php echo esc_url( home_url( '/terms' ) ); ?>"><?php esc_html_e( 'Terms of Service', 'nexo' ); ?></a>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
