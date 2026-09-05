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
