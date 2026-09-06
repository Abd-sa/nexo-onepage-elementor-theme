<?php
/**
 * NEXO OnePage Theme functions and definitions
 *
 * @package NEXO
 * @version 1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NEXO_VERSION', '1.3.0' );
define( 'NEXO_DIR', get_template_directory() );
define( 'NEXO_URI', get_template_directory_uri() );
define( 'NEXO_INC', NEXO_DIR . '/inc' );

require_once NEXO_INC . '/setup.php';
require_once NEXO_INC . '/enqueue.php';
require_once NEXO_INC . '/cpt.php';
require_once NEXO_INC . '/options.php';
require_once NEXO_INC . '/helpers.php';
require_once NEXO_INC . '/elementor.php';
require_once NEXO_INC . '/elementor-default-data.php';
require_once NEXO_INC . '/elementor-accordion-patch.php';
require_once NEXO_INC . '/elementor-fa-defaults.php';

/**
 * Theme supports & menus
 */
function nexo_theme_setup() {
	load_theme_textdomain( 'nexo', NEXO_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 60,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'elementor' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'nexo' ),
			'footer'  => __( 'Footer Menu', 'nexo' ),
		)
	);

	add_image_size( 'nexo-portfolio', 600, 400, true );
	add_image_size( 'nexo-avatar', 120, 120, true );
}
add_action( 'after_setup_theme', 'nexo_theme_setup' );

function nexo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'nexo_content_width', 1200 );
}
add_action( 'after_setup_theme', 'nexo_content_width', 0 );

/**
 * Seed default Elementor design ONLY when:
 * - Elementor is active
 * - Front page exists
 * - Page has NO real Elementor data yet
 * - Never deletes or overwrites an existing design
 *
 * @param int $page_id Page ID.
 * @return bool
 */
function nexo_seed_elementor_design_if_empty( $page_id ) {
	if ( ! $page_id || ! defined( 'ELEMENTOR_VERSION' ) ) {
		return false;
	}

	if ( ! function_exists( 'nexo_has_elementor_design' ) || ! function_exists( 'nexo_get_default_elementor_data' ) ) {
		return false;
	}

	// Never touch a page that already has a design
	if ( nexo_has_elementor_design( $page_id ) ) {
		return false;
	}

	$data = nexo_get_default_elementor_data();

	if ( function_exists( 'nexo_inject_expandable_faq' ) ) {
		$data = nexo_inject_expandable_faq( $data );
	}

	$json = wp_json_encode( $data );
	if ( ! $json ) {
		return false;
	}

	update_post_meta( $page_id, '_elementor_edit_mode', 'builder' );
	update_post_meta( $page_id, '_elementor_template_type', 'wp-page' );
	update_post_meta( $page_id, '_elementor_version', ELEMENTOR_VERSION );
	update_post_meta( $page_id, '_elementor_data', wp_slash( $json ) );
	update_post_meta( $page_id, '_elementor_page_settings', array() );
	delete_post_meta( $page_id, '_elementor_css' );

	if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->files_manager ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}

	return true;
}

/**
 * On first run after theme + Elementor are ready: seed empty home only once.
 * Does NOT delete existing designs.
 */
function nexo_maybe_seed_home_elementor() {
	if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
		return;
	}

	if ( get_option( 'nexo_elementor_seeded_v1' ) ) {
		return;
	}

	$page_id = (int) get_option( 'page_on_front' );
	if ( ! $page_id && function_exists( 'nexo_theme_activation' ) ) {
		nexo_theme_activation();
		$page_id = (int) get_option( 'page_on_front' );
	}

	if ( $page_id ) {
		nexo_seed_elementor_design_if_empty( $page_id );
	}

	update_option( 'nexo_elementor_seeded_v1', 1 );
}
add_action( 'elementor/init', 'nexo_maybe_seed_home_elementor', 20 );

/**
 * Manual re-import (admin only, nonce-protected).
 * Requires explicit confirmation query arg.
 */
function nexo_handle_reimport_design() {
	if ( ! isset( $_GET['nexo_reimport_design'] ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	check_admin_referer( 'nexo_reimport_design' );

	// Require explicit confirm=1 to avoid accidental clicks
	if ( empty( $_GET['confirm'] ) || '1' !== (string) $_GET['confirm'] ) {
		wp_die(
			esc_html__( 'برای بازنشانی طراحی باید تأیید کنید. از دکمه داخل پنل تنظیمات استفاده کنید.', 'nexo' ),
			esc_html__( 'تأیید لازم است', 'nexo' ),
			array( 'response' => 403, 'back_link' => true )
		);
	}

	$page_id = (int) get_option( 'page_on_front' );
	if ( ! $page_id || ! defined( 'ELEMENTOR_VERSION' ) ) {
		wp_safe_redirect( admin_url( 'themes.php' ) );
		exit;
	}

	// Explicit overwrite only after confirm
	delete_post_meta( $page_id, '_elementor_data' );
	delete_post_meta( $page_id, '_elementor_css' );
	delete_post_meta( $page_id, '_elementor_edit_mode' );

	nexo_seed_elementor_design_if_empty( $page_id );

	wp_safe_redirect( admin_url( 'post.php?post=' . $page_id . '&action=elementor' ) );
	exit;
}
add_action( 'admin_init', 'nexo_handle_reimport_design' );
