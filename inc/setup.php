<?php
/**
 * Theme setup helpers
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fallback menu when no menu is assigned
 */
function nexo_fallback_menu() {
	$items = array(
		'home'         => array( 'label' => __( 'Home', 'nexo' ),         'url' => home_url( '/' ) ),
		'about'        => array( 'label' => __( 'About', 'nexo' ),        'url' => '#about' ),
		'services'     => array( 'label' => __( 'Services', 'nexo' ),     'url' => '#services' ),
		'portfolio'    => array( 'label' => __( 'Portfolio', 'nexo' ),    'url' => '#portfolio' ),
		'testimonials' => array( 'label' => __( 'Testimonials', 'nexo' ), 'url' => '#testimonials' ),
		'pricing'      => array( 'label' => __( 'Pricing', 'nexo' ),      'url' => '#pricing' ),
		'faq'          => array( 'label' => __( 'FAQ', 'nexo' ),          'url' => '#faq' ),
		'contact'      => array( 'label' => __( 'Contact', 'nexo' ),      'url' => '#contact' ),
	);

	echo '<ul id="primary-menu">';
	foreach ( $items as $item ) {
		printf(
			'<li><a href="%s">%s</a></li>',
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}

/**
 * On theme activation: create a real "Home" page, assign NEXO OnePage template,
 * and set it as the static front page so it appears in Pages list and is editable.
 */
function nexo_theme_activation() {
	// Already done?
	if ( get_option( 'nexo_home_page_created' ) ) {
		return;
	}

	$existing = get_page_by_path( 'home' );
	if ( ! $existing ) {
		// Try Persian slug too
		$existing = get_page_by_title( 'Home' );
	}
	if ( ! $existing ) {
		$existing = get_page_by_title( 'خانه' );
	}

	if ( $existing ) {
		$page_id = $existing->ID;
	} else {
		$page_id = wp_insert_post( array(
			'post_title'   => 'Home',
			'post_name'    => 'home',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
			'post_author'  => get_current_user_id() ? get_current_user_id() : 1,
		) );
	}

	if ( $page_id && ! is_wp_error( $page_id ) ) {
		// Assign page template
		update_post_meta( $page_id, '_wp_page_template', 'page-templates/onepage.php' );

		// Set as static front page
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_id );

		update_option( 'nexo_home_page_created', 1 );
	}
}
add_action( 'after_switch_theme', 'nexo_theme_activation' );

/**
 * Admin notice: explain how to edit the homepage
 */
function nexo_admin_notice_homepage() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$page_id = (int) get_option( 'page_on_front' );
	if ( ! $page_id ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || ! in_array( $screen->id, array( 'themes', 'page', 'dashboard', 'toplevel_page_nexo-settings' ), true ) ) {
		return;
	}

	$edit_link = get_edit_post_link( $page_id );
	$elementor_link = $edit_link ? admin_url( 'post.php?post=' . $page_id . '&action=elementor' ) : '';
	?>
	<div class="notice notice-success is-dismissible">
		<p>
			<strong><?php esc_html_e( 'NEXO:', 'nexo' ); ?></strong>
			<?php esc_html_e( 'Homepage is a real page in Pages list and is fully editable.', 'nexo' ); ?>
			<?php if ( $edit_link ) : ?>
				<a href="<?php echo esc_url( $edit_link ); ?>"><?php esc_html_e( 'Edit page', 'nexo' ); ?></a>
				<?php if ( defined( 'ELEMENTOR_VERSION' ) && $elementor_link ) : ?>
					|
					<a href="<?php echo esc_url( $elementor_link ); ?>"><strong><?php esc_html_e( 'Edit with Elementor', 'nexo' ); ?></strong></a>
				<?php endif; ?>
			<?php endif; ?>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'nexo_admin_notice_homepage' );
