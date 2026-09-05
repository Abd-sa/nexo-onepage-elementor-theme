<?php
/**
 * Persian default strings for Elementor homepage + options
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Override option defaults to Persian when empty / first run
 */
function nexo_fa_option_defaults( $value, $option ) {
	return $value;
}

/**
 * Seed Persian content into nexo_options if not customized yet
 */
function nexo_seed_persian_options() {
	if ( get_option( 'nexo_fa_options_seeded_v1' ) ) {
		return;
	}

	$options = get_option( 'nexo_options', array() );
	if ( ! is_array( $options ) ) {
		$options = array();
	}

	$defaults = array(
		'hero_badge'    => 'سلام، من',
		'hero_title'    => 'علی رضایی',
		'hero_subtitle' => 'محصولات دیجیتال، برند و تجربه کاربری می‌سازم.',
		'hero_desc'     => 'طراح UI/UX و توسعه‌دهنده فرانت‌اند هستم و به کسب‌وکارها کمک می‌کنم ایده‌هایشان را به تجربه‌های زیبا و کاربردی تبدیل کنند.',
		'footer_about'  => 'طراحی و توسعه وب‌سایت‌های مدرن و حرفه‌ای.',
	);

	// Only fill keys that are empty or still English demo defaults
	$english_markers = array( 'HELLO', 'Ali Rezaei', 'I build digital', 'freelance UI/UX' );

	foreach ( $defaults as $key => $fa ) {
		$current = isset( $options[ $key ] ) ? (string) $options[ $key ] : '';
		$is_english = false;
		foreach ( $english_markers as $m ) {
			if ( $current && false !== strpos( $current, $m ) ) {
				$is_english = true;
				break;
			}
		}
		if ( '' === $current || $is_english ) {
			$options[ $key ] = $fa;
		}
	}

	update_option( 'nexo_options', $options );
	update_option( 'nexo_fa_options_seeded_v1', 1 );
}
add_action( 'admin_init', 'nexo_seed_persian_options', 5 );
add_action( 'after_switch_theme', 'nexo_seed_persian_options', 5 );
