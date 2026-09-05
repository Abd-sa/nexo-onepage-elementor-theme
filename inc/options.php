<?php
/**
 * Theme Options Panel
 *
 * Uses WordPress Settings API for a clean, dependency-free options page.
 * Font sizes and container width use safe dropdowns (no free-text units).
 *
 * Menu: NEXO Settings (top-level)
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register options page
 */
function nexo_register_options_page() {
	add_menu_page(
		__( 'NEXO Settings', 'nexo' ),
		__( 'NEXO Settings', 'nexo' ),
		'manage_options',
		'nexo-settings',
		'nexo_render_options_page',
		'dashicons-admin-customizer',
		59
	);
}
add_action( 'admin_menu', 'nexo_register_options_page' );

/**
 * Register settings
 */
function nexo_register_settings() {
	register_setting( 'nexo_options_group', 'nexo_options', 'nexo_sanitize_options' );
}
add_action( 'admin_init', 'nexo_register_settings' );

/**
 * Allowed values for size dropdowns (prevents invalid user input)
 */
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

/**
 * Sanitize options
 */
function nexo_sanitize_options( $input ) {
	$output = array();

	$color_fields = array( 'color_primary', 'color_secondary', 'color_accent', 'color_text', 'color_bg' );
	foreach ( $color_fields as $field ) {
		if ( isset( $input[ $field ] ) ) {
			$output[ $field ] = sanitize_hex_color( $input[ $field ] );
		}
	}

	// Fonts (whitelist)
	$allowed_fonts = array( 'Vazirmatn', 'IRANSans', 'Shabnam', 'Samim', 'Tahoma', 'Arial' );
	$output['font_heading'] = ( isset( $input['font_heading'] ) && in_array( $input['font_heading'], $allowed_fonts, true ) )
		? $input['font_heading'] : 'Vazirmatn';
	$output['font_body'] = ( isset( $input['font_body'] ) && in_array( $input['font_body'], $allowed_fonts, true ) )
		? $input['font_body'] : 'Vazirmatn';

	// Sizes — only allow predefined values
	$output['font_size_h1'] = ( isset( $input['font_size_h1'] ) && in_array( $input['font_size_h1'], nexo_get_allowed_h1_sizes(), true ) )
		? $input['font_size_h1'] : '3rem';
	$output['font_size_h2'] = ( isset( $input['font_size_h2'] ) && in_array( $input['font_size_h2'], nexo_get_allowed_h2_sizes(), true ) )
		? $input['font_size_h2'] : '2.25rem';
	$output['font_size_body'] = ( isset( $input['font_size_body'] ) && in_array( $input['font_size_body'], nexo_get_allowed_body_sizes(), true ) )
		? $input['font_size_body'] : '16px';
	$output['container_width'] = ( isset( $input['container_width'] ) && in_array( $input['container_width'], nexo_get_allowed_container_widths(), true ) )
		? $input['container_width'] : '1200px';

	// Text fields
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

	// Social links
	if ( isset( $input['social_links'] ) && is_array( $input['social_links'] ) ) {
		$output['social_links'] = array();
		foreach ( $input['social_links'] as $key => $url ) {
			$output['social_links'][ sanitize_key( $key ) ] = esc_url_raw( $url );
		}
	}

	$output['portfolio_count']    = isset( $input['portfolio_count'] ) ? min( 20, max( 1, absint( $input['portfolio_count'] ) ) ) : 8;
	$output['testimonials_count'] = isset( $input['testimonials_count'] ) ? min( 12, max( 1, absint( $input['testimonials_count'] ) ) ) : 3;
	$output['enable_animations']  = ! empty( $input['enable_animations'] ) ? 1 : 0;

	return $output;
}

/**
 * Get option helper
 */
function nexo_get_option( $key, $default = '' ) {
	$options = get_option( 'nexo_options', array() );
	return isset( $options[ $key ] ) ? $options[ $key ] : $default;
}

