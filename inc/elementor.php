<?php
/**
 * Elementor compatibility & theme locations
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Elementor locations (Theme Builder)
 */
function nexo_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'nexo_register_elementor_locations' );

/**
 * Disable default Elementor colors/fonts if theme options are used
 */
function nexo_elementor_disable_defaults() {
	update_option( 'elementor_disable_color_schemes', 'yes' );
	update_option( 'elementor_disable_typography_schemes', 'yes' );
}
// Uncomment if you want to force theme control over Elementor defaults:
// add_action( 'after_switch_theme', 'nexo_elementor_disable_defaults' );

/**
 * Add custom Elementor category for future widgets
 */
function nexo_elementor_widget_categories( $elements_manager ) {
	$elements_manager->add_category(
		'nexo',
		array(
			'title' => __( 'NEXO Widgets', 'nexo' ),
			'icon'  => 'fa fa-plug',
		)
	);
}
add_action( 'elementor/elements/categories_registered', 'nexo_elementor_widget_categories' );

/**
 * Recommended plugins notice (Elementor)
 */
function nexo_admin_notice_elementor() {
	if ( ! is_plugin_active( 'elementor/elementor.php' ) && current_user_can( 'install_plugins' ) ) {
		$install_url = wp_nonce_url(
			self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ),
			'install-plugin_elementor'
		);
		?>
		<div class="notice notice-info is-dismissible">
			<p>
				<strong>NEXO Theme:</strong>
				<?php esc_html_e( 'For the best experience, please install and activate Elementor.', 'nexo' ); ?>
				<a href="<?php echo esc_url( $install_url ); ?>" class="button button-primary" style="margin-left:10px;">
					<?php esc_html_e( 'Install Elementor', 'nexo' ); ?>
				</a>
			</p>
		</div>
		<?php
	}
}
add_action( 'admin_notices', 'nexo_admin_notice_elementor' );
