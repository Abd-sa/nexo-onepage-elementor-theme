<?php
/**
 * Default Elementor homepage structure (Persian / RTL ready)
 *
 * @package NEXO
 * @version 1.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Generate short unique id for Elementor elements
 */
function nexo_el_id() {
	return substr( md5( uniqid( (string) mt_rand(), true ) ), 0, 7 );
}

/**
 * Elementor Container (outer section)
 */
function nexo_el_container( $elements, $settings = array() ) {
	$defaults = array(
		'content_width'         => 'boxed',
		'boxed_width'           => array( 'unit' => 'px', 'size' => 1200 ),
		'flex_direction'        => 'column',
		'flex_align_items'      => 'center',
		'padding'               => array(
			'unit'     => 'px',
			'top'      => '80',
			'right'    => '20',
			'bottom'   => '80',
			'left'     => '20',
			'isLinked' => false,
		),
		'background_background' => 'classic',
		'background_color'      => '#FFFFFF',
	);

	return array(
		'id'       => nexo_el_id(),
		'elType'   => 'container',
		'isInner'  => false,
		'settings' => array_merge( $defaults, $settings ),
		'elements' => $elements,
	);
}

/**
 * Inner container (column-like)
 */
function nexo_el_inner_container( $elements, $settings = array() ) {
	$defaults = array(
		'content_width'    => 'full',
		'flex_direction'   => 'column',
		'flex_align_items' => 'flex-start',
	);

	return array(
		'id'       => nexo_el_id(),
		'elType'   => 'container',
		'isInner'  => true,
		'settings' => array_merge( $defaults, $settings ),
		'elements' => $elements,
	);
}

/**
 * Heading widget
 */
function nexo_el_heading( $title, $settings = array() ) {
	$defaults = array(
		'title'                  => $title,
		'header_size'            => 'h2',
		'align'                  => 'right',
		'title_color'            => '#1A1A2E',
		'typography_font_family' => 'Vazirmatn',
		'typography_font_weight' => '700',
	);

	return array(
		'id'         => nexo_el_id(),
		'elType'     => 'widget',
		'widgetType' => 'heading',
		'settings'   => array_merge( $defaults, $settings ),
		'elements'   => array(),
	);
}

/**
 * Text editor widget
 */
