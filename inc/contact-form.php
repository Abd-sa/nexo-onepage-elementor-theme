<?php
/**
 * Built-in contact form (AJAX) — no third-party required
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle AJAX contact submission
 */
function nexo_handle_contact_ajax() {
	check_ajax_referer( 'nexo_nonce', 'nonce' );

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_send_json_error( array( 'message' => 'لطفاً همه فیلدها را به‌درستی پر کنید.' ) );
	}

	$to      = get_option( 'admin_email' );
	$subject = sprintf( '[NEXO] پیام جدید از %s', $name );
	body     = "نام: {$name}\nایمیل: {$email}\n\nپیام:\n{$message}\n";
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	$sent = wp_mail( $to, $subject, $body, $headers );

	if ( $sent ) {
		wp_send_json_success( array( 'message' => 'پیام شما با موفقیت ارسال شد. به‌زودی پاسخ می‌دهیم.' ) );
	}

	wp_send_json_error( array( 'message' => 'ارسال ایمیل ناموفق بود. بعداً دوباره تلاش کنید یا مستقیم ایمیل بزنید.' ) );
}
add_action( 'wp_ajax_nexo_contact', 'nexo_handle_contact_ajax' );
add_action( 'wp_ajax_nopriv_nexo_contact', 'nexo_handle_contact_ajax' );
