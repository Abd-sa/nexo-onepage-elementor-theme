<?php
/**
 * Custom Post Types: Portfolio & Testimonials (Persian labels)
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nexo_register_portfolio_cpt() {
	$labels = array(
		'name'               => 'نمونه کارها',
		'singular_name'      => 'پروژه',
		'add_new'            => 'افزودن',
		'add_new_item'       => 'افزودن پروژه جدید',
		'edit_item'          => 'ویرایش پروژه',
		'new_item'           => 'پروژه جدید',
		'view_item'          => 'مشاهده پروژه',
		'search_items'       => 'جستجوی پروژه‌ها',
		'not_found'          => 'پروژه‌ای یافت نشد',
		'not_found_in_trash' => 'پروژه‌ای در زباله‌دان نیست',
		'menu_name'          => 'نمونه کارها',
	);

	register_post_type(
		'nexo_portfolio',
		array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'portfolio' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 20,
			'menu_icon'          => 'dashicons-portfolio',
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest'       => true,
		)
	);

	register_taxonomy(
		'nexo_portfolio_cat',
		'nexo_portfolio',
		array(
			'labels' => array(
				'name'          => 'دسته‌بندی‌ها',
				'singular_name' => 'دسته',
			),
			'hierarchical' => true,
			'public'       => true,
			'show_ui'      => true,
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'portfolio-category' ),
		)
	);
}
add_action( 'init', 'nexo_register_portfolio_cpt' );

function nexo_register_testimonials_cpt() {
	$labels = array(
		'name'               => 'نظرات مشتریان',
		'singular_name'      => 'نظر',
		'add_new'            => 'افزودن',
		'add_new_item'       => 'افزودن نظر جدید',
		'edit_item'          => 'ویرایش نظر',
		'new_item'           => 'نظر جدید',
		'view_item'          => 'مشاهده',
		'search_items'       => 'جستجو',
		'not_found'          => 'موردی یافت نشد',
		'menu_name'          => 'نظرات مشتریان',
	);

	register_post_type(
		'nexo_testimonial',
		array(
			'labels'             => $labels,
			'public'             => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 21,
			'menu_icon'          => 'dashicons-format-quote',
			'supports'           => array( 'title', 'editor', 'thumbnail' ),
			'show_in_rest'       => true,
		)
	);
}
add_action( 'init', 'nexo_register_testimonials_cpt' );

function nexo_add_meta_boxes() {
	add_meta_box( 'nexo_portfolio_meta', 'جزئیات پروژه', 'nexo_portfolio_meta_callback', 'nexo_portfolio', 'normal', 'high' );
	add_meta_box( 'nexo_testimonial_meta', 'جزئیات مشتری', 'nexo_testimonial_meta_callback', 'nexo_testimonial', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'nexo_add_meta_boxes' );

function nexo_portfolio_meta_callback( $post ) {
	wp_nonce_field( 'nexo_portfolio_meta', 'nexo_portfolio_nonce' );
	$client = get_post_meta( $post->ID, '_nexo_client', true );
	$url    = get_post_meta( $post->ID, '_nexo_project_url', true );
	?>
	<p>
		<label for="nexo_client"><strong>نام مشتری</strong></label><br>
		<input type="text" id="nexo_client" name="nexo_client" value="<?php echo esc_attr( $client ); ?>" style="width:100%;">
	</p>
	<p>
		<label for="nexo_project_url"><strong>لینک پروژه</strong></label><br>
		<input type="url" id="nexo_project_url" name="nexo_project_url" value="<?php echo esc_url( $url ); ?>" style="width:100%;">
	</p>
	<?php
}

function nexo_testimonial_meta_callback( $post ) {
	wp_nonce_field( 'nexo_testimonial_meta', 'nexo_testimonial_nonce' );
	$role   = get_post_meta( $post->ID, '_nexo_client_role', true );
	$rating = get_post_meta( $post->ID, '_nexo_rating', true );
	?>
	<p>
		<label for="nexo_client_role"><strong>نقش / شرکت</strong></label><br>
		<input type="text" id="nexo_client_role" name="nexo_client_role" value="<?php echo esc_attr( $role ); ?>" style="width:100%;" placeholder="مدیرعامل، شرکت نمونه">
	</p>
	<p>
		<label for="nexo_rating"><strong>امتیاز (۱ تا ۵)</strong></label><br>
		<input type="number" id="nexo_rating" name="nexo_rating" value="<?php echo esc_attr( $rating ? $rating : 5 ); ?>" min="1" max="5" style="width:80px;">
	</p>
	<?php
}

function nexo_save_meta_boxes( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( isset( $_POST['nexo_portfolio_nonce'] ) && wp_verify_nonce( $_POST['nexo_portfolio_nonce'], 'nexo_portfolio_meta' ) ) {
		if ( isset( $_POST['nexo_client'] ) ) {
			update_post_meta( $post_id, '_nexo_client', sanitize_text_field( wp_unslash( $_POST['nexo_client'] ) ) );
		}
		if ( isset( $_POST['nexo_project_url'] ) ) {
			update_post_meta( $post_id, '_nexo_project_url', esc_url_raw( wp_unslash( $_POST['nexo_project_url'] ) ) );
		}
	}

	if ( isset( $_POST['nexo_testimonial_nonce'] ) && wp_verify_nonce( $_POST['nexo_testimonial_nonce'], 'nexo_testimonial_meta' ) ) {
		if ( isset( $_POST['nexo_client_role'] ) ) {
			update_post_meta( $post_id, '_nexo_client_role', sanitize_text_field( wp_unslash( $_POST['nexo_client_role'] ) ) );
		}
		if ( isset( $_POST['nexo_rating'] ) ) {
			update_post_meta( $post_id, '_nexo_rating', absint( $_POST['nexo_rating'] ) );
		}
	}
}
add_action( 'save_post', 'nexo_save_meta_boxes' );