function nexo_el_text( $html, $settings = array() ) {
	$defaults = array(
		'editor'                 => $html,
		'align'                  => 'right',
		'text_color'             => '#64748B',
		'typography_font_family' => 'Vazirmatn',
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
function nexo_el_button( $text, $url = '#', $settings = array() ) {
	$defaults = array(
		'text'                   => $text,
		'link'                   => array( 'url' => $url, 'is_external' => '', 'nofollow' => '' ),
		'align'                  => 'right',
		'background_color'       => '#22C55E',
		'button_text_color'      => '#FFFFFF',
		'border_radius'          => array( 'unit' => 'px', 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'isLinked' => true ),
		'typography_font_family' => 'Vazirmatn',
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
 * Icon box widget
 */
function nexo_el_icon_box( $title, $description, $icon = 'fas fa-star', $settings = array() ) {
	$defaults = array(
		'selected_icon'          => array( 'value' => $icon, 'library' => 'fa-solid' ),
		'title_text'             => $title,
		'description_text'       => $description,
		'position'               => 'top',
		'title_size'             => 'h4',
		'primary_color'          => '#22C55E',
		'title_color'            => '#1A1A2E',
		'description_color'      => '#64748B',
		'title_typography_font_family' => 'Vazirmatn',
		'description_typography_font_family' => 'Vazirmatn',
	);

	return array(
		'id'         => nexo_el_id(),
		'elType'     => 'widget',
		'widgetType' => 'icon-box',
		'settings'   => array_merge( $defaults, $settings ),
		'elements'   => array(),
	);
}

/**
 * Spacer widget
 */
function nexo_el_spacer( $size = 20 ) {
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
 * Image placeholder (no external dependency)
 */
function nexo_el_image_placeholder( $settings = array() ) {
	$defaults = array(
		'image'         => array( 'url' => '', 'id' => '' ),
		'image_size'    => 'large',
		'align'         => 'center',
		'border_radius' => array( 'unit' => 'px', 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'isLinked' => true ),
	);

	return array(
		'id'         => nexo_el_id(),
		'elType'     => 'widget',
		'widgetType' => 'image',
		'settings'   => array_merge( $defaults, $settings ),
		'elements'   => array(),
	);
}

/**
 * Build full default Elementor data (Persian content)
 */
function nexo_get_default_elementor_data() {
	$primary = function_exists( 'nexo_get_option' ) ? nexo_get_option( 'color_primary', '#22C55E' ) : '#22C55E';

	$hero_badge    = function_exists( 'nexo_get_option' ) ? nexo_get_option( 'hero_badge', 'سلام، من' ) : 'سلام، من';
	$hero_title    = function_exists( 'nexo_get_option' ) ? nexo_get_option( 'hero_title', 'علی رضایی' ) : 'علی رضایی';
	$hero_subtitle = function_exists( 'nexo_get_option' ) ? nexo_get_option( 'hero_subtitle', 'محصولات دیجیتال، برند و تجربه کاربری می‌سازم.' ) : 'محصولات دیجیتال، برند و تجربه کاربری می‌سازم.';
	$hero_desc     = function_exists( 'nexo_get_option' ) ? nexo_get_option( 'hero_desc', 'طراح UI/UX و توسعه‌دهنده فرانت‌اند هستم و به کسب‌وکارها کمک می‌کنم ایده‌هایشان را به تجربه‌های زیبا و کاربردی تبدیل کنند.' ) : 'طراح UI/UX و توسعه‌دهنده فرانت‌اند هستم و به کسب‌وکارها کمک می‌کنم ایده‌هایشان را به تجربه‌های زیبا و کاربردی تبدیل کنند.';

	// ── Hero ──
	$hero = nexo_el_container(
		array(
			nexo_el_inner_container(
				array(
					nexo_el_inner_container(
						array(
							nexo_el_heading(
								$hero_badge,
								array(
									'header_size'            => 'p',
									'title_color'            => $primary,
									'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
									'typography_font_weight' => '600',
								)
							),
							nexo_el_heading(
								$hero_title,
								array(
									'header_size'            => 'h1',
									'typography_font_size'   => array( 'unit' => 'px', 'size' => 48 ),
									'typography_font_weight' => '800',
								)
							),
							nexo_el_heading(
								$hero_subtitle,
								array(
									'header_size'          => 'h3',
									'title_color'          => '#334155',
									'typography_font_size' => array( 'unit' => 'px', 'size' => 22 ),
									'typography_font_weight' => '500',
								)
							),
							nexo_el_text( '<p>' . esc_html( $hero_desc ) . '</p>' ),
							nexo_el_spacer( 16 ),
							nexo_el_inner_container(
								array(
									nexo_el_button( 'دانلود رزومه', '#', array( 'background_color' => $primary ) ),
									nexo_el_button(
										'گفتگو کنیم',
										'#contact',
										array(
											'background_color'  => '#FFFFFF',
											'button_text_color' => '#1A1A2E',
											'border_border'     => 'solid',
											'border_width'      => array( 'unit' => 'px', 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'isLinked' => true ),
											'border_color'      => '#E2E8F0',
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
					),
						nexo_el_inner_container(
						array(
							nexo_el_text(
								'<div style="background:#F1F5F9;border-radius:24px;padding:48px 24px;text-align:center;color:#64748B;">
									<p style="font-size:48px;margin:0;">👤</p>
									<p style="margin:8px 0 0;">تصویر پروفایل را از Elementor جایگزین کنید</p>
									<p style="font-size:13px;margin:4px 0 0;">۵+ سال تجربه · ۵۰+ پروژه</p>
								</div>'
							),
						),
						array(
							'content_width'    => 'full',
							'width'            => array( 'unit' => '%', 'size' => 45 ),
							'flex_align_items' => 'center',
						)
					),
				),
				array(
					'flex_direction'   => 'row',
					'flex_gap'         => array( 'unit' => 'px', 'size' => 40 ),
					'flex_align_items' => 'center',
					'content_width'    => 'full',
				)
			),
		),
		array(
			'background_color' => '#FFFFFF',
			'padding'          => array( 'unit' => 'px', 'top' => '100', 'right' => '20', 'bottom' => '80', 'left' => '20', 'isLinked' => false ),
		)
	);

	// ── Trusted by ──
	$trusted = nexo_el_container(
		array(
			nexo_el_heading(
				'مورد اعتماد بیش از ۱۰۰ مشتری در سراسر جهان',
				array(
					'header_size'            => 'p',
					'align'                  => 'center',
					'title_color'            => '#94A3B8',
					'typography_font_size'   => array( 'unit' => 'px', 'size' => 13 ),
					'typography_font_weight' => '500',
				)
			),
			nexo_el_text(
				'<p style="text-align:center;color:#CBD5E1;letter-spacing:2px;font-size:14px;">Google · Microsoft · Slack · Airbnb · Spotify · Amazon</p>',
				array( 'align' => 'center' )
			),
		),
		array(
			'background_color' => '#FFFFFF',
			'padding'          => array( 'unit' => 'px', 'top' => '24', 'right' => '20', 'bottom' => '40', 'left' => '20', 'isLinked' => false ),
		)
	);

	// ── About ──
	$about = nexo_el_container(
		array(
			nexo_el_inner_container(
				array(
					nexo_el_inner_container(
						array(
							nexo_el_text(
								'<div style="background:#E2E8F0;border-radius:16px;padding:60px 24px;text-align:center;color:#64748B;">
									<p style="font-size:40px;margin:0;">💻</p>
									<p>تصویر درباره من را جایگزین کنید</p>
									<p style="font-size:12px;">۴+ سال تجربه</p>
								</div>'
							),
						),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 40 ) )
					),
						nexo_el_inner_container(
						array(
							nexo_el_heading(
								'درباره من',
								array(
									'header_size'            => 'p',
									'title_color'            => $primary,
									'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
									'typography_font_weight' => '600',
								)
							),
							nexo_el_heading( 'طراحی راه‌حل‌هایی که تفاوت ایجاد می‌کنند' ),
							nexo_el_text( '<p>خلاقیت، تکنولوژی و استراتژی را با هم ترکیب می‌کنم تا محصولاتی بسازم که نه فقط زیبا، بلکه کاربردی و تأثیرگذار باشند.</p>' ),
							nexo_el_spacer( 12 ),
							nexo_el_text(
								'<p><strong>طراحی UI/UX</strong> — ۹۵٪</p>
								<div style="background:#E2E8F0;border-radius:8px;height:8px;margin:4px 0 12px;"><div style="background:' . esc_attr( $primary ) . ';width:95%;height:8px;border-radius:8px;"></div></div>
								<p><strong>توسعه وب</strong> — ۹۰٪</p>
								<div style="background:#E2E8F0;border-radius:8px;height:8px;margin:4px 0 12px;"><div style="background:' . esc_attr( $primary ) . ';width:90%;height:8px;border-radius:8px;"></div></div>
								<p><strong>طراحی برند</strong> — ۸۵٪</p>
								<div style="background:#E2E8F0;border-radius:8px;height:8px;margin:4px 0 12px;"><div style="background:' . esc_attr( $primary ) . ';width:85%;height:8px;border-radius:8px;"></div></div>'
							),
						),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 60 ) )
					),
				),
				array(
					'flex_direction'   => 'row',
					'flex_gap'         => array( 'unit' => 'px', 'size' => 40 ),
					'flex_align_items' => 'center',
					'content_width'    => 'full',
				)
			),
		),
		array( 'background_color' => '#FFFFFF' )
	);

	// ── Services ──
	$services = nexo_el_container(
		array(
			nexo_el_heading(
				'خدمات',
				array(
					'header_size'            => 'p',
					'align'                  => 'center',
					'title_color'            => $primary,
					'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
					'typography_font_weight' => '600',
				)
			),
			nexo_el_heading(
				'چه کارهایی برای شما انجام می‌دهم',
				array( 'align' => 'center', 'title_color' => '#FFFFFF' )
			),
			nexo_el_spacer( 24 ),
			nexo_el_inner_container(
				array(
					nexo_el_inner_container(
						array( nexo_el_icon_box( 'طراحی UI/UX', 'رابط‌های کاربری زیبا و کاربردی طراحی می‌کنم که کاربران عاشقشان می‌شوند.', 'fas fa-pencil-ruler' ) ),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 25 ), 'background_background' => 'classic', 'background_color' => '#1E293B', 'padding' => array( 'unit' => 'px', 'top' => '24', 'right' => '20', 'bottom' => '24', 'left' => '20', 'isLinked' => true ), 'border_radius' => array( 'unit' => 'px', 'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12', 'isLinked' => true ) )
					),
					nexo_el_inner_container(
						array( nexo_el_icon_box( 'توسعه وب', 'وب‌سایت‌های سریع، واکنش‌گرا و مدرن می‌سازم.', 'fas fa-code' ) ),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 25 ), 'background_background' => 'classic', 'background_color' => '#1E293B', 'padding' => array( 'unit' => 'px', 'top' => '24', 'right' => '20', 'bottom' => '24', 'left' => '20', 'isLinked' => true ), 'border_radius' => array( 'unit' => 'px', 'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12', 'isLinked' => true ) )
					),
					nexo_el_inner_container(
						array( nexo_el_icon_box( 'طراحی برند', 'هویت بصری منحصربه‌فرد و ماندگار برای برند شما خلق می‌کنم.', 'fas fa-palette' ) ),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 25 ), 'background_background' => 'classic', 'background_color' => '#1E293B', 'padding' => array( 'unit' => 'px', 'top' => '24', 'right' => '20', 'bottom' => '24', 'left' => '20', 'isLinked' => true ), 'border_radius' => array( 'unit' => 'px', 'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12', 'isLinked' => true ) )
					),
					nexo_el_inner_container(
						array( nexo_el_icon_box( 'بهینه‌سازی سئو', 'وب‌سایت‌ها را برای رتبه بالاتر و ترافیک بیشتر بهینه می‌کنم.', 'fas fa-chart-line' ) ),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 25 ), 'background_background' => 'classic', 'background_color' => '#1E293B', 'padding' => array( 'unit' => 'px', 'top' => '24', 'right' => '20', 'bottom' => '24', 'left' => '20', 'isLinked' => true ), 'border_radius' => array( 'unit' => 'px', 'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12', 'isLinked' => true ) )
					),
				),
				array(
					'flex_direction' => 'row',
					'flex_gap'       => array( 'unit' => 'px', 'size' => 16 ),
					'content_width'  => 'full',
				)
			),
		),
		array(
			'background_color' => '#0F172A',
			'padding'          => array( 'unit' => 'px', 'top' => '80', 'right' => '20', 'bottom' => '80', 'left' => '20', 'isLinked' => false ),
		)
	);

	// ── Portfolio ──
	$portfolio = nexo_el_container(
		array(
			nexo_el_heading(
				'نمونه کارها',
				array(
					'header_size'            => 'p',
					'title_color'            => $primary,
					'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
					'typography_font_weight' => '600',
				)
			),
			nexo_el_heading( 'آثار منتخب' ),
			nexo_el_text( '<p style="color:#64748B;">نمونه کارها را از منوی «نمونه کارها» در پیشخوان اضافه کنید. این بخش به‌صورت داینامیک به‌روز می‌شود. فعلاً می‌توانید کارت‌های نمونه را در Elementor ویرایش کنید.</p>' ),
			nexo_el_spacer( 16 ),
			nexo_el_inner_container(
				array(
					nexo_el_inner_container(
						array(
							nexo_el_text( '<div style="background:#F1F5F9;border-radius:12px;padding:40px 16px;text-align:center;"><p style="font-size:32px;margin:0;">📱</p><p><strong>اپ فین‌تک</strong></p><p style="font-size:13px;color:#94A3B8;">طراحی UI/UX</p></div>' ),
						),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 25 ) )
					),
					nexo_el_inner_container(
						array(
							nexo_el_text( '<div style="background:#F1F5F9;border-radius:12px;padding:40px 16px;text-align:center;"><p style="font-size:32px;margin:0;">🌐</p><p><strong>وب‌سایت استارتاپ</strong></p><p style="font-size:13px;color:#94A3B8;">توسعه وب</p></div>' ),
						),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 25 ) )
					),
					nexo_el_inner_container(
						array(
							nexo_el_text( '<div style="background:#F1F5F9;border-radius:12px;padding:40px 16px;text-align:center;"><p style="font-size:32px;margin:0;">🎨</p><p><strong>هویت برند</strong></p><p style="font-size:13px;color:#94A3B8;">طراحی برند</p></div>' ),
						),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 25 ) )
					),
					nexo_el_inner_container(
						array(
							nexo_el_text( '<div style="background:#F1F5F9;border-radius:12px;padding:40px 16px;text-align:center;"><p style="font-size:32px;margin:0;">🛒</p><p><strong>فروشگاه آنلاین</strong></p><p style="font-size:13px;color:#94A3B8;">توسعه وب</p></div>' ),
						),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 25 ) )
					),
				),
				array(
					'flex_direction' => 'row',
					'flex_gap'       => array( 'unit' => 'px', 'size' => 16 ),
					'content_width'  => 'full',
				)
			),
		),
		array( 'background_color' => '#FFFFFF' )
	);

	// ── Testimonials ──
	$testimonials = nexo_el_container(
		array(
			nexo_el_heading(
				'نظرات مشتریان',
				array(
					'header_size'            => 'p',
					'title_color'            => $primary,
					'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
					'typography_font_weight' => '600',
				)
			),
			nexo_el_heading( 'مشتریان چه می‌گویند' ),
			nexo_el_spacer( 16 ),
			nexo_el_inner_container(
				array(
					nexo_el_inner_container(
						array(
							nexo_el_text( '<div style="background:#FFFFFF;border:1px solid #E2E8F0;border-radius:12px;padding:24px;"><p style="color:#64748B;font-style:italic;">«علی یک طراح و توسعه‌دهنده استثنایی است. فراتر از انتظارات ما عمل کرد.»</p><p style="margin-top:16px;"><strong>سارا احمدی</strong><br><span style="font-size:13px;color:#94A3B8;">مدیرعامل، تک‌فلو</span></p></div>' ),
						),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 33 ) )
					),
					nexo_el_inner_container(
						array(
							nexo_el_text( '<div style="background:#FFFFFF;border:1px solid #E2E8F0;border-radius:12px;padding:24px;"><p style="color:#64748B;font-style:italic;">«ارتباط عالی و کیفیت کار فوق‌العاده. اکیداً توصیه می‌کنم.»</p><p style="margin-top:16px;"><strong>محمد رضایی</strong><br><span style="font-size:13px;color:#94A3B8;">بنیان‌گذار، استارتاپ‌کو</span></p></div>' ),
						),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 33 ) )
					),
					nexo_el_inner_container(
						array(
							nexo_el_text( '<div style="background:#FFFFFF;border:1px solid #E2E8F0;border-radius:12px;padding:24px;"><p style="color:#64748B;font-style:italic;">«حرفه‌ای، خلاق و قابل اعتماد. دوباره با او کار خواهم کرد.»</p><p style="margin-top:16px;"><strong>مریم کریمی</strong><br><span style="font-size:13px;color:#94A3B8;">مدیر بازاریابی</span></p></div>' ),
						),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 33 ) )
					),
				),
				array(
					'flex_direction' => 'row',
					'flex_gap'       => array( 'unit' => 'px', 'size' => 20 ),
					'content_width'  => 'full',
				)
			),
		),
		array( 'background_color' => '#F8FAFC' )
	);

	// ── Pricing ──
	$pricing = nexo_el_container(
		array(
			nexo_el_heading(
				'تعرفه‌ها',
				array(
					'header_size'            => 'p',
					'align'                  => 'center',
					'title_color'            => $primary,
					'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
					'typography_font_weight' => '600',
				)
			),
			nexo_el_heading(
				'قیمت‌گذاری ساده و شفاف',
				array( 'align' => 'center' )
			),
			nexo_el_spacer( 24 ),
			nexo_el_inner_container(
				array(
					nexo_el_inner_container(
						array(
							nexo_el_text(
								'<div style="border:1px solid #E2E8F0;border-radius:16px;padding:32px 24px;text-align:center;">
									<p style="font-weight:600;margin:0;">پایه</p>
									<p style="font-size:36px;font-weight:800;margin:12px 0;">۹٫۹ میلیون</p>
									<p style="color:#94A3B8;font-size:13px;">مناسب پروژه‌های کوچک</p>
									<ul style="text-align:right;list-style:none;padding:0;margin:20px 0;color:#64748B;font-size:14px;">
										<li>✓ تا ۵ صفحه</li>
										<li>✓ طراحی واکنش‌گرا</li>
										<li>✓ سئو پایه</li>
										<li>✓ ۱ ماه پشتیبانی</li>
									</ul>
								</div>'
							),
							nexo_el_button( 'شروع کنید', '#contact', array( 'align' => 'center', 'background_color' => '#F1F5F9', 'button_text_color' => '#1A1A2E' ) ),
						),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 33 ) )
					),
					nexo_el_inner_container(
						array(
							nexo_el_text(
								'<div style="border:2px solid ' . esc_attr( $primary ) . ';border-radius:16px;padding:32px 24px;text-align:center;position:relative;">
									<span style="position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:' . esc_attr( $primary ) . ';color:#fff;font-size:12px;padding:4px 12px;border-radius:20px;">محبوب</span>
									<p style="font-weight:600;margin:0;">استاندارد</p>
									<p style="font-size:36px;font-weight:800;margin:12px 0;color:' . esc_attr( $primary ) . ';">۱۹٫۹ میلیون</p>
									<p style="color:#94A3B8;font-size:13px;">بهترین برای کسب‌وکارهای در حال رشد</p>
									<ul style="text-align:right;list-style:none;padding:0;margin:20px 0;color:#64748B;font-size:14px;">
										<li>✓ تا ۱۰ صفحه</li>
										<li>✓ امکانات پیشرفته</li>
										<li>✓ بهینه‌سازی سئو</li>
										<li>✓ ۳ ماه پشتیبانی</li>
									</ul>
								</div>'
							),
							nexo_el_button( 'شروع کنید', '#contact', array( 'align' => 'center', 'background_color' => $primary ) ),
						),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 33 ) )
					),
					nexo_el_inner_container(
						array(
							nexo_el_text(
								'<div style="border:1px solid #E2E8F0;border-radius:16px;padding:32px 24px;text-align:center;">
									<p style="font-weight:600;margin:0;">پیشرفته</p>
									<p style="font-size:36px;font-weight:800;margin:12px 0;">۳۴٫۹ میلیون</p>
									<p style="color:#94A3B8;font-size:13px;">برای پروژه‌های بزرگ و پیچیده</p>
									<ul style="text-align:right;list-style:none;padding:0;margin:20px 0;color:#64748B;font-size:14px;">
										<li>✓ صفحات نامحدود</li>
										<li>✓ امکانات کامل</li>
										<li>✓ سئو پیشرفته</li>
										<li>✓ ۶ ماه پشتیبانی</li>
									</ul>
								</div>'
							),
							nexo_el_button( 'شروع کنید', '#contact', array( 'align' => 'center', 'background_color' => '#F1F5F9', 'button_text_color' => '#1A1A2E' ) ),
						),
						array( 'content_width' => 'full', 'width' => array( 'unit' => '%', 'size' => 33 ) )
					),
				),
				array(
					'flex_direction' => 'row',
					'flex_gap'       => array( 'unit' => 'px', 'size' => 20 ),
					'content_width'  => 'full',
				)
			),
		),
		array( 'background_color' => '#FFFFFF' )
	);

	// FAQ/Contact is injected by nexo_inject_expandable_faq() from accordion-patch
	// Placeholder last section so inject can replace/append
	$faq_placeholder = nexo_el_container(
		array(
			nexo_el_heading( 'سوالات متداول و تماس' ),
		),
		array( 'background_color' => '#F8FAFC' )
	);

	return array( $hero, $trusted, $about, $services, $portfolio, $testimonials, $pricing, $faq_placeholder );
}
