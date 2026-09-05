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
