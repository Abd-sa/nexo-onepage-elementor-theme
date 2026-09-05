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
 * Ensure pages (including front page) fully support Elementor
 */
function nexo_elementor_support() {
	add_post_type_support( 'page', 'elementor' );
}
add_action( 'init', 'nexo_elementor_support', 5 );

/**
 * Register Elementor Theme Builder locations
 */
function nexo_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'nexo_register_elementor_locations' );

/**
 * Custom Elementor widget category
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
 * Make sure Elementor treats our pages as editable
 */
function nexo_elementor_add_page_support( $post_types ) {
	$post_types['page'] = 'page';
	return $post_types;
}
add_filter( 'elementor/utils/get_public_post_types', 'nexo_elementor_add_page_support' );

/**
 * Admin: strong notice + direct "Edit with Elementor" link for Home page
 */
function nexo_admin_notice_elementor() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	// Elementor not installed
	if ( ! is_plugin_active( 'elementor/elementor.php' ) ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}
		$install_url = wp_nonce_url(
			self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ),
			'install-plugin_elementor'
		);
		?>
		<div class="notice notice-warning is-dismissible">
			<p>
				<strong>NEXO:</strong>
				<?php esc_html_e( 'برای ویرایش کامل صفحه اصلی، افزونه Elementor را نصب و فعال کنید.', 'nexo' ); ?>
				<a href="<?php echo esc_url( $install_url ); ?>" class="button button-primary" style="margin-right:8px;">
					<?php esc_html_e( 'نصب Elementor', 'nexo' ); ?>
				</a>
			</p>
		</div>
		<?php
		return;
	}

	// Elementor active → show edit link for front page
	$page_id = (int) get_option( 'page_on_front' );
	if ( ! $page_id ) {
		return;
	}

	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen ) {
		return;
	}

	$allowed_screens = array( 'dashboard', 'edit-page', 'page', 'themes', 'toplevel_page_nexo-settings' );
	if ( ! in_array( $screen->id, $allowed_screens, true ) ) {
		return;
	}

	$elementor_url = admin_url( 'post.php?post=' . $page_id . '&action=elementor' );
	?>
	<div class="notice notice-success is-dismissible">
		<p>
			<strong>NEXO:</strong>
			<?php esc_html_e( 'صفحه اصلی قابل ویرایش با Elementor است.', 'nexo' ); ?>
			<a class="button button-primary" style="margin-right:8px;" href="<?php echo esc_url( $elementor_url ); ?>">
				<?php esc_html_e( 'ویرایش صفحه اصلی با Elementor', 'nexo' ); ?>
			</a>
			<a href="<?php echo esc_url( get_edit_post_link( $page_id ) ); ?>">
				<?php esc_html_e( 'ویرایش در وردپرس', 'nexo' ); ?>
			</a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'nexo_admin_notice_elementor' );

/**
 * Add "Edit with Elementor" row action on Pages list for clarity
 */
function nexo_elementor_row_actions( $actions, $post ) {
	if ( 'page' !== $post->post_type || ! defined( 'ELEMENTOR_VERSION' ) ) {
		return $actions;
	}

	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $actions;
	}

	$actions['nexo_elementor'] = sprintf(
		'<a href="%s">%s</a>',
		esc_url( admin_url( 'post.php?post=' . $post->ID . '&action=elementor' ) ),
		esc_html__( 'Edit with Elementor', 'nexo' )
	);

	return $actions;
}
add_filter( 'page_row_actions', 'nexo_elementor_row_actions', 20, 2 );
