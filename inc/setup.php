<?php
/**
 * Theme setup helpers
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fallback menu (Persian labels — theme is built for FA audience)
 */
function nexo_fallback_menu() {
	$items = array(
		'home'         => array( 'label' => 'خانه',           'url' => home_url( '/' ) ),
		'about'        => array( 'label' => 'درباره من',      'url' => '#about' ),
		'services'     => array( 'label' => 'خدمات',          'url' => '#services' ),
		'portfolio'    => array( 'label' => 'نمونه کارها',    'url' => '#portfolio' ),
		'testimonials' => array( 'label' => 'نظرات مشتریان',  'url' => '#testimonials' ),
		'pricing'      => array( 'label' => 'تعرفه‌ها',       'url' => '#pricing' ),
		'faq'          => array( 'label' => 'سوالات متداول',  'url' => '#faq' ),
		'contact'      => array( 'label' => 'تماس',           'url' => '#contact' ),
	);

	echo '<ul id="primary-menu">';
	foreach ( $items as $item ) {
		printf(
			'<li><a href="%s">%s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}

/**
 * On theme activation:
 * - Create «خانه» page
 * - Set as front page
 * - Prefer فارسی (fa_IR) so the site is RTL by default
 */
function nexo_theme_activation() {
	// Prefer Persian locale → WordPress adds body.rtl automatically
	if ( ! get_option( 'WPLANG' ) || 'en_US' === get_option( 'WPLANG' ) ) {
		update_option( 'WPLANG', 'fa_IR' );
	}

	if ( get_option( 'nexo_home_page_created' ) ) {
		return;
	}

	$existing = get_page_by_path( 'home' );
	if ( ! $existing ) {
		$existing = get_page_by_title( 'خانه' );
	}
	if ( ! $existing ) {
		$existing = get_page_by_title( 'Home' );
	}

	if ( $existing ) {
		$page_id = $existing->ID;
		// Prefer Persian title
		if ( 'خانه' !== $existing->post_title ) {
			wp_update_post( array(
				'ID'         => $page_id,
				'post_title' => 'خانه',
			) );
		}
	} else {
		$page_id = wp_insert_post( array(
			'post_title'   => 'خانه',
			'post_name'    => 'home',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
			'post_author'  => get_current_user_id() ? get_current_user_id() : 1,
		) );
	}

	if ( $page_id && ! is_wp_error( $page_id ) ) {
		update_post_meta( $page_id, '_wp_page_template', 'page-templates/onepage.php' );
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_id );
		update_option( 'nexo_home_page_created', 1 );
	}
}
add_action( 'after_switch_theme', 'nexo_theme_activation' );

/**
 * One-time: ensure fa_IR + clean old placeholder
 */
function nexo_cleanup_placeholder_content() {
	if ( get_option( 'nexo_placeholder_cleaned_v3' ) ) {
		return;
	}

	// Soft-prefer Persian if still English default
	if ( ! get_option( 'WPLANG' ) ) {
		update_option( 'WPLANG', 'fa_IR' );
	}

	$page_id = (int) get_option( 'page_on_front' );
	if ( $page_id ) {
		$post = get_post( $page_id );
		if ( $post && false !== strpos( (string) $post->post_content, 'Elementor' ) && false !== strpos( (string) $post->post_content, 'NEXO' ) ) {
			if ( ! get_post_meta( $page_id, '_elementor_data', true ) ) {
				wp_update_post( array(
					'ID'           => $page_id,
					'post_content' => '',
				) );
			}
		}

		$tpl = get_post_meta( $page_id, '_wp_page_template', true );
		if ( empty( $tpl ) || 'default' === $tpl ) {
			update_post_meta( $page_id, '_wp_page_template', 'page-templates/onepage.php' );
		}
	}

	update_option( 'nexo_placeholder_cleaned_v3', 1 );
}
add_action( 'init', 'nexo_cleanup_placeholder_content' );
