<?php
/**
 * Elementor compatibility
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nexo_elementor_support() {
	add_post_type_support( 'page', 'elementor' );
}
add_action( 'init', 'nexo_elementor_support', 5 );

function nexo_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'nexo_register_elementor_locations' );

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

function nexo_elementor_add_page_support( $post_types ) {
	$post_types['page'] = 'page';
	return $post_types;
}
add_filter( 'elementor/utils/get_public_post_types', 'nexo_elementor_add_page_support' );

/**
 * Admin notices — helpful, not aggressive
 */
function nexo_admin_notice_elementor() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	if ( ! function_exists( 'is_plugin_active' ) ) {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen ) {
		return;
	}

	$allowed = array( 'dashboard', 'edit-page', 'page', 'themes', 'toplevel_page_nexo-settings', 'plugins' );
	if ( ! in_array( $screen->id, $allowed, true ) ) {
		return;
	}

	// Elementor missing
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
				<?php esc_html_e( 'برای ویرایش صفحه اصلی با سکشن‌های آماده، افزونه Elementor را نصب و فعال کنید.', 'nexo' ); ?>
				<a href="<?php echo esc_url( $install_url ); ?>" class="button button-primary" style="margin-inline-start:8px;">
					<?php esc_html_e( 'نصب Elementor', 'nexo' ); ?>
				</a>
			</p>
		</div>
		<?php
		return;
	}

	$page_id = (int) get_option( 'page_on_front' );
	if ( ! $page_id ) {
		return;
	}

	$elementor_url = admin_url( 'post.php?post=' . $page_id . '&action=elementor' );
	$reimport_url  = wp_nonce_url(
		admin_url( 'admin.php?nexo_reimport_design=1&confirm=1' ),
		'nexo_reimport_design'
	);
	?>
	<div class="notice notice-info is-dismissible">
		<p>
			<strong>NEXO:</strong>
			<?php esc_html_e( 'صفحه اصلی را می‌توانید با Elementor ویرایش کنید.', 'nexo' ); ?>
			<a class="button button-primary" style="margin-inline-start:8px;" href="<?php echo esc_url( $elementor_url ); ?>">
				<?php esc_html_e( 'ویرایش با Elementor', 'nexo' ); ?>
			</a>
			<a class="button" style="margin-inline-start:4px;" href="<?php echo esc_url( $reimport_url ); ?>"
				onclick="return confirm('<?php echo esc_js( __( 'طراحی فعلی صفحه اصلی پاک و با نسخه پیش‌فرض جایگزین می‌شود. ادامه می‌دهید؟', 'nexo' ) ); ?>');">
				<?php esc_html_e( 'بازنشانی طراحی پیش‌فرض', 'nexo' ); ?>
			</a>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'nexo_admin_notice_elementor' );

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