/**
 * Helper: render a select from allowed values
 */
function nexo_render_select( $name, $current, $choices ) {
	echo '<select name="nexo_options[' . esc_attr( $name ) . ']">';
	foreach ( $choices as $value ) {
		printf(
			'<option value="%s" %s>%s</option>',
			esc_attr( $value ),
			selected( $current, $value, false ),
			esc_html( $value )
		);
	}
	echo '</select>';
}

/**
 * Render options page
 */
function nexo_render_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$options = get_option( 'nexo_options', array() );
	$socials = isset( $options['social_links'] ) ? $options['social_links'] : array();
	$fonts   = array( 'Vazirmatn', 'IRANSans', 'Shabnam', 'Samim', 'Tahoma', 'Arial' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<p><?php esc_html_e( 'Configure colors, fonts, content and general settings for NEXO theme. Size values are limited to safe presets so the design cannot break.', 'nexo' ); ?></p>

		<form method="post" action="options.php">
			<?php settings_fields( 'nexo_options_group' ); ?>

			<h2 class="title"><?php esc_html_e( 'Colors', 'nexo' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Primary Color', 'nexo' ); ?></th>
					<td><input type="color" name="nexo_options[color_primary]" value="<?php echo esc_attr( nexo_get_option( 'color_primary', '#22c55e' ) ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Secondary Color', 'nexo' ); ?></th>
					<td><input type="color" name="nexo_options[color_secondary]" value="<?php echo esc_attr( nexo_get_option( 'color_secondary', '#16a34a' ) ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Accent Color', 'nexo' ); ?></th>
					<td><input type="color" name="nexo_options[color_accent]" value="<?php echo esc_attr( nexo_get_option( 'color_accent', '#3b82f6' ) ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Text Color', 'nexo' ); ?></th>
					<td><input type="color" name="nexo_options[color_text]" value="<?php echo esc_attr( nexo_get_option( 'color_text', '#1a1a2e' ) ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Background Color', 'nexo' ); ?></th>
					<td><input type="color" name="nexo_options[color_bg]" value="<?php echo esc_attr( nexo_get_option( 'color_bg', '#ffffff' ) ); ?>"></td>
				</tr>
			</table>

			<h2 class="title"><?php esc_html_e( 'Typography', 'nexo' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Heading Font', 'nexo' ); ?></th>
					<td>
						<select name="nexo_options[font_heading]">
							<?php
							$current = nexo_get_option( 'font_heading', 'Vazirmatn' );
							foreach ( $fonts as $font ) {
								printf( '<option value="%s" %s>%s</option>', esc_attr( $font ), selected( $current, $font, false ), esc_html( $font ) );
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Body Font', 'nexo' ); ?></th>
					<td>
						<select name="nexo_options[font_body]">
							<?php
							$current = nexo_get_option( 'font_body', 'Vazirmatn' );
							foreach ( $fonts as $font ) {
								printf( '<option value="%s" %s>%s</option>', esc_attr( $font ), selected( $current, $font, false ), esc_html( $font ) );
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'H1 Size', 'nexo' ); ?></th>
					<td><?php nexo_render_select( 'font_size_h1', nexo_get_option( 'font_size_h1', '3rem' ), nexo_get_allowed_h1_sizes() ); ?></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'H2 Size', 'nexo' ); ?></th>
					<td><?php nexo_render_select( 'font_size_h2', nexo_get_option( 'font_size_h2', '2.25rem' ), nexo_get_allowed_h2_sizes() ); ?></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Body Size', 'nexo' ); ?></th>
					<td><?php nexo_render_select( 'font_size_body', nexo_get_option( 'font_size_body', '16px' ), nexo_get_allowed_body_sizes() ); ?></td>
				</tr>
			</table>

			<h2 class="title"><?php esc_html_e( 'Hero Section', 'nexo' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Badge Text', 'nexo' ); ?></th>
					<td><input type="text" name="nexo_options[hero_badge]" value="<?php echo esc_attr( nexo_get_option( 'hero_badge', "HELLO, I'M" ) ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Name / Title', 'nexo' ); ?></th>
					<td><input type="text" name="nexo_options[hero_title]" value="<?php echo esc_attr( nexo_get_option( 'hero_title', 'Ali Rezaei' ) ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Subtitle', 'nexo' ); ?></th>
					<td><input type="text" name="nexo_options[hero_subtitle]" value="<?php echo esc_attr( nexo_get_option( 'hero_subtitle', 'I build digital products, brands and experiences.' ) ); ?>" class="large-text"></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Description', 'nexo' ); ?></th>
					<td><textarea name="nexo_options[hero_desc]" rows="3" class="large-text"><?php echo esc_textarea( nexo_get_option( 'hero_desc', "I'm a freelance UI/UX designer and front-end developer based in Tehran." ) ); ?></textarea></td>
				</tr>
			</table>

			<h2 class="title"><?php esc_html_e( 'Social Links', 'nexo' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">LinkedIn</th>
					<td><input type="url" name="nexo_options[social_links][linkedin]" value="<?php echo esc_url( isset( $socials['linkedin'] ) ? $socials['linkedin'] : '' ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row">Behance</th>
					<td><input type="url" name="nexo_options[social_links][behance]" value="<?php echo esc_url( isset( $socials['behance'] ) ? $socials['behance'] : '' ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row">Dribbble</th>
					<td><input type="url" name="nexo_options[social_links][dribbble]" value="<?php echo esc_url( isset( $socials['dribbble'] ) ? $socials['dribbble'] : '' ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row">Instagram</th>
					<td><input type="url" name="nexo_options[social_links][instagram]" value="<?php echo esc_url( isset( $socials['instagram'] ) ? $socials['instagram'] : '' ); ?>" class="regular-text"></td>
				</tr>
			</table>

			<h2 class="title"><?php esc_html_e( 'General', 'nexo' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Container Width', 'nexo' ); ?></th>
					<td><?php nexo_render_select( 'container_width', nexo_get_option( 'container_width', '1200px' ), nexo_get_allowed_container_widths() ); ?></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Portfolio Items to Show', 'nexo' ); ?></th>
					<td><input type="number" name="nexo_options[portfolio_count]" value="<?php echo esc_attr( nexo_get_option( 'portfolio_count', 8 ) ); ?>" min="1" max="20"></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Testimonials to Show', 'nexo' ); ?></th>
					<td><input type="number" name="nexo_options[testimonials_count]" value="<?php echo esc_attr( nexo_get_option( 'testimonials_count', 3 ) ); ?>" min="1" max="12"></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Enable Animations', 'nexo' ); ?></th>
					<td><label><input type="checkbox" name="nexo_options[enable_animations]" value="1" <?php checked( nexo_get_option( 'enable_animations', 1 ), 1 ); ?>> <?php esc_html_e( 'Yes', 'nexo' ); ?></label></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Footer About Text', 'nexo' ); ?></th>
					<td><textarea name="nexo_options[footer_about]" rows="2" class="large-text"><?php echo esc_textarea( nexo_get_option( 'footer_about', '' ) ); ?></textarea></td>
				</tr>
			</table>

			<h2 class="title"><?php esc_html_e( 'Custom Code', 'nexo' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Custom CSS', 'nexo' ); ?></th>
					<td><textarea name="nexo_options[custom_css]" rows="6" class="large-text code"><?php echo esc_textarea( nexo_get_option( 'custom_css', '' ) ); ?></textarea></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Custom JS', 'nexo' ); ?></th>
					<td><textarea name="nexo_options[custom_js]" rows="4" class="large-text code"><?php echo esc_textarea( nexo_get_option( 'custom_js', '' ) ); ?></textarea></td>
				</tr>
			</table>

			<?php submit_button( __( 'Save Settings', 'nexo' ) ); ?>
		</form>
	</div>
	<?php
}
