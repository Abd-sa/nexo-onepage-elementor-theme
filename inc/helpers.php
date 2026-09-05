<?php
/**
 * Helper functions
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get portfolio items
 */
function nexo_get_portfolio_items( $count = 8 ) {
	$args = array(
		'post_type'      => 'nexo_portfolio',
		'posts_per_page' => $count,
		'post_status'    => 'publish',
		'orderby'        => 'menu_order date',
		'order'          => 'DESC',
	);

	return new WP_Query( $args );
}

/**
 * Get testimonials
 */
function nexo_get_testimonials( $count = 3 ) {
	$args = array(
		'post_type'      => 'nexo_testimonial',
		'posts_per_page' => $count,
		'post_status'    => 'publish',
		'orderby'        => 'menu_order date',
		'order'          => 'DESC',
	);

	return new WP_Query( $args );
}

/**
 * Get portfolio categories for filters
 */
function nexo_get_portfolio_categories() {
	return get_terms( array(
		'taxonomy'   => 'nexo_portfolio_cat',
		'hide_empty' => true,
	) );
}

/**
 * Is Elementor currently in edit or preview mode?
 */
function nexo_is_elementor_edit_or_preview() {
	if ( ! defined( 'ELEMENTOR_VERSION' ) || ! class_exists( '\Elementor\Plugin' ) ) {
		return false;
	}

	$plugin = \Elementor\Plugin::$instance;

	if ( empty( $plugin->editor ) || empty( $plugin->preview ) ) {
		return false;
	}

	return (bool) ( $plugin->editor->is_edit_mode() || $plugin->preview->is_preview_mode() );
}

/**
 * Does this post have a REAL Elementor design saved?
 * (not just opened once — actual widget data)
 */
function nexo_has_elementor_design( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_queried_object_id();
	}
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}
	if ( ! $post_id ) {
		return false;
	}

	$data = get_post_meta( $post_id, '_elementor_data', true );

	if ( empty( $data ) || '[]' === $data || 'null' === $data ) {
		return false;
	}

	// Must contain at least one element structure
	if ( is_string( $data ) ) {
		$decoded = json_decode( $data, true );
		if ( ! is_array( $decoded ) || empty( $decoded ) ) {
			return false;
		}
	}

	return true;
}

/**
 * Should we render the default PHP one-page sections on the frontend?
 *
 * Priority:
 * 1. Elementor editor/preview → NO (need the_content for canvas)
 * 2. Real Elementor design saved → NO (show Elementor output)
 * 3. Everything else → YES (beautiful default sections)
 *
 * Placeholder text in the page editor is IGNOREED on the frontend.
 */
function nexo_should_show_default_sections( $post_id = null ) {
	// Inside Elementor editor or preview: always use the_content()
	if ( nexo_is_elementor_edit_or_preview() ) {
		return false;
	}

	// Real design exists in Elementor → use it
	if ( nexo_has_elementor_design( $post_id ) ) {
		return false;
	}

	// Default: always show the theme's designed sections
	return true;
}
