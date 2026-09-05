<?php
/**
 * NEXO OnePage Theme functions and definitions
 *
 * @package NEXO
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Theme constants
define( 'NEXO_VERSION', '1.0.0' );
define( 'NEXO_DIR', get_template_directory() );
define( 'NEXO_URI', get_template_directory_uri() );
define( 'NEXO_INC', NEXO_DIR . '/inc' );

/**
 * Load theme files
 */
require_once NEXO_INC . '/setup.php';
require_once NEXO_INC . '/enqueue.php';
require_once NEXO_INC . '/cpt.php';
require_once NEXO_INC . '/options.php';
require_once NEXO_INC . '/elementor.php';
require_once NEXO_INC . '/helpers.php';

/**
 * Theme setup
 */
function nexo_theme_setup() {
	// Text domain
	load_theme_textdomain( 'nexo', NEXO_DIR . '/languages' );

	// Theme supports
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

	// Elementor
	add_theme_support( 'elementor' );

	// Menus
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'nexo' ),
		'footer'  => __( 'Footer Menu', 'nexo' ),
	) );

	// Image sizes
	add_image_size( 'nexo-portfolio', 600, 400, true );
	add_image_size( 'nexo-avatar', 120, 120, true );
}
add_action( 'after_setup_theme', 'nexo_theme_setup' );

/**
 * Content width
 */
function nexo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'nexo_content_width', 1200 );
}
add_action( 'after_setup_theme', 'nexo_content_width', 0 );
