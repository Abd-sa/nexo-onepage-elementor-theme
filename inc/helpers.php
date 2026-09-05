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

	if ( ! isset( $plugin->editor ) || ! isset( $plugin->preview ) ) {
		return false;
	}

	return $plugin->editor->is_edit_mode() || $plugin->preview->is_preview_mode();
}

/**
 * Was this post built / saved with Elementor?
 */
function nexo_is_built_with_elementor( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( ! $post_id || ! defined( 'ELEMENTOR_VERSION' ) || ! class_exists( '\Elementor\Plugin' ) ) {
		return false;
	}

	return \Elementor\Plugin::$instance->db->is_built_with_elementor( $post_id );
}

/**
 * Should we render the default PHP one-page sections?
 *
 * false = show the_content() (Elementor or block/classic content)
 * true  = show built-in template-parts
 */
function nexo_should_show_default_sections( $post_id = null ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	// Always let Elementor editor / preview take over
	if ( nexo_is_elementor_edit_or_preview() ) {
		return false;
	}

	// Page already designed with Elementor
	if ( nexo_is_built_with_elementor( $post_id ) ) {
		return false;
	}

	// Has real content from block/classic editor (not just our placeholder)
	$content = $post_id ? get_post_field( 'post_content', $post_id ) : '';
	$content = trim( wp_strip_all_tags( (string) $content ) );

	// Ignore our instructional placeholder text
	$placeholder_markers = array(
		'Edit with Elementor',
		'ویرایش با Elementor',
		'این صفحه را با Elementor',
	);

	foreach ( $placeholder_markers as $marker ) {
		if ( false !== strpos( (string) get_post_field( 'post_content', $post_id ), $marker ) ) {
			// Still empty of real design → show default sections on frontend
			return true;
		}
	}

	if ( $content !== '' ) {
		return false;
	}

	return true;
}
