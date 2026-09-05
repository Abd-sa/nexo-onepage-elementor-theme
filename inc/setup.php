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
 * Default instructional content so the block editor is not empty
 * and the user knows to open Elementor.
 */
function nexo_get_home_placeholder_content() {
	return '<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
<!-- wp:heading {"textAlign":"center","level":2} -->
<h2 class="wp-block-heading has-text-align-center">صفحه اصلی NEXO</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">این صفحه را با <strong>Elementor</strong> ویرایش کنید.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">از دکمه <strong>«Edit with Elementor»</strong> در بالای صفحه یا نوار ادمین استفاده کنید.<br>تا قبل از ذخیره طراحی در Elementor، نسخه پیش‌فرض سکشن‌های تم در سایت نمایش داده می‌شود.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->';
}

/**
 * On theme activation: create Home page with placeholder content +
 * NEXO OnePage template + set as static front page.
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
		// If page exists but is empty, add placeholder so editor is not blank
		if ( '' === trim( (string) $existing->post_content ) ) {
			wp_update_post( array(
				'ID'           => $page_id,
				'post_content' => nexo_get_home_placeholder_content(),
			) );
		}
	} else {
		$page_id = wp_insert_post( array(
			'post_title'   => 'Home',
			'post_name'    => 'home',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => nexo_get_home_placeholder_content(),
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
 * One-time upgrade for existing installs: fix empty Home page content
 */
function nexo_maybe_fix_home_content() {
	if ( get_option( 'nexo_home_content_fixed' ) ) {
		return;
	}

	$page_id = (int) get_option( 'page_on_front' );
	if ( ! $page_id ) {
		update_option( 'nexo_home_content_fixed', 1 );
		return;
	}

	$post = get_post( $page_id );
	if ( $post && '' === trim( (string) $post->post_content ) ) {
		wp_update_post( array(
			'ID'           => $page_id,
			'post_content' => nexo_get_home_placeholder_content(),
		) );
	}

	// Ensure template is set
	if ( $post ) {
		$tpl = get_post_meta( $page_id, '_wp_page_template', true );
		if ( empty( $tpl ) || 'default' === $tpl ) {
			update_post_meta( $page_id, '_wp_page_template', 'page-templates/onepage.php' );
		}
	}

	update_option( 'nexo_home_content_fixed', 1 );
}
add_action( 'admin_init', 'nexo_maybe_fix_home_content' );
