<?php
/**
 * Expandable FAQ (Elementor Accordion) + Persian FAQ/Contact section
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

function nexo_build_faq_contact_section( $primary = '#22C55E' ) {
	$faq_items = array(
		array(
			'q' => 'مدت زمان انجام پروژه چقدر است؟',
			'a' => 'بیشتر پروژه‌ها بسته به حجم و پیچیدگی کار، بین ۲ تا ۶ هفته زمان می‌برند.',
		),
		array(
			'q' => 'آیا بعد از تحویل پشتیبانی دارید؟',
			'a' => 'بله، هر پکیج شامل دوره پشتیبانی است. امکان تمدید پشتیبانی هم وجود دارد.',
		),
		array(
			'q' => 'آیا روی سایت فعلی‌ام هم کار می‌کنید؟',
			'a' => 'حتماً. امکان بازطراحی، بهبود و توسعه سایت‌های موجود وجود دارد.',
		),
		array(
			'q' => 'برای شروع چه چیزهایی لازم است؟',
			'a' => 'فقط توضیح کوتاهی از هدفتان، فایل‌های برند (در صورت وجود) و زمان‌بندی مورد نظرتان کافی است.',
		),
	);

	return nexo_el_container(
		array(
			nexo_el_inner_container(
				array(
					nexo_el_inner_container(
						array(
							nexo_el_heading(
								'سوالات متداول',
								array(
									'header_size'            => 'p',
									'title_color'            => $primary,
									'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
									'typography_font_weight' => '600',
								)
							),
							nexo_el_heading( 'پرسش‌های پرتکرار' ),
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
								'تماس',
								array(
									'header_size'            => 'p',
									'title_color'            => $primary,
									'typography_font_size'   => array( 'unit' => 'px', 'size' => 14 ),
									'typography_font_weight' => '600',
								)
							),
							nexo_el_heading( 'بیایید همکاری کنیم' ),
							nexo_el_text( '<p style="color:#64748B;">این بخش را می‌توانید با فرم Elementor یا افزونه Contact Form 7 جایگزین کنید.</p><p>hello@example.com<br>۰۹۱۲ ۳۴۵ ۶۷۸۹<br>تهران، ایران<br>شنبه تا چهارشنبه: ۹ صبح تا ۶ عصر</p>' ),
							nexo_el_button( 'ارسال پیام', '#', array() ),
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

function nexo_inject_expandable_faq( $data ) {
	if ( ! is_array( $data ) || empty( $data ) ) {
		return $data;
	}

	$primary = nexo_get_option( 'color_primary', '#22C55E' );
	array_pop( $data );
	$data[]  = nexo_build_faq_contact_section( $primary );

	return $data;
}
