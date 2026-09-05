<?php
/**
 * Default Elementor document data for NEXO Home page
 *
 * Builds a complete one-page layout with Containers + widgets
 * so "Edit with Elementor" opens a designed page, not an empty canvas.
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Generate a random Elementor element ID
 */
function nexo_el_id() {
	return substr( md5( uniqid( (string) mt_rand(), true ) ), 0, 7 );
}

/**
 * Heading widget
 */
function nexo_el_heading( $title, $settings = array() ) {
	$defaults = array(
		'title'            => $title,
		'header_size'      => 'h2',
		'align'            => 'right',
		'title_color'      => '#1A1A2E',
		'typography_typography' => 'custom',
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

/**
 * Text editor widget
 */
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

/**
 * Button widget
 */
function nexo_el_button( $text, $link = '#', $settings = array() ) {
	$defaults = array(
		'text'            => $text,
		'link'            => array( 'url' => $link ),
		'align'           => 'right',
		'background_color'=> '#22C55E',
		'button_text_color' => '#FFFFFF',
		'border_radius'   => array( 'unit' => 'px', 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'isLinked' => true ),
		'typography_typography' => 'custom',
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

/**
 * Spacer
 */
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

/**
 * Icon box (services)
 */
function nexo_el_icon_box( $title, $description, $icon = 'fas fa-star' ) {
	return array(
		'id'         => nexo_el_id(),
		'elType'     => 'widget',
		'widgetType' => 'icon-box',
		'settings'   => array(
			'title_text'       => $title,
			description_text  => $description,
			'selected_icon'    => array( 'value' => $icon, 'library' => 'fa-solid' ),
			'position'         => 'top',
			'title_color'      => '#FFFFFF',
			'description_color'=> '#94A3B8',
			'primary_color'    => '#22C55E',
			'align'            => 'right',
		),
		'elements'   => array(),
	);
}

/**
 * Container helper
 */
function nexo_el_container( $elements, $settings = array() ) {
	$defaults = array(
		'content_width' => 'boxed',
		'boxed_width'   => array( 'unit' => 'px', 'size' => 1200 ),
		'flex_direction'=> 'column',
		'padding'       => array(
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

/**
 * Inner container (for columns/grid)
 */
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

/**
 * Build full homepage Elementor data
 *
 * @return array
 */
function nexo_get_default_elementor_data() {
	$primary = nexo_get_option( 'color_primary', '#22C55E' );
	$name    = nexo_get_option( 'hero_title', 'Ali Rezaei' );
	$badge   = nexo_get_option( 'hero_badge', "HELLO, I'M" );
	$sub     = nexo_get_option( 'hero_subtitle', 'I build digital products, brands and experiences.' );
	$desc    = nexo_get_option( 'hero_desc', "I'm a freelance UI/UX designer and front-end developer based in Tehran. I help businesses turn ideas into beautiful, functional and user-friendly digital experiences." );

	// ---------- HERO ----------
	$hero_left = nexo_el_inner_container(
		array(
			nexo_el_heading( $badge, array(
				'header_size' => 'p',
				'title_color' => $primary,
				'typography_font_size' => array( 'unit' => 'px', 'size' => 14 ),
				'typography_font_weight' => '600',
			) ),
			nexo_el_heading( $name, array(
				'header_size' => 'h1',
				'typography_font_size' => array( 'unit' => 'px', 'size' => 48 ),
				'typography_font_weight' => '800',
			) ),
			nexo_el_heading( $sub, array(
				'header_size' => 'h3',
				'typography_font_size' => array( 'unit' => 'px', 'size' => 22 ),
				'typography_font_weight' => '600',
			) ),
			nexo_el_text( '<p>' . esc_html( $desc ) . '</p>', array(
				'text_color' => '#64748B',
			) ),
			nexo_el_spacer( 16 ),
			nexo_el_inner_container(
				array(
					nexo_el_button( 'Download CV ↓', '#', array( 'align' => 'right' ) ),
					nexo_el_button( "Let's Talk", '#contact', array(
						'background_color' => 'transparent',
						'button_text_color' => $primary,
						'border_border' => 'solid',
						'border_width' => array( 'unit' => 'px', 'top' => '2', 'right' => '2', 'bottom' => '2', 'left' => '2', 'isLinked' => true ),
						'border_color' => $primary,
					) ),
				),
				array(
					'flex_direction' => 'row',
					'flex_gap' => array( 'unit' => 'px', 'size' => 12 ),
					'content_width' => 'full',
				)
			),
		),
		array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 55 ) )
	);

	$hero_right = nexo_el_inner_container(
		array(
			nexo_el_heading( '5+ Years', array(
				'header_size' => 'h3',
				'align' => 'center',
				'title_color' => $primary,
			) ),
			nexo_el_text( '<p style="text-align:center">Experience · 50+ Projects Completed</p>', array( 'align' => 'center' ) ),
		),
		array(
			'content_width' => 'full',
			'width' => array( 'unit' => '%', 'size' => 45 ),
			'background_background' => 'classic',
			'background_color' => '#F1F5F9',
			'border_radius' => array( 'unit' => 'px', 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'isLinked' => true ),
			'padding' => array( 'unit' => 'px', 'top' => '60', 'right' => '30', 'bottom' => '60', 'left' => '30', 'isLinked' => false ),
			'justify_content' => 'center',
		)
	);

	$hero = nexo_el_container(
		array(
			nexo_el_inner_container(
				array( $hero_left, $hero_right ),
				array(
					'flex_direction' => 'row',
					'flex_gap' => array( 'unit' => 'px', 'size' => 40 ),
					'content_width' => 'full',
					'flex_align_items' => 'center',
				)
			),
			nexo_el_spacer( 40 ),
			nexo_el_text(
				'<p style="text-align:center;letter-spacing:1px;color:#94A3B8;font-size:13px;">TRUSTED BY 100+ CLIENTS WORLDWIDE</p><p style="text-align:center;opacity:0.6;font-weight:600;">Google &nbsp;&nbsp; Microsoft &nbsp;&nbsp; Slack &nbsp;&nbsp; Airbnb &nbsp;&nbsp; Spotify &nbsp;&nbsp; Amazon</p>',
				array( 'align' => 'center' )
			),
		),
		array(
			'background_background' => 'classic',
			'background_color' => '#F8FAFC',
		)
	);

	// ---------- ABOUT ----------
	$about = nexo_el_container(
		array(
			nexo_el_inner_container(
				array(
					nexo_el_inner_container(
						array(
							nexo_el_heading( 'About Image', array( 'align' => 'center', 'header_size' => 'h4', 'title_color' => '#94A3B8' ) ),
							nexo_el_text( '<p style="text-align:center;color:#94A3B8;">تصویر خود را از این‌جا در Elementor جایگزین کنید</p>', array( 'align' => 'center' ) ),
						),
						array(
							'content_width' => 'full',
							'width' => array( 'unit' => '%', 'size' => 45 ),
							'background_background' => 'classic',
							'background_color' => '#E2E8F0',
							'border_radius' => array( 'unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true ),
							'padding' => array( 'unit' => 'px', 'top' => '80', 'right' => '20', 'bottom' => '80', 'left' => '20', 'isLinked' => false ),
							'justify_content' => 'center',
						)
					),
					nexo_el_inner_container(
						array(
							nexo_el_heading( 'ABOUT ME', array(
								'header_size' => 'p',
								'title_color' => $primary,
								'typography_font_size' => array( 'unit' => 'px', 'size' => 14 ),
								'typography_font_weight' => '600',
							) ),
							nexo_el_heading( 'Designing Solutions That Make a Difference' ),
							nexo_el_text( '<p style="color:#64748B;">I combine creativity, technology and strategy to build products that are not only beautiful but also functional and impactful.</p>' ),
							nexo_el_spacer( 12 ),
							nexo_el_text( '<p><strong>UI/UX Design</strong> — 95%</p><p><strong>Web Development</strong> — 90%</p><p><strong>Branding Design</strong> — 85%</p>' ),
						),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 55 ) )
					),
				),
				array(
					'flex_direction' => 'row',
					'flex_gap' => array( 'unit' => 'px', 'size' => 40 ),
					'content_width' => 'full',
					'flex_align_items' => 'center',
				)
			),
		),
		array( 'background_background' => 'classic', 'background_color' => '#FFFFFF' )
	);

	// ---------- SERVICES ----------
	$services_row = nexo_el_inner_container(
		array(
			nexo_el_inner_container(
				array( nexo_el_icon_box( 'UI/UX Design', 'I design intuitive and beautiful interfaces that users love.', 'fas fa-pencil-ruler' ) ),
				array(
					'content_width' => 'full',
					'width' => array( 'unit' => '%', 'size' => 25 ),
					'background_background' => 'classic',
					'background_color' => '#0F172A',
					'border_radius' => array( 'unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true ),
					'padding' => array( 'unit' => 'px', 'top' => '32', 'right' => '24', 'bottom' => '32', 'left' => '24', 'isLinked' => true ),
				)
			),
			nexo_el_inner_container(
				array( nexo_el_icon_box( 'Web Development', 'I build fast, responsive and modern websites.', 'fas fa-code' ) ),
				array(
					'content_width' => 'full',
					'width' => array( 'unit' => '%', 'size' => 25 ),
					'background_background' => 'classic',
					'background_color' => '#0F172A',
					'border_radius' => array( 'unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true ),
					'padding' => array( 'unit' => 'px', 'top' => '32', 'right' => '24', 'bottom' => '32', 'left' => '24', 'isLinked' => true ),
				)
			),
			nexo_el_inner_container(
				array( nexo_el_icon_box( 'Branding Design', 'I create unique brand identities that stand out.', 'fas fa-palette' ) ),
				array(
					'content_width' => 'full',
					'width' => array( 'unit' => '%', 'size' => 25 ),
					'background_background' => 'classic',
					'background_color' => '#0F172A',
					'border_radius' => array( 'unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true ),
					'padding' => array( 'unit' => 'px', 'top' => '32', 'right' => '24', 'bottom' => '32', 'left' => '24', 'isLinked' => true ),
				)
			),
			nexo_el_inner_container(
				array( nexo_el_icon_box( 'SEO Optimization', 'I optimize websites to rank higher and get more traffic.', 'fas fa-chart-line' ) ),
				array(
					'content_width' => 'full',
					'width' => array( 'unit' => '%', 'size' => 25 ),
					'background_background' => 'classic',
					'background_color' => '#0F172A',
					'border_radius' => array( 'unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true ),
					'padding' => array( 'unit' => 'px', 'top' => '32', 'right' => '24', 'bottom' => '32', 'left' => '24', 'isLinked' => true ),
				)
			),
		),
		array(
			'flex_direction' => 'row',
			'flex_gap' => array( 'unit' => 'px', 'size' => 20 ),
			'content_width' => 'full',
		)
	);

	$services = nexo_el_container(
		array(
			nexo_el_heading( 'SERVICES', array(
				'header_size' => 'p',
				'align' => 'center',
				'title_color' => $primary,
				'typography_font_size' => array( 'unit' => 'px', 'size' => 14 ),
				'typography_font_weight' => '600',
			) ),
			nexo_el_heading( 'What I Can Do For You', array(
				'align' => 'center',
				'title_color' => '#FFFFFF',
			) ),
			nexo_el_spacer( 24 ),
			$services_row,
		),
		array(
			'background_background' => 'classic',
			'background_color' => '#0F172A',
		)
	);

	// ---------- PORTFOLIO ----------
	$portfolio = nexo_el_container(
		array(
			nexo_el_heading( 'PORTFOLIO', array(
				'header_size' => 'p',
				'title_color' => $primary,
				'typography_font_size' => array( 'unit' => 'px', 'size' => 14 ),
				'typography_font_weight' => '600',
			) ),
			nexo_el_heading( 'Selected Works' ),
			nexo_el_text( '<p style="color:#64748B;">نمونه‌کارها را از منوی <strong>Portfolio</strong> در پیشخوان اضافه کنید. می‌توانید این بخش را در Elementor با ویجت Posts یا Gallery جایگزین کنید.</p>' ),
			nexo_el_spacer( 16 ),
			nexo_el_button( 'View All Projects →', '#', array(
				'background_color' => 'transparent',
				'button_text_color' => $primary,
				'border_border' => 'solid',
				'border_width' => array( 'unit' => 'px', 'top' => '2', 'right' => '2', 'bottom' => '2', 'left' => '2', 'isLinked' => true ),
				'border_color' => $primary,
			) ),
		),
		array( 'background_background' => 'classic', 'background_color' => '#FFFFFF' )
	);

	// ---------- TESTIMONIALS ----------
	$testimonials = nexo_el_container(
		array(
			nexo_el_heading( 'TESTIMONIALS', array(
				'header_size' => 'p',
				'align' => 'center',
				'title_color' => $primary,
				'typography_font_size' => array( 'unit' => 'px', 'size' => 14 ),
				'typography_font_weight' => '600',
			) ),
			nexo_el_heading( 'What Clients Say', array( 'align' => 'center' ) ),
			nexo_el_spacer( 20 ),
			nexo_el_inner_container(
				array(
					nexo_el_inner_container(
						array(
							nexo_el_text( '<p style="font-style:italic;">“Ali is an exceptional designer and developer. He delivered beyond our expectations.”</p><p><strong>Sarah Johnson</strong><br><span style="color:#64748B;">CEO, TechFlow</span></p>' ),
						),
						array(
							'content_width' => 'full',
							'width' => array( 'unit' => '%', 'size' => 33 ),
							'background_background' => 'classic',
							'background_color' => '#FFFFFF',
							'border_border' => 'solid',
							'border_width' => array( 'unit' => 'px', 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ),
							'border_color' => '#E2E8F0',
							'border_radius' => array( 'unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true ),
							'padding' => array( 'unit' => 'px', 'top' => '28', 'right' => '24', 'bottom' => '28', 'left' => '24', 'isLinked' => true ),
						)
					),
					nexo_el_inner_container(
						array(
							nexo_el_text( '<p style="font-style:italic;">“Great communication and top-quality work. Highly recommended!”</p><p><strong>Michael Brown</strong><br><span style="color:#64748B;">Founder, StartupCo</span></p>' ),
						),
						array(
							'content_width' => 'full',
							'width' => array( 'unit' => '%', 'size' => 33 ),
							'background_background' => 'classic',
							'background_color' => '#FFFFFF',
							'border_border' => 'solid',
							'border_width' => array( 'unit' => 'px', 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ),
							'border_color' => '#E2E8F0',
							'border_radius' => array( 'unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true ),
							'padding' => array( 'unit' => 'px', 'top' => '28', 'right' => '24', 'bottom' => '28', 'left' => '24', 'isLinked' => true ),
						)
					),
					nexo_el_inner_container(
						array(
							nexo_el_text( '<p style="font-style:italic;">“Professional, creative and reliable. Will work with him again!”</p><p><strong>Emily Davis</strong><br><span style="color:#64748B;">Marketing Director</span></p>' ),
						),
						array(
							'content_width' => 'full',
							'width' => array( 'unit' => '%', 'size' => 33 ),
							'background_background' => 'classic',
							'background_color' => '#FFFFFF',
							'border_border' => 'solid',
							'border_width' => array( 'unit' => 'px', 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ),
							'border_color' => '#E2E8F0',
							'border_radius' => array( 'unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true ),
							'padding' => array( 'unit' => 'px', 'top' => '28', 'right' => '24', 'bottom' => '28', 'left' => '24', 'isLinked' => true ),
						)
					),
				),
				array(
					'flex_direction' => 'row',
					'flex_gap' => array( 'unit' => 'px', 'size' => 20 ),
					'content_width' => 'full',
				)
			),
		),
		array( 'background_background' => 'classic', 'background_color' => '#F8FAFC' )
	);

	// ---------- PRICING ----------
	$pricing = nexo_el_container(
		array(
			nexo_el_heading( 'PRICING', array(
				'header_size' => 'p',
				'align' => 'center',
				'title_color' => $primary,
				'typography_font_size' => array( 'unit' => 'px', 'size' => 14 ),
				'typography_font_weight' => '600',
			) ),
			nexo_el_heading( 'Simple, Transparent Pricing', array( 'align' => 'center' ) ),
			nexo_el_spacer( 24 ),
			nexo_el_inner_container(
				array(
					nexo_el_inner_container(
						array(
							nexo_el_heading( 'Basic', array( 'align' => 'center', 'header_size' => 'h3' ) ),
							nexo_el_heading( '$299', array( 'align' => 'center', 'header_size' => 'h2', 'title_color' => $primary ) ),
							nexo_el_text( '<p style="text-align:center;color:#64748B;">Perfect for small projects</p><p style="text-align:center;">✓ Up to 5 Pages<br>✓ Responsive Design<br>✓ Basic SEO<br>✓ 1 Month Support</p>' ),
							nexo_el_button( 'Get Started', '#contact', array( 'align' => 'center', 'background_color' => 'transparent', 'button_text_color' => $primary, 'border_border' => 'solid', 'border_width' => array( 'unit' => 'px', 'top' => '2', 'right' => '2', 'bottom' => '2', 'left' => '2', 'isLinked' => true ), 'border_color' => $primary ) ),
						),
						array(
							'content_width' => 'full',
							'width' => array( 'unit' => '%', 'size' => 33 ),
							'background_background' => 'classic',
							'background_color' => '#FFFFFF',
							'border_border' => 'solid',
							'border_width' => array( 'unit' => 'px', 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ),
							'border_color' => '#E2E8F0',
							'border_radius' => array( 'unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true ),
							'padding' => array( 'unit' => 'px', 'top' => '36', 'right' => '28', 'bottom' => '36', 'left' => '28', 'isLinked' => true ),
						)
					),
					nexo_el_inner_container(
						array(
							nexo_el_heading( 'Standard · Popular', array( 'align' => 'center', 'header_size' => 'h3' ) ),
							nexo_el_heading( '$599', array( 'align' => 'center', 'header_size' => 'h2', 'title_color' => $primary ) ),
							nexo_el_text( '<p style="text-align:center;color:#64748B;">Best for growing businesses</p><p style="text-align:center;">✓ Up to 10 Pages<br>✓ Responsive Design<br>✓ SEO Optimization<br>✓ 3 Months Support</p>' ),
							nexo_el_button( 'Get Started', '#contact', array( 'align' => 'center' ) ),
						),
						array(
							'content_width' => 'full',
							'width' => array( 'unit' => '%', 'size' => 33 ),
							'background_background' => 'classic',
							'background_color' => '#FFFFFF',
							'border_border' => 'solid',
							'border_width' => array( 'unit' => 'px', 'top' => '2', 'right' => '2', 'bottom' => '2', 'left' => '2', 'isLinked' => true ),
							'border_color' => $primary,
							'border_radius' => array( 'unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true ),
							'padding' => array( 'unit' => 'px', 'top' => '36', 'right' => '28', 'bottom' => '36', 'left' => '28', 'isLinked' => true ),
						)
					),
					nexo_el_inner_container(
						array(
							nexo_el_heading( 'Premium', array( 'align' => 'center', 'header_size' => 'h3' ) ),
							nexo_el_heading( '$999', array( 'align' => 'center', 'header_size' => 'h2', 'title_color' => $primary ) ),
							nexo_el_text( '<p style="text-align:center;color:#64748B;">For large and complex projects</p><p style="text-align:center;">✓ Unlimited Pages<br>✓ Advanced Features<br>✓ SEO Optimization<br>✓ 6 Months Support</p>' ),
							nexo_el_button( 'Get Started', '#contact', array( 'align' => 'center', 'background_color' => 'transparent', 'button_text_color' => $primary, 'border_border' => 'solid', 'border_width' => array( 'unit' => 'px', 'top' => '2', 'right' => '2', 'bottom' => '2', 'left' => '2', 'isLinked' => true ), 'border_color' => $primary ) ),
						),
						array(
							'content_width' => 'full',
							'width' => array( 'unit' => '%', 'size' => 33 ),
							'background_background' => 'classic',
							'background_color' => '#FFFFFF',
							'border_border' => 'solid',
							'border_width' => array( 'unit' => 'px', 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ),
							'border_color' => '#E2E8F0',
							'border_radius' => array( 'unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true ),
							'padding' => array( 'unit' => 'px', 'top' => '36', 'right' => '28', 'bottom' => '36', 'left' => '28', 'isLinked' => true ),
						)
					),
				),
				array(
					'flex_direction' => 'row',
					'flex_gap' => array( 'unit' => 'px', 'size' => 20 ),
					'content_width' => 'full',
				)
			),
		),
		array( 'background_background' => 'classic', 'background_color' => '#FFFFFF' )
	);

	// ---------- FAQ + CONTACT ----------
	$faq_contact = nexo_el_container(
		array(
			nexo_el_inner_container(
				array(
					nexo_el_inner_container(
						array(
							nexo_el_heading( 'FAQ', array( 'header_size' => 'p', 'title_color' => $primary, 'typography_font_size' => array( 'unit' => 'px', 'size' => 14 ), 'typography_font_weight' => '600' ) ),
							nexo_el_heading( 'Frequently Asked Questions' ),
							nexo_el_text( '<p><strong>How long does a project take?</strong><br>Most projects take between 2 to 6 weeks depending on scope.</p><p><strong>Do you provide support after delivery?</strong><br>Yes, every package includes a support period.</p><p><strong>Can you work with my existing website?</strong><br>Absolutely. I can redesign or extend existing websites.</p><p><strong>What do I need to get started?</strong><br>A brief description of your goals and preferred timeline.</p>' ),
						),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 50 ) )
					),
					nexo_el_inner_container(
						array(
							nexo_el_heading( 'CONTACT', array( 'header_size' => 'p', 'title_color' => $primary, 'typography_font_size' => array( 'unit' => 'px', 'size' => 14 ), 'typography_font_weight' => '600' ) ),
							nexo_el_heading( "Let's Work Together" ),
							nexo_el_text( '<p style="color:#64748B;">فرم تماس را می‌توانید با ویجت Form در Elementor Pro یا افزونه Contact Form 7 جایگزین کنید.</p><p>📧 hello@example.com<br>📱 +98 912 345 6789<br>📍 Tehran, Iran<br>🕐 Mon – Fri: 9AM – 6PM</p>' ),
							nexo_el_button( 'Send Message →', '#', array() ),
						),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 50 ) )
					),
				),
				array(
					'flex_direction' => 'row',
					'flex_gap' => array( 'unit' => 'px', 'size' => 40 ),
					'content_width' => 'full',
				)
			),
		),
		array( 'background_background' => 'classic', 'background_color' => '#F8FAFC' )
	);

	return array( $hero, $about, $services, $portfolio, $testimonials, $pricing, $faq_contact );
}

/**
 * Apply default Elementor design to a page
 */
function nexo_apply_default_elementor_design( $page_id ) {
	if ( ! $page_id || ! defined( 'ELEMENTOR_VERSION' ) ) {
		return false;
	}

	// Don't overwrite if user already has a real design
	if ( nexo_has_elementor_design( $page_id ) ) {
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

	// Clear Elementor CSS cache for this post
	delete_post_meta( $page_id, '_elementor_css' );

	if ( class_exists( '\Elementor\Plugin' ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}

	return true;
}
