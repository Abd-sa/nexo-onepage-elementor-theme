<?php
/**
 * Helper functions
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

function nexo_get_portfolio_categories() {
	return get_terms(
		array(
			'taxonomy'   => 'nexo_portfolio_cat',
			'hide_empty' => true,
		)
	);
}

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

	if ( is_string( $data ) ) {
		$decoded = json_decode( $data, true );
		if ( ! is_array( $decoded ) || empty( $decoded ) ) {
			return false;
		}
	}

	return true;
}

function nexo_should_show_default_sections( $post_id = null ) {
	if ( nexo_is_elementor_edit_or_preview() ) {
		return false;
	}

	if ( nexo_has_elementor_design( $post_id ) ) {
		return false;
	}

	return true;
}
