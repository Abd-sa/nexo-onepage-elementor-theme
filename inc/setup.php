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
 * Fallback menu when no menu is assigned
 */
function nexo_fallback_menu() {
	$items = array(
		'home'         => array( 'label' => __( 'Home', 'nexo' ),         'url' => home_url( '/' ) ),
		'about'        => array( 'label' => __( 'About', 'nexo' ),        'url' => '#about' ),
		'services'     => array( 'label' => __( 'Services', 'nexo' ),     'url' => '#services' ),
		'portfolio'    => array( 'label' => __( 'Portfolio', 'nexo' ),    'url' => '#portfolio' ),
		'testimonials' => array( 'label' => __( 'Testimonials', 'nexo' ), 'url' => '#testimonials' ),
		'pricing'      => array( 'label' => __( 'Pricing', 'nexo' ),      'url' => '#pricing' ),
		'faq'          => array( 'label' => __( 'FAQ', 'nexo' ),          'url' => '#faq' ),
		'contact'      => array( 'label' => __( 'Contact', 'nexo' ),      'url' => '#contact' ),
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
 * On theme activation: create Home page (empty content is fine —
 * frontend always shows designed sections until Elementor has real data).
 */
function nexo_theme_activation() {
	if ( get_option( 'nexo_home_page_created' ) ) {
		return;
	}

	$existing = get_page_by_path( 'home' );
	if ( ! $existing ) {
		$existing = get_page_by_title( 'Home' );
	}
	if ( ! $existing ) {
		$existing = get_page_by_title( 'خانه' );
	}

	if ( $existing ) {
		$page_id = $existing->ID;
	} else {
		$page_id = wp_insert_post( array(
			'post_title'   => 'Home',
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
 * Clean up old placeholder content from previous versions so it never
 * confuses the frontend. Safe to run once.
 */
function nexo_cleanup_placeholder_content() {
	if ( get_option( 'nexo_placeholder_cleaned_v2' ) ) {
		return;
	}

	$page_id = (int) get_option( 'page_on_front' );
	if ( $page_id ) {
		$post = get_post( $page_id );
		if ( $post && false !== strpos( (string) $post->post_content, 'Elementor' ) && false !== strpos( (string) $post->post_content, 'NEXO' ) ) {
			// Only clear if it looks like our instructional placeholder, not a real design
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

	update_option( 'nexo_placeholder_cleaned_v2', 1 );
}
add_action( 'init', 'nexo_cleanup_placeholder_content' );
