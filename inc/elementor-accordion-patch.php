<?php
/**
 * Expandable FAQ (Elementor Accordion) for default homepage design
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Elementor Accordion widget
 *
 * @param array $items [ ['q'=>..., 'a'=>...], ... ]
 * @return array
 */
function nexo_el_accordion( $items ) {
	$tabs = array();

	foreach ( $items as $item ) {
		$tabs[] = array(
			'tab_title'   => isset( $item['q'] ) ? $item['q'] : '',
			'tab_content' => isset( $item['a'] ) ? $item['a'] : '',
			'_id'         => function_exists( 'nexo_el_id' ) ? nexo_el_id() : substr( md5( uniqid( (string) mt_rand(), true ) ), 0, 7 ),
		);
	}

	$id = function_exists( 'nexo_el_id' ) ? nexo_el_id() : substr( md5( uniqid( (string) mt_rand(), true ) ), 0, 7 );

	return array(
		'id'         => $id,
		'elType'     => 'widget',
		'widgetType' => 'accordion',
		'settings'   => array(
			'tabs'                 => $tabs,
			'selected_icon'        => array(
				'value'   => 'fas fa-plus',
				'library' => 'fa-solid',
			),
			'selected_active_icon' => array(
				'value'   => 'fas fa-minus',
				'library' => 'fa-solid',
			),
			'title_color'          => '#1A1A2E',
			'tab_active_color'     => '#22C55E',
			'icon_align'           => 'right',
			'border_width'         => array(
				'unit'     => 'px',
				'top'      => '0',
				'right'    => '0',
				'bottom'   => '1',
				'left'     => '0',
				'isLinked' => false,
			),
			'border_color'         => '#E2E8F0',
		),
		'elements'   => array(),
	);
}

/**
 * Build FAQ + Contact section with expandable accordion
 *
 * @param string $primary Primary color hex
 * @return array Elementor container element
 */
function nexo_build_faq_contact_section( $primary = '#22C55E' ) {
	$faq_items = array(
		array(
			'q' => 'How long does a project take?',
			'a' => 'Most projects take between 2 to 6 weeks depending on scope and complexity.',
		),
		array(
			'q' => 'Do you provide support after delivery?',
			'a' => 'Yes, every package includes a support period. Extended support is also available.',
		),
		array(
			'q' => 'Can you work with my existing website?',
			'a' => 'Absolutely. I can redesign, improve or extend existing websites.',
		),
		array(
			'q' => 'What do I need to get started?',
			'a' => 'Just a brief description of your goals, any existing brand assets, and your preferred timeline.',
		),
	);

	return nexo_el_container(
		array(
			nexo_el_inner_container(
				array(
					nexo_el_inner_container(
						array(
							nexo_el_heading(
								'FAQ',
								array(
									'header_size'            => 'p',
									'title_color'            => $primary,
									'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
									'typography_font_weight' => '600',
								)
							),
							nexo_el_heading( 'Frequently Asked Questions' ),
							nexo_el_accordion( $faq_items ),
						),
						array(
							'content_width' => 'full',
							'width'         => array( 'unit' => '%', 'size' => 50 ),
						)
					),
					nexo_el_inner_container(
						array(
							nexo_el_heading(
								'CONTACT',
								array(
									'header_size'            => 'p',
									'title_color'            => $primary,
									'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
									'typography_font_weight' => '600',
								)
							),
							nexo_el_heading( "Let's Work Together" ),
							nexo_el_text( '<p style="color:#64748B;">Replace this with an Elementor Form or Contact Form 7 widget.</p><p>hello@example.com<br>+98 912 345 6789<br>Tehran, Iran<br>Mon – Fri: 9AM – 6PM</p>' ),
							nexo_el_button( 'Send Message', '#', array() ),
						),
						array(
							'content_width' => 'full',
							'width'         => array( 'unit' => '%', 'size' => 50 ),
						)
					),
				),
				array(
					'flex_direction' => 'row',
					'flex_gap'       => array( 'unit' => 'px', 'size' => 40 ),
					'content_width'  => 'full',
				)
			),
		),
		array(
			'background_background' => 'classic',
			'background_color'      => '#F8FAFC',
		)
	);
}

/**
 * Swap last section of default Elementor data with expandable FAQ version
 *
 * @param array $data
 * @return array
 */
function nexo_inject_expandable_faq( $data ) {
	if ( ! is_array( $data ) || empty( $data ) ) {
		return $data;
	}

	$primary = nexo_get_option( 'color_primary', '#22C55E' );

	// Replace the last top-level section (FAQ+Contact)
	array_pop( $data );
	$data[] = nexo_build_faq_contact_section( $primary );

	return $data;
}
