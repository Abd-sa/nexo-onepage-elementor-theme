<?php
/**
 * One-Click Demo Import (Phase 1)
 *
 * Imports sample Portfolio, Testimonials, primary menu with anchors,
 * Persian hero options, and seeds Elementor design if empty.
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle demo import request
 */
function nexo_handle_demo_import() {
	if ( ! isset( $_GET['nexo_import_demo'] ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	check_admin_referer( 'nexo_import_demo' );

	$result = nexo_run_demo_import();

	set_transient(
		'nexo_demo_import_notice',
		$result,
		60
	);

	wp_safe_redirect( admin_url( 'admin.php?page=nexo-settings&nexo_demo=1' ) );
	exit;
}
add_action( 'admin_init', 'nexo_handle_demo_import' );

/**
 * Show success/error after import
 */
function nexo_demo_import_admin_notice() {
	$data = get_transient( 'nexo_demo_import_notice' );
	if ( ! $data || ! is_array( $data ) ) {
		return;
	}
	delete_transient( 'nexo_demo_import_notice' );

	$class = ! empty( $data['ok'] ) ? 'notice-success' : 'notice-error';
	?>
	<div class="notice <?php echo esc_attr( $class ); ?> is-dismissible">
		<p><strong>NEXO:</strong> <?php echo esc_html( $data['message'] ); ?></p>
		<?php if ( ! empty( $data['details'] ) && is_array( $data['details'] ) ) : ?>
			<ul style="list-style:disc;margin-right:1.5em;">
				<?php foreach ( $data['details'] as $line ) : ?>
					<li><?php echo esc_html( $line ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
	<?php
}
add_action( 'admin_notices', 'nexo_demo_import_admin_notice' );

/**
 * Run full demo import
 *
 * @return array{ok:bool,message:string,details:array}
 */
function nexo_run_demo_import() {
	$details = array();

	// 1) Ensure home page exists
	if ( function_exists( 'nexo_theme_activation' ) ) {
		nexo_theme_activation();
	}
	$page_id = (int) get_option( 'page_on_front' );
	if ( $page_id ) {
		$details[] = 'صفحه خانه آماده است (ID: ' . $page_id . ')';
	} else {
		return array(
			'ok'      => false,
			'message' => 'صفحه اصلی ساخته نشد.',
			'details' => array(),
		);
	}

	// 2) Persian default options (hero etc.)
	nexo_demo_seed_options();
	$details[] = 'تنظیمات Hero و متون پیش‌فرض فارسی اعمال شد';

	// 3) Portfolio categories + items
	$p_count = nexo_demo_import_portfolio();
	$details[] = sprintf( 'نمونه کار: %d مورد', $p_count );

	// 4) Testimonials
	$t_count = nexo_demo_import_testimonials();
	$details[] = sprintf( 'نظرات مشتریان: %d مورد', $t_count );

	// 5) Primary menu with anchors
	$menu_ok = nexo_demo_import_menu();
	$details[] = $menu_ok ? 'منوی اصلی با لینک سکشن‌ها ساخته شد' : 'منوی اصلی از قبل وجود داشت یا ساخته نشد';

	// 6) Elementor design (only if empty)
	if ( defined( 'ELEMENTOR_VERSION' ) && function_exists( 'nexo_seed_elementor_design_if_empty' ) ) {
		if ( function_exists( 'nexo_has_elementor_design' ) && nexo_has_elementor_design( $page_id ) ) {
			$details[] = 'طراحی Elementor از قبل وجود داشت (بازنویسی نشد)';
		} else {
			$seeded = nexo_seed_elementor_design_if_empty( $page_id );
			$details[] = $seeded
				? 'طراحی پیش‌فرض Elementor روی صفحه خانه اعمال شد'
				: 'طراحی Elementor اعمال نشد (افزونه یا داده در دسترس نیست)';
		}
	} else {
		$details[] = 'Elementor نصب نیست — فقط محتوا و منو ایمپورت شد';
	}

	update_option( 'nexo_demo_imported_v1', 1 );

	return array(
		'ok'      => true,
		'message' => 'ایمپورت دمو با موفقیت انجام شد.',
		'details' => $details,
	);
}

/**
 * Seed Persian options without wiping user custom colors if already set
 */
function nexo_demo_seed_options() {
	$options = get_option( 'nexo_options', array() );
	if ( ! is_array( $options ) ) {
		$options = array();
	}

	$defaults = array(
		'hero_badge'          => 'سلام، من',
		'hero_title'          => 'علی رضایی',
		'hero_subtitle'       => 'محصولات دیجیتال، برند و تجربه کاربری می‌سازم.',
		'hero_desc'           => 'طراح UI/UX و توسعه‌دهنده فرانت‌اند هستم و به کسب‌وکارها کمک می‌کنم ایده‌هایشان را به تجربه‌های زیبا و کاربردی تبدیل کنند.',
		'footer_about'        => 'طراحی و توسعه وب‌سایت‌های مدرن و حرفه‌ای برای کسب‌وکارهای ایرانی.',
		'portfolio_count'     => 8,
		'testimonials_count'  => 3,
		'enable_animations'   => 1,
		'font_heading'        => 'Vazirmatn',
		'font_body'           => 'Vazirmatn',
	);

	foreach ( $defaults as $key => $value ) {
		// Always set demo text fields on import
		if ( in_array( $key, array( 'hero_badge', 'hero_title', 'hero_subtitle', 'hero_desc', 'footer_about' ), true ) ) {
			$options[ $key ] = $value;
		} elseif ( ! isset( $options[ $key ] ) || '' === $options[ $key ] ) {
			$options[ $key ] = $value;
		}
	}

	if ( empty( $options['color_primary'] ) ) {
		$options['color_primary'] = '#22c55e';
	}

	update_option( 'nexo_options', $options );
}

/**
 * Import portfolio categories + sample projects
 *
 * @return int Number of projects created this run
 */
function nexo_demo_import_portfolio() {
	$cats = array(
		'ui-ux'   => 'طراحی UI/UX',
		'web'     => 'توسعه وب',
		'branding'=> 'برندینگ',
	);

	$term_ids = array();
	foreach ( $cats as $slug => $name ) {
		$existing = term_exists( $slug, 'nexo_portfolio_cat' );
		if ( $existing ) {
			$term_ids[ $slug ] = (int) ( is_array( $existing ) ? $existing['term_id'] : $existing );
		} else {
			$created = wp_insert_term( $name, 'nexo_portfolio_cat', array( 'slug' => $slug ) );
			if ( ! is_wp_error( $created ) ) {
				$term_ids[ $slug ] = (int) $created['term_id'];
			}
		}
	}

	$projects = array(
		array(
			'title'  => 'داشبورد مدیریت فروش',
			'excerpt'=> 'طراحی رابط کاربری داشبورد تحلیلی برای فروشگاه آنلاین',
			'cat'    => 'ui-ux',
			'client' => 'فروشگاه آریا',
		),
		array(
			'title'  => 'وب‌سایت شرکتی نوین',
			'excerpt'=> 'طراحی و توسعه سایت واکنش‌گرا با تمرکز روی سرعت',
			'cat'    => 'web',
			'client' => 'گروه نوین',
		),
		array(
			'title'  => 'هویت بصری استارتاپ',
			'excerpt'=> 'لوگو، پالت رنگ و راهنمای برند',
			'cat'    => 'branding',
			'client' => 'استارتاپ پارس',
		),
		array(
			'title'  => 'اپلیکیشن رزرو آنلاین',
			'excerpt'=> 'طراحی UX جریان رزرو و پرداخت',
			'cat'    => 'ui-ux',
			'client' => 'رزروینو',
		),
		array(
			'title'  => 'لندینگ محصول SaaS',
			'excerpt'=> 'صفحه فرود با نرخ تبدیل بالا',
			'cat'    => 'web',
			'client' => 'کلودنت',
		),
		array(
			'title'  => 'ری‌برند کافه زنجیره‌ای',
			'excerpt'=> 'بازطراحی هویت بصری و بسته‌بندی',
			'cat'    => 'branding',
			'client' => 'کافه روز',
		),
	);

	$created = 0;
	foreach ( $projects as $project ) {
		$exists = get_page_by_title( $project['title'], OBJECT, 'nexo_portfolio' );
		if ( $exists ) {
			continue;
		}

		$id = wp_insert_post(
			array(
				'post_title'   => $project['title'],
				'post_excerpt' => $project['excerpt'],
				'post_content' => $project['excerpt'],
				'post_status'  => 'publish',
				'post_type'    => 'nexo_portfolio',
			)
		);

		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_nexo_client', $project['client'] );
			update_post_meta( $id, '_nexo_project_url', home_url( '/' ) );
			if ( ! empty( $term_ids[ $project['cat'] ] ) ) {
				wp_set_object_terms( $id, array( (int) $term_ids[ $project['cat'] ] ), 'nexo_portfolio_cat' );
			}
			$created++;
		}
	}

	return $created;
}

/**
 * Import sample testimonials
 *
 * @return int
 */
function nexo_demo_import_testimonials() {
	$items = array(
		array(
			'title'   => 'سارا محمدی',
			'content' => 'علی طراح و توسعه‌دهنده‌ای فوق‌العاده است. فراتر از انتظار ما تحویل داد و ارتباط عالی داشت.',
			'role'    => 'مدیرعامل، تک‌فلو',
			'rating'  => 5,
		),
		array(
			'title'   => 'محمد رضایی',
			'content' => 'کیفیت کار بالا و زمان‌بندی دقیق. حتماً دوباره همکاری می‌کنیم.',
			'role'    => 'بنیان‌گذار استارتاپ',
			'rating'  => 5,
		),
		array(
			'title'   => 'امیر حسینی',
			'content' => 'حرفه‌ای، خلاق و قابل اعتماد. نتیجه نهایی دقیقاً همان چیزی بود که می‌خواستیم.',
			'role'    => 'مدیر بازاریابی',
			'rating'  => 5,
		),
	);

	$created = 0;
	foreach ( $items as $item ) {
		$exists = get_page_by_title( $item['title'], OBJECT, 'nexo_testimonial' );
		if ( $exists ) {
			continue;
		}

		$id = wp_insert_post(
			array(
				'post_title'   => $item['title'],
				'post_content' => $item['content'],
				'post_status'  => 'publish',
				'post_type'    => 'nexo_testimonial',
			)
		);

		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_nexo_client_role', $item['role'] );
			update_post_meta( $id, '_nexo_rating', $item['rating'] );
			$created++;
		}
	}

	return $created;
}

/**
 * Create primary menu with section anchors and assign to location
 *
 * @return bool
 */
function nexo_demo_import_menu() {
	$menu_name = 'منوی اصلی NEXO';
	$menu_id   = 0;

	$menus = wp_get_nav_menus();
	foreach ( $menus as $menu ) {
		if ( $menu->name === $menu_name ) {
			$menu_id = (int) $menu->term_id;
			break;
		}
	}

	if ( ! $menu_id ) {
		$menu_id = wp_create_nav_menu( $menu_name );
		if ( is_wp_error( $menu_id ) ) {
			return false;
		}
		$menu_id = (int) $menu_id;
	}

	// Clear existing items to avoid duplicates on re-import
	$existing_items = wp_get_nav_menu_items( $menu_id );
	if ( $existing_items ) {
		foreach ( $existing_items as $item ) {
			wp_delete_post( $item->ID, true );
		}
	}

	$home = home_url( '/' );
	$links = array(
		array( 'title' => 'خانه', 'url' => $home ),
		array( 'title' => 'درباره من', 'url' => $home . '#about' ),
		array( 'title' => 'خدمات', 'url' => $home . '#services' ),
		array( 'title' => 'نمونه کارها', 'url' => $home . '#portfolio' ),
		array( 'title' => 'نظرات', 'url' => $home . '#testimonials' ),
		array( 'title' => 'تعرفه‌ها', 'url' => $home . '#pricing' ),
		array( 'title' => 'تماس', 'url' => $home . '#contact' ),
	);

	$position = 1;
	foreach ( $links as $link ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'  => $link['title'],
				'menu-item-url'    => $link['url'],
				'menu-item-status' => 'publish',
				'menu-item-type'   => 'custom',
				'menu-item-position' => $position++,
			)
		);
	}

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! is_array( $locations ) ) {
		$locations = array();
	}
	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	return true;
}
