<?php
/**
 * Theme Options Panel (Persian UI + Phase 4)
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nexo_register_options_page() {
	add_menu_page(
		'تنظیمات NEXO',
		'تنظیمات NEXO',
		'manage_options',
		'nexo-settings',
		'nexo_render_options_page',
		'dashicons-admin-customizer',
		59
	);
}
add_action( 'admin_menu', 'nexo_register_options_page' );

function nexo_register_settings() {
	register_setting( 'nexo_options_group', 'nexo_options', 'nexo_sanitize_options' );
}
add_action( 'admin_init', 'nexo_register_settings' );

function nexo_get_allowed_h1_sizes() {
	return array( '2rem', '2.25rem', '2.5rem', '2.75rem', '3rem', '3.25rem', '3.5rem', '4rem' );
}
function nexo_get_allowed_h2_sizes() {
	return array( '1.5rem', '1.75rem', '2rem', '2.25rem', '2.5rem', '2.75rem' );
}
function nexo_get_allowed_body_sizes() {
	return array( '14px', '15px', '16px', '17px', '18px', '19px', '20px' );
}
function nexo_get_allowed_container_widths() {
	return array( '960px', '1040px', '1120px', '1200px', '1280px', '1320px', '1400px' );
}

function nexo_sanitize_options( $input ) {
	$output = array();

	$color_fields = array( 'color_primary', 'color_secondary', 'color_accent', 'color_text', 'color_bg' );
	foreach ( $color_fields as $field ) {
		if ( isset( $input[ $field ] ) ) {
			$output[ $field ] = sanitize_hex_color( $input[ $field ] );
		}
	}

	$allowed_fonts = array( 'Vazirmatn', 'IRANSans', 'Shabnam', 'Samim', 'Tahoma', 'Arial' );
	$output['font_heading'] = ( isset( $input['font_heading'] ) && in_array( $input['font_heading'], $allowed_fonts, true ) ) ? $input['font_heading'] : 'Vazirmatn';
	$output['font_body']    = ( isset( $input['font_body'] ) && in_array( $input['font_body'], $allowed_fonts, true ) ) ? $input['font_body'] : 'Vazirmatn';

	$output['font_size_h1'] = ( isset( $input['font_size_h1'] ) && in_array( $input['font_size_h1'], nexo_get_allowed_h1_sizes(), true ) ) ? $input['font_size_h1'] : '3rem';
	$output['font_size_h2'] = ( isset( $input['font_size_h2'] ) && in_array( $input['font_size_h2'], nexo_get_allowed_h2_sizes(), true ) ) ? $input['font_size_h2'] : '2.25rem';
	$output['font_size_body'] = ( isset( $input['font_size_body'] ) && in_array( $input['font_size_body'], nexo_get_allowed_body_sizes(), true ) ) ? $input['font_size_body'] : '16px';
	$output['container_width'] = ( isset( $input['container_width'] ) && in_array( $input['container_width'], nexo_get_allowed_container_widths(), true ) ) ? $input['container_width'] : '1200px';

	$text_fields = array( 'hero_badge', 'hero_title', 'hero_subtitle', 'footer_about' );
	foreach ( $text_fields as $field ) {
		if ( isset( $input[ $field ] ) ) {
			$output[ $field ] = sanitize_text_field( $input[ $field ] );
		}
	}

	if ( isset( $input['hero_desc'] ) ) {
		$output['hero_desc'] = wp_kses_post( $input['hero_desc'] );
	}
	if ( isset( $input['custom_css'] ) ) {
		$output['custom_css'] = wp_strip_all_tags( $input['custom_css'] );
	}
	if ( isset( $input['custom_js'] ) ) {
		$output['custom_js'] = wp_strip_all_tags( $input['custom_js'] );
	}

	if ( isset( $input['social_links'] ) && is_array( $input['social_links'] ) ) {
		$output['social_links'] = array();
		foreach ( $input['social_links'] as $key => $url ) {
			$output['social_links'][ sanitize_key( $key ) ] = esc_url_raw( $url );
		}
	}

	$output['portfolio_count']    = isset( $input['portfolio_count'] ) ? min( 20, max( 1, absint( $input['portfolio_count'] ) ) ) : 8;
	$output['testimonials_count'] = isset( $input['testimonials_count'] ) ? min( 12, max( 1, absint( $input['testimonials_count'] ) ) ) : 3;
	$output['enable_animations']  = ! empty( $input['enable_animations'] ) ? 1 : 0;
	$output['enable_dark_mode']   = ! empty( $input['enable_dark_mode'] ) ? 1 : 0;
	$output['dark_default']       = ! empty( $input['dark_default'] ) ? 1 : 0;

	return $output;
}

function nexo_get_option( $key, $default = '' ) {
	$options = get_option( 'nexo_options', array() );
	return isset( $options[ $key ] ) ? $options[ $key ] : $default;
}

function nexo_render_select( $name, $current, $choices ) {
	echo '<select name="nexo_options[' . esc_attr( $name ) . ']">';
	foreach ( $choices as $value ) {
		printf( '<option value="%s" %s>%s</option>', esc_attr( $value ), selected( $current, $value, false ), esc_html( $value ) );
	}
	echo '</select>';
}

function nexo_render_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$options = get_option( 'nexo_options', array() );
	$socials = isset( $options['social_links'] ) ? $options['social_links'] : array();
	$fonts   = array( 'Vazirmatn', 'IRANSans', 'Shabnam', 'Samim', 'Tahoma', 'Arial' );

	$demo_url = wp_nonce_url( admin_url( 'admin.php?nexo_import_demo=1' ), 'nexo_import_demo' );
	$page_id  = (int) get_option( 'page_on_front' );
	$elementor_url = $page_id ? admin_url( 'post.php?post=' . $page_id . '&action=elementor' ) : '';
	$reimport_url  = wp_nonce_url( admin_url( 'admin.php?nexo_reimport_design=1&confirm=1' ), 'nexo_reimport_design' );
	$customizer_logo = admin_url( 'customize.php?autofocus[control]=custom_logo' );

	$preset_designer = wp_nonce_url( admin_url( 'admin.php?nexo_preset=designer' ), 'nexo_preset' );
	$preset_dev      = wp_nonce_url( admin_url( 'admin.php?nexo_preset=developer' ), 'nexo_preset' );
	$preset_photo    = wp_nonce_url( admin_url( 'admin.php?nexo_preset=photographer' ), 'nexo_preset' );
	?>
	<div class="wrap" dir="rtl" style="max-width:960px;">
		<h1>تنظیمات قالب NEXO</h1>

		<?php if ( ! empty( $_GET['preset_applied'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p>پیش‌تنظیم استایل اعمال شد. در صورت نیاز رنگ‌ها و متون را دوباره ویرایش کنید.</p></div>
		<?php endif; ?>

		<div style="background:#f0fdf4;border:1px solid #86efac;border-radius:8px;padding:16px 20px;margin:20px 0;">
			<h2 style="margin-top:0;">نصب دمو با یک کلیک</h2>
			<p>
				<a href="<?php echo esc_url( $demo_url ); ?>" class="button button-primary button-hero"
					onclick="return confirm('محتوای نمونه اضافه می‌شود. طراحی Elementor موجود بازنویسی نمی‌شود مگر خالی باشد. ادامه؟');">نصب دمو NEXO</a>
				<?php if ( $elementor_url ) : ?>
					<a href="<?php echo esc_url( $elementor_url ); ?>" class="button button-hero" style="margin-right:8px;">ویرایش با Elementor</a>
				<?php endif; ?>
				<a href="<?php echo esc_url( $reimport_url ); ?>" class="button" style="margin-right:8px;"
					onclick="return confirm('طراحی فعلی صفحه اصلی پاک می‌شود. مطمئن هستید؟');">بازنشانی طراحی Elementor</a>
			</p>
			<p class="description">لوگو: <a href="<?php echo esc_url( $customizer_logo ); ?>">سفارشی‌سازی ← هویت سایت</a></p>
		</div>

		<div style="background:#eff6ff;border:1px solid #93c5fd;border-radius:8px;padding:16px 20px;margin:20px 0;">
			<h2 style="margin-top:0;">پیش‌تنظیم استایل (شبیه چند دمو)</h2>
			<p>رنگ‌ها و متن Hero را یک‌جا عوض می‌کند — طراحی Elementor را تغییر نمی‌دهد.</p>
			<p>
				<a class="button" href="<?php echo esc_url( $preset_designer ); ?>">دمو طراح (سبز)</a>
				<a class="button" href="<?php echo esc_url( $preset_dev ); ?>">دمو برنامه‌نویس (آبی)</a>
				<a class="button" href="<?php echo esc_url( $preset_photo ); ?>">دمو عکاس (نارنجی)</a>
			</p>
		</div>

		<form method="post" action="options.php">
			<?php settings_fields( 'nexo_options_group' ); ?>

			<h2 class="title">رنگ‌ها</h2>
			<table class="form-table" role="presentation">
				<tr><th>رنگ اصلی</th><td><input type="color" name="nexo_options[color_primary]" value="<?php echo esc_attr( nexo_get_option( 'color_primary', '#22c55e' ) ); ?>"></td></tr>
				<tr><th>رنگ ثانویه</th><td><input type="color" name="nexo_options[color_secondary]" value="<?php echo esc_attr( nexo_get_option( 'color_secondary', '#16a34a' ) ); ?>"></td></tr>
				<tr><th>رنگ تأکیدی</th><td><input type="color" name="nexo_options[color_accent]" value="<?php echo esc_attr( nexo_get_option( 'color_accent', '#3b82f6' ) ); ?>"></td></tr>
				<tr><th>رنگ متن</th><td><input type="color" name="nexo_options[color_text]" value="<?php echo esc_attr( nexo_get_option( 'color_text', '#1a1a2e' ) ); ?>"></td></tr>
				<tr><th>رنگ پس‌زمینه</th><td><input type="color" name="nexo_options[color_bg]" value="<?php echo esc_attr( nexo_get_option( 'color_bg', '#ffffff' ) ); ?>"></td></tr>
			</table>

			<h2 class="title">تایپوگرافی</h2>
			<table class="form-table" role="presentation">
				<tr>
					<th>فونت تیتر</th>
					<td><select name="nexo_options[font_heading]"><?php $c = nexo_get_option( 'font_heading', 'Vazirmatn' ); foreach ( $fonts as $f ) { printf( '<option value="%s" %s>%s</option>', esc_attr( $f ), selected( $c, $f, false ), esc_html( $f ) ); } ?></select></td>
				</tr>
				<tr>
					<th>فونت متن</th>
					<td><select name="nexo_options[font_body]"><?php $c = nexo_get_option( 'font_body', 'Vazirmatn' ); foreach ( $fonts as $f ) { printf( '<option value="%s" %s>%s</option>', esc_attr( $f ), selected( $c, $f, false ), esc_html( $f ) ); } ?></select></td>
				</tr>
				<tr><th>اندازه H1</th><td><?php nexo_render_select( 'font_size_h1', nexo_get_option( 'font_size_h1', '3rem' ), nexo_get_allowed_h1_sizes() ); ?></td></tr>
				<tr><th>اندازه H2</th><td><?php nexo_render_select( 'font_size_h2', nexo_get_option( 'font_size_h2', '2.25rem' ), nexo_get_allowed_h2_sizes() ); ?></td></tr>
				<tr><th>اندازه متن</th><td><?php nexo_render_select( 'font_size_body', nexo_get_option( 'font_size_body', '16px' ), nexo_get_allowed_body_sizes() ); ?></td></tr>
			</table>

			<h2 class="title">بخش Hero</h2>
			<table class="form-table" role="presentation">
				<tr><th>متن بج</th><td><input type="text" name="nexo_options[hero_badge]" value="<?php echo esc_attr( nexo_get_option( 'hero_badge', 'سلام، من' ) ); ?>" class="regular-text"></td></tr>
				<tr><th>نام / عنوان</th><td><input type="text" name="nexo_options[hero_title]" value="<?php echo esc_attr( nexo_get_option( 'hero_title', 'علی رضایی' ) ); ?>" class="regular-text"></td></tr>
				<tr><th>زیرعنوان</th><td><input type="text" name="nexo_options[hero_subtitle]" value="<?php echo esc_attr( nexo_get_option( 'hero_subtitle', '' ) ); ?>" class="large-text"></td></tr>
				<tr><th>توضیحات</th><td><textarea name="nexo_options[hero_desc]" rows="3" class="large-text"><?php echo esc_textarea( nexo_get_option( 'hero_desc', '' ) ); ?></textarea></td></tr>
			</table>

			<h2 class="title">شبکه‌های اجتماعی</h2>
			<table class="form-table" role="presentation">
				<tr><th>لینکدین</th><td><input type="url" name="nexo_options[social_links][linkedin]" value="<?php echo esc_url( $socials['linkedin'] ?? '' ); ?>" class="regular-text"></td></tr>
				<tr><th>Behance</th><td><input type="url" name="nexo_options[social_links][behance]" value="<?php echo esc_url( $socials['behance'] ?? '' ); ?>" class="regular-text"></td></tr>
				<tr><th>Dribbble</th><td><input type="url" name="nexo_options[social_links][dribbble]" value="<?php echo esc_url( $socials['dribbble'] ?? '' ); ?>" class="regular-text"></td></tr>
				<tr><th>اینستاگرام</th><td><input type="url" name="nexo_options[social_links][instagram]" value="<?php echo esc_url( $socials['instagram'] ?? '' ); ?>" class="regular-text"></td></tr>
			</table>

			<h2 class="title">عمومی و ظاهر</h2>
			<table class="form-table" role="presentation">
				<tr><th>عرض محتوا</th><td><?php nexo_render_select( 'container_width', nexo_get_option( 'container_width', '1200px' ), nexo_get_allowed_container_widths() ); ?></td></tr>
				<tr><th>تعداد نمونه کار</th><td><input type="number" name="nexo_options[portfolio_count]" value="<?php echo esc_attr( nexo_get_option( 'portfolio_count', 8 ) ); ?>" min="1" max="20"></td></tr>
				<tr><th>تعداد نظرات</th><td><input type="number" name="nexo_options[testimonials_count]" value="<?php echo esc_attr( nexo_get_option( 'testimonials_count', 3 ) ); ?>" min="1" max="12"></td></tr>
				<tr><th>انیمیشن اسکرول</th><td><label><input type="checkbox" name="nexo_options[enable_animations]" value="1" <?php checked( nexo_get_option( 'enable_animations', 1 ), 1 ); ?>> فعال</label></td></tr>
				<tr><th>دکمه حالت تاریک</th><td><label><input type="checkbox" name="nexo_options[enable_dark_mode]" value="1" <?php checked( nexo_get_option( 'enable_dark_mode', 1 ), 1 ); ?>> نمایش در هدر</label></td></tr>
				<tr><th>شروع با حالت تاریک</th><td><label><input type="checkbox" name="nexo_options[dark_default]" value="1" <?php checked( nexo_get_option( 'dark_default', 0 ), 1 ); ?>> بله (تا وقتی کاربر تغییر ندهد)</label></td></tr>
				<tr><th>متن فوتر</th><td><textarea name="nexo_options[footer_about]" rows="2" class="large-text"><?php echo esc_textarea( nexo_get_option( 'footer_about', '' ) ); ?></textarea></td></tr>
			</table>

			<h2 class="title">کد سفارشی</h2>
			<table class="form-table" role="presentation">
				<tr><th>CSS</th><td><textarea name="nexo_options[custom_css]" rows="6" class="large-text code"><?php echo esc_textarea( nexo_get_option( 'custom_css', '' ) ); ?></textarea></td></tr>
				<tr><th>JS</th><td><textarea name="nexo_options[custom_js]" rows="4" class="large-text code"><?php echo esc_textarea( nexo_get_option( 'custom_js', '' ) ); ?></textarea></td></tr>
			</table>

			<?php submit_button( 'ذخیره تنظیمات' ); ?>
		</form>
	</div>
	<?php
}
