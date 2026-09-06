<?php
/**
 * NEXO OnePage Theme functions and definitions
 *
 * @package NEXO
 * @version 1.7.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NEXO_VERSION', '1.7.2' );
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
require_once NEXO_INC . '/elementor-widgets.php';
require_once NEXO_INC . '/demo-import.php';
require_once NEXO_INC . '/ajax.php';

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
			'primary' => 'Primary Menu',
			'footer'  => 'Footer Menu',
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

function nexo_seed_elementor_design_if_empty( $page_id ) {
	if ( ! $page_id || ! defined( 'ELEMENTOR_VERSION' ) ) {
		return false;
	}

	if ( ! function_exists( 'nexo_has_elementor_design' ) || ! function_exists( 'nexo_get_default_elementor_data' ) ) {
		return false;
	}

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

	if ( class_exists( '\Elementor\Plugin' ) ) {
		$plugin = \Elementor\Plugin::$instance;
		if ( isset( $plugin->files_manager ) ) {
			$plugin->files_manager->clear_cache();
		}
	}

	return true;
}

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

function nexo_handle_reimport_design() {
	if ( ! isset( $_GET['nexo_reimport_design'] ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	check_admin_referer( 'nexo_reimport_design' );

	if ( empty( $_GET['confirm'] ) || '1' !== (string) $_GET['confirm'] ) {
		wp_die( 'Confirm required.', 'Error', array( 'response' => 403, 'back_link' => true ) );
	}

	$page_id = (int) get_option( 'page_on_front' );
	if ( ! $page_id || ! defined( 'ELEMENTOR_VERSION' ) ) {
		wp_safe_redirect( admin_url( 'admin.php?page=nexo-settings' ) );
		exit;
	}

	delete_post_meta( $page_id, '_elementor_data' );
	delete_post_meta( $page_id, '_elementor_css' );
	delete_post_meta( $page_id, '_elementor_edit_mode' );

	nexo_seed_elementor_design_if_empty( $page_id );

	wp_safe_redirect( admin_url( 'post.php?post=' . $page_id . '&action=elementor' ) );
	exit;
}
add_action( 'admin_init', 'nexo_handle_reimport_design' );

function nexo_handle_style_preset() {
	if ( ! isset( $_GET['nexo_preset'] ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	check_admin_referer( 'nexo_preset' );

	$preset = sanitize_key( wp_unslash( $_GET['nexo_preset'] ) );
	$map    = array(
		'designer'     => array(
			'color_primary'   => '#22c55e',
			'color_secondary' => '#16a34a',
			'color_accent'    => '#a855f7',
			'hero_badge'      => 'Hello',
			'hero_title'      => 'Sara Design',
			'hero_subtitle'   => 'UI/UX Designer',
			'hero_desc'       => 'I design digital products.',
		),
		'developer'    => array(
			'color_primary'   => '#3b82f6',
			'color_secondary' => '#2563eb',
			'color_accent'    => '#06b6d4',
			'hero_badge'      => 'Hello',
			'hero_title'      => 'Ali Code',
			'hero_subtitle'   => 'Web Developer',
			'hero_desc'       => 'I build fast websites.',
		),
		'photographer' => array(
			'color_primary'   => '#f59e0b',
			'color_secondary' => '#d97706',
			'color_accent'    => '#ef4444',
			'hero_badge'      => 'Hello',
			'hero_title'      => 'Nima Photo',
			'hero_subtitle'   => 'Photographer',
			'hero_desc'       => 'I capture moments.',
		),
	);

	if ( ! isset( $map[ $preset ] ) ) {
		wp_safe_redirect( admin_url( 'admin.php?page=nexo-settings' ) );
		exit;
	}

	$options = get_option( 'nexo_options', array() );
	if ( ! is_array( $options ) ) {
		$options = array();
	}
	$options = array_merge( $options, $map[ $preset ] );
	update_option( 'nexo_options', $options );

	wp_safe_redirect( admin_url( 'admin.php?page=nexo-settings&preset_applied=1' ) );
	exit;
}
add_action( 'admin_init', 'nexo_handle_style_preset' );
