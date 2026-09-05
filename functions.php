<?php
/**
 * NEXO OnePage Theme functions and definitions
 *
 * @package NEXO
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NEXO_VERSION', '1.1.0' );
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

function nexo_theme_setup() {
	load_theme_textdomain( 'nexo', NEXO_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'elementor' );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'nexo' ),
		'footer'  => __( 'Footer Menu', 'nexo' ),
	) );

	add_image_size( 'nexo-portfolio', 600, 400, true );
	add_image_size( 'nexo-avatar', 120, 120, true );
}
add_action( 'after_setup_theme', 'nexo_theme_setup' );

function nexo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'nexo_content_width', 1200 );
}
add_action( 'after_setup_theme', 'nexo_content_width', 0 );

/**
 * After Elementor is loaded: inject default designed homepage once
 */
function nexo_maybe_inject_elementor_home() {
	if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
		return;
	}
	if ( get_option( 'nexo_elementor_home_injected_v1' ) ) {
		return;
	}

	$page_id = (int) get_option( 'page_on_front' );
	if ( ! $page_id ) {
		// Ensure home page exists
		nexo_theme_activation();
		$page_id = (int) get_option( 'page_on_front' );
	}

	if ( $page_id ) {
		nexo_apply_default_elementor_design( $page_id );
	}

	update_option( 'nexo_elementor_home_injected_v1', 1 );
}
add_action( 'elementor/init', 'nexo_maybe_inject_elementor_home', 20 );
add_action( 'admin_init', 'nexo_maybe_inject_elementor_home', 30 );

/**
 * Admin button to re-import default Elementor design (for testing)
 */
function nexo_handle_reimport_design() {
	if ( ! isset( $_GET['nexo_reimport_design'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	check_admin_referer( 'nexo_reimport_design' );

	$page_id = (int) get_option( 'page_on_front' );
	if ( $page_id && defined( 'ELEMENTOR_VERSION' ) ) {
		// Force re-import: clear existing elementor data first
		delete_post_meta( $page_id, '_elementor_data' );
		delete_post_meta( $page_id, '_elementor_css' );
		delete_option( 'nexo_elementor_home_injected_v1' );
		nexo_apply_default_elementor_design( $page_id );
		update_option( 'nexo_elementor_home_injected_v1', 1 );
	}

	wp_safe_redirect( admin_url( 'post.php?post=' . $page_id . '&action=elementor' ) );
	exit;
}
add_action( 'admin_init', 'nexo_handle_reimport_design' );
