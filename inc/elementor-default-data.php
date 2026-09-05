<?php
/**
 * Default Elementor document data for NEXO Home page
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nexo_el_id() {
	return substr( md5( uniqid( (string) mt_rand(), true ) ), 0, 7 );
}

function nexo_el_heading( $title, $settings = array() ) {
	$defaults = array(
		'title'                  => $title,
		'header_size'            => 'h2',
		'align'                  => 'right',
		'title_color'            => '#1A1A2E',
		'typography_typography'  => 'custom',
		'typography_font_weight' => '700',
	);
	$settings = array_merge( $defaults, $settings );

	return array(
		'id'         => nexo_el_id(),
		'elType'     => 'widget',
		'widgetType' => 'heading',
		'settings'   => $settings,
		'elements'   => array(),
	);
}

function nexo_el_text( $html, $settings = array() ) {
	$defaults = array(
		'editor' => $html,
		'align'  => 'right',
	);
	return array(
		'id'         => nexo_el_id(),
		'elType'     => 'widget',
		'widgetType' => 'text-editor',
		'settings'   => array_merge( $defaults, $settings ),
		'elements'   => array(),
	);
}

function nexo_el_button( $text, $link = '#', $settings = array() ) {
	$defaults = array(
		'text'                   => $text,
		'link'                   => array( 'url' => $link ),
		'align'                  => 'right',
		'background_color'       => '#22C55E',
		'button_text_color'      => '#FFFFFF',
		'border_radius'          => array(
			'unit'     => 'px',
			'top'      => '8',
			'right'    => '8',
			'bottom'   => '8',
			'left'     => '8',
			'isLinked' => true,
		),
		'typography_typography'  => 'custom',
		'typography_font_weight' => '600',
	);
	return array(
		'id'         => nexo_el_id(),
		'elType'     => 'widget',
		'widgetType' => 'button',
		'settings'   => array_merge( $defaults, $settings ),
		'elements'   => array(),
	);
}

function nexo_el_spacer( $size = 30 ) {
	return array(
		'id'         => nexo_el_id(),
		'elType'     => 'widget',
		'widgetType' => 'spacer',
		'settings'   => array(
			'space' => array( 'unit' => 'px', 'size' => $size ),
		),
		'elements'   => array(),
	);
}

function nexo_el_icon_box( $title, $description, $icon = 'fas fa-star' ) {
	return array(
		'id'         => nexo_el_id(),
		'elType'     => 'widget',
		'widgetType' => 'icon-box',
		'settings'   => array(
			'title_text'        => $title,
			'description_text'  => $description,
			'selected_icon'     => array(
				'value'   => $icon,
				'library' => 'fa-solid',
			),
			'position'          => 'top',
			'title_color'       => '#FFFFFF',
			'description_color' => '#94A3B8',
			'primary_color'     => '#22C55E',
			'align'             => 'right',
		),
		'elements'   => array(),
	);
}

function nexo_el_container( $elements, $settings = array() ) {
	$defaults = array(
		'content_width'  => 'boxed',
		'boxed_width'    => array( 'unit' => 'px', 'size' => 1200 ),
		'flex_direction' => 'column',
		'padding'        => array(
			'unit'     => 'px',
			'top'      => '80',
			'right'    => '20',
			'bottom'   => '80',
			'left'     => '20',
			'isLinked' => false,
		),
	);

	return array(
		'id'       => nexo_el_id(),
		'elType'   => 'container',
		'settings' => array_merge( $defaults, $settings ),
		'elements' => $elements,
		'isInner'  => false,
	);
}

function nexo_el_inner_container( $elements, $settings = array() ) {
	$defaults = array(
		'content_width'  => 'full',
		'flex_direction' => 'column',
		'flex_grow'      => 1,
	);
	return array(
		'id'       => nexo_el_id(),
		'elType'   => 'container',
		'settings' => array_merge( $defaults, $settings ),
		'elements' => $elements,
		'isInner'  => true,
	);
}

function nexo_get_default_elementor_data() {
	$primary = nexo_get_option( 'color_primary', '#22C55E' );
	$name    = nexo_get_option( 'hero_title', 'Ali Rezaei' );
	$badge   = nexo_get_option( 'hero_badge', "HELLO, I'M" );
	$sub     = nexo_get_option( 'hero_subtitle', 'I build digital products, brands and experiences.' );
	$desc    = nexo_get_option( 'hero_desc', "I'm a freelance UI/UX designer and front-end developer based in Tehran." );

	$hero_left = nexo_el_inner_container(
		array(
			nexo_el_heading( $badge, array(
				'header_size'            => 'p',
				'title_color'            => $primary,
				'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
				'typography_font_weight' => '600',
			) ),
			nexo_el_heading( $name, array(
				'header_size'            => 'h1',
				'typography_font_size'   => array( 'unit' => 'px', 'size' => 48 ),
				'typography_font_weight' => '800',
			) ),
			nexo_el_heading( $sub, array(
				'header_size'            => 'h3',
				'typography_font_size'   => array( 'unit' => 'px', 'size' => 22 ),
				'typography_font_weight' => '600',
			) ),
			nexo_el_text( '<p>' . esc_html( $desc ) . '</p>', array( 'text_color' => '#64748B' ) ),
			nexo_el_spacer( 16 ),
			nexo_el_inner_container(
				array(
					nexo_el_button( 'Download CV', '#', array( 'align' => 'right' ) ),
					nexo_el_button(
						"Let's Talk",
						'#contact',
						array(
							'background_color'  => 'transparent',
							'button_text_color' => $primary,
							'border_border'     => 'solid',
							'border_width'      => array(
								'unit'     => 'px',
								'top'      => '2',
								'right'    => '2',
								'bottom'   => '2',
								'left'     => '2',
								'isLinked' => true,
							),
							'border_color' => $primary,
						)
					),
				),
				array(
					'flex_direction' => 'row',
					'flex_gap'       => array( 'unit' => 'px', 'size' => 12 ),
					'content_width'  => 'full',
				)
			),
		),
		array(
			'content_width' => 'full',
			'width'         => array( 'unit' => '%', 'size' => 55 ),
		)
	);

	$hero_right = nexo_el_inner_container(
		array(
			nexo_el_heading(
				'5+ Years',
				array(
					'header_size' => 'h3',
					'align'       => 'center',
					'title_color' => $primary,
				)
			),
			nexo_el_text(
				'<p style="text-align:center">Experience · 50+ Projects Completed</p>',
				array( 'align' => 'center' )
			),
		),
		array(
			'content_width'         => 'full',
			'width'                 => array( 'unit' => '%', 'size' => 45 ),
			'background_background' => 'classic',
			'background_color'      => '#F1F5F9',
			'border_radius'         => array(
				'unit'     => 'px',
				'top'      => '20',
				'right'    => '20',
				'bottom'   => '20',
				'left'     => '20',
				'isLinked' => true,
			),
			'padding'               => array(
				'unit'     => 'px',
				'top'      => '60',
				'right'    => '30',
				'bottom'   => '60',
				'left'     => '30',
				'isLinked' => false,
			),
			'justify_content'       => 'center',
		)
	);

	$hero = nexo_el_container(
		array(
			nexo_el_inner_container(
				array( $hero_left, $hero_right ),
				array(
					'flex_direction'   => 'row',
					'flex_gap'         => array( 'unit' => 'px', 'size' => 40 ),
					'content_width'    => 'full',
					'flex_align_items' => 'center',
				)
			),
			nexo_el_spacer( 40 ),
			nexo_el_text(
				'<p style="text-align:center;letter-spacing:1px;color:#94A3B8;font-size:13px;">TRUSTED BY 100+ CLIENTS WORLDWIDE</p><p style="text-align:center;opacity:0.6;font-weight:600;">Google &nbsp; Microsoft &nbsp; Slack &nbsp; Airbnb &nbsp; Spotify &nbsp; Amazon</p>',
				array( 'align' => 'center' )
			),
		),
		array(
			'background_background' => 'classic',
			'background_color'      => '#F8FAFC',
		)
	);

	$about = nexo_el_container(
		array(
			nexo_el_inner_container(
				array(
					nexo_el_inner_container(
						array(
							nexo_el_heading(
								'About Image',
								array(
									'align'       => 'center',
									'header_size' => 'h4',
									'title_color' => '#94A3B8',
								)
							),
							nexo_el_text(
								'<p style="text-align:center;color:#94A3B8;">Replace this with your photo in Elementor</p>',
								array( 'align' => 'center' )
							),
						),
						array(
							'content_width'         => 'full',
							'width'                 => array( 'unit' => '%', 'size' => 45 ),
							'background_background' => 'classic',
							'background_color'      => '#E2E8F0',
							'border_radius'         => array(
								'unit'     => 'px',
								'top'      => '16',
								'right'    => '16',
								'bottom'   => '16',
								'left'     => '16',
								'isLinked' => true,
							),
							'padding'               => array(
								'unit'     => 'px',
								'top'      => '80',
								'right'    => '20',
								'bottom'   => '80',
								'left'     => '20',
								'isLinked' => false,
							),
							'justify_content'       => 'center',
						)
					),
					nexo_el_inner_container(
						array(
							nexo_el_heading(
								'ABOUT ME',
								array(
									'header_size'            => 'p',
									'title_color'            => $primary,
									'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
									'typography_font_weight' => '600',
								)
							),
							nexo_el_heading( 'Designing Solutions That Make a Difference' ),
							nexo_el_text( '<p style="color:#64748B;">I combine creativity, technology and strategy to build products that are beautiful and functional.</p>' ),
							nexo_el_spacer( 12 ),
							nexo_el_text( '<p><strong>UI/UX Design</strong> — 95%</p><p><strong>Web Development</strong> — 90%</p><p><strong>Branding Design</strong> — 85%</p>' ),
						),
						array(
							'content_width' => 'full',
							'width'         => array( 'unit' => '%', 'size' => 55 ),
						)
					),
				),
				array(
					'flex_direction'   => 'row',
					'flex_gap'         => array( 'unit' => 'px', 'size' => 40 ),
					'content_width'    => 'full',
					'flex_align_items' => 'center',
				)
			),
		),
		array(
			'background_background' => 'classic',
			'background_color'      => '#FFFFFF',
		)
	);

	$service_card = function( $title, $desc, $icon ) {
		return nexo_el_inner_container(
			array( nexo_el_icon_box( $title, $desc, $icon ) ),
			array(
				'content_width'         => 'full',
				'width'                 => array( 'unit' => '%', 'size' => 25 ),
				'background_background' => 'classic',
				'background_color'      => '#0F172A',
				'border_radius'         => array(
					'unit'     => 'px',
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'isLinked' => true,
				),
				'padding'               => array(
					'unit'     => 'px',
					'top'      => '32',
					'right'    => '24',
					'bottom'   => '32',
					'left'     => '24',
					'isLinked' => true,
				),
			)
		);
	};

	$services_row = nexo_el_inner_container(
		array(
			$service_card( 'UI/UX Design', 'I design intuitive and beautiful interfaces that users love.', 'fas fa-pencil-ruler' ),
			$service_card( 'Web Development', 'I build fast, responsive and modern websites.', 'fas fa-code' ),
			$service_card( 'Branding Design', 'I create unique brand identities that stand out.', 'fas fa-palette' ),
			$service_card( 'SEO Optimization', 'I optimize websites to rank higher and get more traffic.', 'fas fa-chart-line' ),
		),
		array(
			'flex_direction' => 'row',
			'flex_gap'       => array( 'unit' => 'px', 'size' => 20 ),
			'content_width'  => 'full',
		)
	);

	$services = nexo_el_container(
		array(
			nexo_el_heading(
				'SERVICES',
				array(
					'header_size'            => 'p',
					'align'                  => 'center',
					'title_color'            => $primary,
					'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
					'typography_font_weight' => '600',
				)
			),
			nexo_el_heading(
				'What I Can Do For You',
				array(
					'align'       => 'center',
					'title_color' => '#FFFFFF',
				)
			),
			nexo_el_spacer( 24 ),
			$services_row,
		),
		array(
			'background_background' => 'classic',
			'background_color'      => '#0F172A',
		)
	);

	$portfolio = nexo_el_container(
		array(
			nexo_el_heading(
				'PORTFOLIO',
				array(
					'header_size'            => 'p',
					'title_color'            => $primary,
					'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
					'typography_font_weight' => '600',
				)
			),
			nexo_el_heading( 'Selected Works' ),
			nexo_el_text( '<p style="color:#64748B;">Add projects from the <strong>Portfolio</strong> menu. You can replace this section with Posts or Gallery widgets in Elementor.</p>' ),
			nexo_el_spacer( 16 ),
			nexo_el_button(
				'View All Projects',
				'#',
				array(
					'background_color'  => 'transparent',
					'button_text_color' => $primary,
					'border_border'     => 'solid',
					'border_width'      => array(
						'unit'     => 'px',
						'top'      => '2',
						'right'    => '2',
						'bottom'   => '2',
						'left'     => '2',
						'isLinked' => true,
					),
					'border_color' => $primary,
				)
			),
		),
		array(
			'background_background' => 'classic',
			'background_color'      => '#FFFFFF',
		)
	);

	$testimonial_card = function( $quote, $name, $role ) {
		return nexo_el_inner_container(
			array(
				nexo_el_text(
					'<p style="font-style:italic;">' . $quote . '</p><p><strong>' . $name . '</strong><br><span style="color:#64748B;">' . $role . '</span></p>'
				),
			),
			array(
				'content_width'         => 'full',
				'width'                 => array( 'unit' => '%', 'size' => 33 ),
				'background_background' => 'classic',
				'background_color'      => '#FFFFFF',
				'border_border'         => 'solid',
				'border_width'          => array(
					'unit'     => 'px',
					'top'      => '1',
					'right'    => '1',
					'bottom'   => '1',
					'left'     => '1',
					'isLinked' => true,
				),
				'border_color'          => '#E2E8F0',
				'border_radius'         => array(
					'unit'     => 'px',
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'isLinked' => true,
				),
				'padding'               => array(
					'unit'     => 'px',
					'top'      => '28',
					'right'    => '24',
					'bottom'   => '28',
					'left'     => '24',
					'isLinked' => true,
				),
			)
		);
	};

	$testimonials = nexo_el_container(
		array(
			nexo_el_heading(
				'TESTIMONIALS',
				array(
					'header_size'            => 'p',
					'align'                  => 'center',
					'title_color'            => $primary,
					'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
					'typography_font_weight' => '600',
				)
			),
			nexo_el_heading( 'What Clients Say', array( 'align' => 'center' ) ),
			nexo_el_spacer( 20 ),
			nexo_el_inner_container(
				array(
					$testimonial_card( '"Ali is an exceptional designer and developer. He delivered beyond our expectations."', 'Sarah Johnson', 'CEO, TechFlow' ),
					$testimonial_card( '"Great communication and top-quality work. Highly recommended!"', 'Michael Brown', 'Founder, StartupCo' ),
					$testimonial_card( '"Professional, creative and reliable. Will work with him again!"', 'Emily Davis', 'Marketing Director' ),
				),
				array(
					'flex_direction' => 'row',
					'flex_gap'       => array( 'unit' => 'px', 'size' => 20 ),
					'content_width'  => 'full',
				)
			),
		),
		array(
			'background_background' => 'classic',
			'background_color'      => '#F8FAFC',
		)
	);

	$price_card = function( $name, $price, $desc, $features, $popular = false ) use ( $primary ) {
		$border_w = $popular ? '2' : '1';
		$border_c = $popular ? $primary : '#E2E8F0';
		$btn      = $popular
			? nexo_el_button( 'Get Started', '#contact', array( 'align' => 'center' ) )
			: nexo_el_button(
				'Get Started',
				'#contact',
				array(
					'align'              => 'center',
					'background_color'  => 'transparent',
					'button_text_color' => $primary,
					'border_border'     => 'solid',
					'border_width'      => array(
						'unit'     => 'px',
						'top'      => '2',
						'right'    => '2',
						'bottom'   => '2',
						'left'     => '2',
						'isLinked' => true,
					),
					'border_color' => $primary,
				)
			);

		return nexo_el_inner_container(
			array(
				nexo_el_heading( $name, array( 'align' => 'center', 'header_size' => 'h3' ) ),
				nexo_el_heading( $price, array( 'align' => 'center', 'header_size' => 'h2', 'title_color' => $primary ) ),
				nexo_el_text( '<p style="text-align:center;color:#64748B;">' . $desc . '</p><p style="text-align:center;">' . $features . '</p>' ),
				$btn,
			),
			array(
				'content_width'         => 'full',
				'width'                 => array( 'unit' => '%', 'size' => 33 ),
				'background_background' => 'classic',
				'background_color'      => '#FFFFFF',
				'border_border'         => 'solid',
				'border_width'          => array(
					'unit'     => 'px',
					'top'      => $border_w,
					'right'    => $border_w,
					'bottom'   => $border_w,
					'left'     => $border_w,
					'isLinked' => true,
				),
				'border_color'          => $border_c,
				'border_radius'         => array(
					'unit'     => 'px',
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'isLinked' => true,
				),
				'padding'               => array(
					'unit'     => 'px',
					'top'      => '36',
					'right'    => '28',
					'bottom'   => '36',
					'left'     => '28',
					'isLinked' => true,
				),
			)
		);
	};

	$pricing = nexo_el_container(
		array(
			nexo_el_heading(
				'PRICING',
				array(
					'header_size'            => 'p',
					'align'                  => 'center',
					'title_color'            => $primary,
					'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
					'typography_font_weight' => '600',
				)
			),
			nexo_el_heading( 'Simple, Transparent Pricing', array( 'align' => 'center' ) ),
			nexo_el_spacer( 24 ),
			nexo_el_inner_container(
				array(
					$price_card( 'Basic', '$299', 'Perfect for small projects', '✓ Up to 5 Pages<br>✓ Responsive Design<br>✓ Basic SEO<br>✓ 1 Month Support' ),
					$price_card( 'Standard · Popular', '$599', 'Best for growing businesses', '✓ Up to 10 Pages<br>✓ Responsive Design<br>✓ SEO Optimization<br>✓ 3 Months Support', true ),
					$price_card( 'Premium', '$999', 'For large and complex projects', '✓ Unlimited Pages<br>✓ Advanced Features<br>✓ SEO Optimization<br>✓ 6 Months Support' ),
				),
				array(
					'flex_direction' => 'row',
					'flex_gap'       => array( 'unit' => 'px', 'size' => 20 ),
					'content_width'  => 'full',
				)
			),
		),
		array(
			'background_background' => 'classic',
			'background_color'      => '#FFFFFF',
		)
	);

	$faq_contact = nexo_el_container(
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
							nexo_el_text( '<p><strong>How long does a project take?</strong><br>Most projects take 2 to 6 weeks.</p><p><strong>Do you provide support after delivery?</strong><br>Yes, every package includes support.</p><p><strong>Can you work with my existing website?</strong><br>Absolutely.</p><p><strong>What do I need to get started?</strong><br>A brief description of your goals.</p>' ),
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

	return array( $hero, $about, $services, $portfolio, $testimonials, $pricing, $faq_contact );
}

function nexo_apply_default_elementor_design( $page_id ) {
	if ( ! $page_id || ! defined( 'ELEMENTOR_VERSION' ) ) {
		return false;
	}

	if ( function_exists( 'nexo_has_elementor_design' ) && nexo_has_elementor_design( $page_id ) ) {
		return false;
	}

	$data = nexo_get_default_elementor_data();
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
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}

	return true;
}
