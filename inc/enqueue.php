<?php
/**
 * Enqueue scripts and styles
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nexo_enqueue_assets() {
	add_action(
		'wp_head',
		static function () {
			echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
			echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
		},
		1
	);

	wp_enqueue_style(
		'nexo-fonts',
		'https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'nexo-style',
		get_stylesheet_uri(),
		array( 'nexo-fonts' ),
		NEXO_VERSION
	);

	wp_enqueue_style(
		'nexo-extras',
		NEXO_URI . '/assets/css/theme-extras.css',
		array( 'nexo-style' ),
		NEXO_VERSION
	);

	wp_enqueue_style(
		'nexo-dark',
		NEXO_URI . '/assets/css/dark.css',
		array( 'nexo-style' ),
		NEXO_VERSION
	);

	if ( is_rtl() ) {
		wp_enqueue_style(
			'nexo-rtl',
			NEXO_URI . '/assets/css/rtl.css',
			array( 'nexo-style' ),
			NEXO_VERSION
		);
	}

	wp_enqueue_script(
		'nexo-main',
		NEXO_URI . '/assets/js/main.js',
		array(),
		NEXO_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	wp_localize_script(
		'nexo-main',
		'nexoData',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'nexo_nonce' ),
			'i18n'    => array(
				'sending' => 'در حال ارسال…',
				'error'   => 'خطایی رخ داد. دوباره تلاش کنید.',
			),
		)
	);

	$custom_css = nexo_generate_dynamic_css();
	if ( $custom_css ) {
		wp_add_inline_style( 'nexo-style', $custom_css );
	}

	$custom_js = nexo_get_option( 'custom_js', '' );
	if ( $custom_js ) {
		wp_add_inline_script( 'nexo-main', $custom_js );
	}
}
add_action( 'wp_enqueue_scripts', 'nexo_enqueue_assets' );

function nexo_generate_dynamic_css() {
	$primary   = nexo_get_option( 'color_primary', '#22c55e' );
	$secondary = nexo_get_option( 'color_secondary', '#16a34a' );
	$accent    = nexo_get_option( 'color_accent', '#3b82f6' );
	$text      = nexo_get_option( 'color_text', '#1a1a2e' );
	$bg        = nexo_get_option( 'color_bg', '#ffffff' );
	$font_h    = nexo_get_option( 'font_heading', 'Vazirmatn' );
	$font_b    = nexo_get_option( 'font_body', 'Vazirmatn' );
	$size_h1   = nexo_get_option( 'font_size_h1', '3rem' );
	$size_h2   = nexo_get_option( 'font_size_h2', '2.25rem' );
	$size_body = nexo_get_option( 'font_size_body', '16px' );
	$container = nexo_get_option( 'container_width', '1200px' );

	$css = ":root {
		--nexo-color-primary: {$primary};
		--nexo-color-secondary: {$secondary};
		--nexo-color-accent: {$accent};
		--nexo-color-text: {$text};
		--nexo-color-bg: {$bg};
		--nexo-font-heading: \"{$font_h}\", system-ui, sans-serif;
		--nexo-font-body: \"{$font_b}\", system-ui, sans-serif;
		--nexo-font-size-h1: {$size_h1};
		--nexo-font-size-h2: {$size_h2};
		--nexo-font-size-body: {$size_body};
		--nexo-container-width: {$container};
	}";

	$css .= '
@media (max-width: 1024px) {
	.nexo-portfolio-grid { grid-template-columns: repeat(2, 1fr) !important; }
	.nexo-testimonials-grid { grid-template-columns: repeat(2, 1fr) !important; }
	.nexo-services-grid { grid-template-columns: repeat(2, 1fr) !important; }
}
@media (max-width: 640px) {
	.nexo-portfolio-grid,
	.nexo-testimonials-grid,
	.nexo-services-grid,
	.nexo-pricing-grid { grid-template-columns: 1fr !important; }
}
.nexo-testimonial-stars { color: #f59e0b; letter-spacing: 2px; margin-bottom: 12px; font-size: 14px; }
.nexo-contact-form .nexo-form-msg { margin-top: 12px; font-size: 14px; }
.nexo-contact-form .nexo-form-msg.success { color: #16a34a; }
.nexo-contact-form .nexo-form-msg.error { color: #dc2626; }
';

	$custom = nexo_get_option( 'custom_css', '' );
	if ( $custom ) {
		$css .= "\n" . $custom;
	}

	return $css;
}

/**
 * Body classes for dark default + animations
 */
function nexo_body_classes( $classes ) {
	if ( nexo_get_option( 'dark_default', 0 ) ) {
		$classes[] = 'nexo-dark';
	}
	if ( nexo_get_option( 'enable_animations', 1 ) ) {
		$classes[] = 'nexo-anim';
	}
	return $classes;
}
add_filter( 'body_class', 'nexo_body_classes' );
