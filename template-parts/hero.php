<?php
/**
 * Hero Section
 *
 * @package NEXO
 */

$badge    = nexo_get_option( 'hero_badge', 'HELLO, I\'M' );
$title    = nexo_get_option( 'hero_title', 'Ali Rezaei' );
$subtitle = nexo_get_option( 'hero_subtitle', 'I build digital products, brands and experiences.' );
$desc     = nexo_get_option( 'hero_desc', 'I\'m a freelance UI/UX designer and front-end developer based in Tehran. I help businesses turn ideas into beautiful, functional and user-friendly digital experiences.' );
$socials  = nexo_get_option( 'social_links', array() );
?>

<section id="home" class="nexo-hero nexo-section">
	<div class="nexo-container">
		<div class="nexo-hero-grid">
			<div class="nexo-hero-content">
				<span class="nexo-hero-badge"><?php echo esc_html( $badge ); ?></span>
				<h1><?php echo esc_html( $title ); ?></h1>
				<p class="nexo-hero-subtitle" style="font-size:1.25rem;font-weight:600;margin-bottom:12px;">
					<?php echo esc_html( $subtitle ); ?>
				</p>
				<p class="nexo-hero-desc"><?php echo wp_kses_post( $desc ); ?></p>

				<div class="nexo-hero-actions">
					<a href="#" class="nexo-btn nexo-btn-primary">
						<?php esc_html_e( 'Download CV', 'nexo' ); ?> ↓
					</a>
					<a href="#contact" class="nexo-btn nexo-btn-outline">
						<?php esc_html_e( "Let's Talk", 'nexo' ); ?>
					</a>
				</div>

				<div class="nexo-hero-follow" style="margin-top:20px;">
					<span style="font-size:14px;color:var(--nexo-color-text-light);margin-left:8px;"><?php esc_html_e( 'Follow Me', 'nexo' ); ?></span>
					<?php if ( ! empty( $socials['linkedin'] ) ) : ?>
						<a href="<?php echo esc_url( $socials['linkedin'] ); ?>" target="_blank" rel="noopener">in</a>
					<?php endif; ?>
					<?php if ( ! empty( $socials['behance'] ) ) : ?>
						<a href="<?php echo esc_url( $socials['behance'] ); ?>" target="_blank" rel="noopener">Be</a>
					<?php endif; ?>
					<?php if ( ! empty( $socials['dribbble'] ) ) : ?>
						<a href="<?php echo esc_url( $socials['dribbble'] ); ?>" target="_blank" rel="noopener">Dr</a>
					<?php endif; ?>
					<?php if ( ! empty( $socials['instagram'] ) ) : ?>
						<a href="<?php echo esc_url( $socials['instagram'] ); ?>" target="_blank" rel="noopener">IG</a>
					<?php endif; ?>
				</div>
			</div>

			<div class="nexo-hero-image">
				<?php
				// Placeholder - replace with custom logo or featured image via Elementor / Customizer
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					echo '<div style="background:#e2e8f0;border-radius:20px;aspect-ratio:1;display:flex;align-items:center;justify-content:center;color:#64748b;">';
					echo esc_html__( 'Upload your photo via Customizer or Elementor', 'nexo' );
					echo '</div>';
				}
				?>
				<div class="nexo-hero-stats" style="position:absolute;bottom:20px;left:20px;right:20px;display:flex;gap:12px;">
					<div class="nexo-stat-box">
						<strong>5+</strong>
						<span style="font-size:12px;"><?php esc_html_e( 'Years Experience', 'nexo' ); ?></span>
					</div>
					<div class="nexo-stat-box">
						<strong>50+</strong>
						<span style="font-size:12px;"><?php esc_html_e( 'Projects Completed', 'nexo' ); ?></span>
					</div>
				</div>
			</div>
		</div>

		<!-- Trusted by -->
		<div style="margin-top:60px;text-align:center;">
			<p style="font-size:13px;color:var(--nexo-color-text-light);letter-spacing:1px;margin-bottom:20px;">
				<?php esc_html_e( 'TRUSTED BY 100+ CLIENTS WORLDWIDE', 'nexo' ); ?>
			</p>
			<div style="display:flex;justify-content:center;gap:40px;flex-wrap:wrap;opacity:0.6;font-weight:600;font-size:18px;">
				<span>Google</span>
				<span>Microsoft</span>
				<span>Slack</span>
				<span>Airbnb</span>
				<span>Spotify</span>
				<span>Amazon</span>
			</div>
		</div>
	</div>
</section>
