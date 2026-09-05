<?php
/**
 * Enqueue scripts and styles
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front-end assets
 */
function nexo_enqueue_assets() {
	// Google Fonts - Vazirmatn (excellent Persian support)
	wp_enqueue_style(
		'nexo-fonts',
		'https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap',
		array(),
		null
	);

	// Main stylesheet
	wp_enqueue_style(
		'nexo-style',
		get_stylesheet_uri(),
		array( 'nexo-fonts' ),
		NEXO_VERSION
	);

	// RTL stylesheet
	if ( is_rtl() ) {
		wp_enqueue_style(
			'nexo-rtl',
			NEXO_URI . '/assets/css/rtl.css',
			array( 'nexo-style' ),
			NEXO_VERSION
		);
	}

	// Main JS
	wp_enqueue_script(
		'nexo-main',
		NEXO_URI . '/assets/js/main.js',
		array(),
		NEXO_VERSION,
		true
	);

	// Localize
	wp_localize_script( 'nexo-main', 'nexoData', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'nexo_nonce' ),
	) );

	// Dynamic CSS from options
	$custom_css = nexo_generate_dynamic_css();
	if ( $custom_css ) {
		wp_add_inline_style( 'nexo-style', $custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'nexo_enqueue_assets' );

/**
 * Generate CSS variables from theme options
 */
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

	$custom = nexo_get_option( 'custom_css', '' );
	if ( $custom ) {
		$css .= "\n" . $custom;
	}

	return $css;
}
