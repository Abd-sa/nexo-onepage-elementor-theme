<?php
/**
 * Accordion helper + FAQ items for Elementor default design
 * Loaded from elementor-default-data.php
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Elementor Accordion widget (expandable FAQ items)
 *
 * @param array $items List of [ 'q' => question, 'a' => answer ]
 * @return array
 */
function nexo_el_accordion( $items ) {
	$tabs = array();

	foreach ( $items as $item ) {
		$tabs[] = array(
			'tab_title'   => isset( $item['q'] ) ? $item['q'] : '',
			'tab_content' => isset( $item['a'] ) ? $item['a'] : '',
			'_id'         => nexo_el_id(),
		);
	}

	return array(
		'id'         => nexo_el_id(),
		'elType'     => 'widget',
		'widgetType' => 'accordion',
		'settings'   => array(
			'tabs'                  => $tabs,
			'selected_icon'         => array(
				'value'   => 'fas fa-plus',
				'library' => 'fa-solid',
			),
			'selected_active_icon'  => array(
				'value'   => 'fas fa-minus',
				'library' => 'fa-solid',
			),
			'title_color'           => '#1A1A2E',
			'tab_active_color'      => '#22C55E',
			'icon_align'            => 'right',
			'border_width'          => array(
				'unit'     => 'px',
				'top'      => '0',
				'right'    => '0',
				'bottom'   => '1',
				'left'     => '0',
				'isLinked' => false,
			),
			'border_color'          => '#E2E8F0',
		),
		'elements'   => array(),
	);
}

/**
 * Default FAQ Q&A list
 */
function nexo_get_default_faq_items() {
	return array(
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
}
