<?php
/**
 * Custom Elementor widgets: Portfolio Grid + Testimonials
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register widgets after Elementor is ready
 */
function nexo_register_elementor_widgets( $widgets_manager ) {
	require_once NEXO_INC . '/widgets/class-nexo-portfolio-widget.php';
	require_once NEXO_INC . '/widgets/class-nexo-testimonials-widget.php';

	$widgets_manager->register( new \NEXO_Portfolio_Widget() );
	$widgets_manager->register( new \NEXO_Testimonials_Widget() );
}
add_action( 'elementor/widgets/register', 'nexo_register_elementor_widgets' );
