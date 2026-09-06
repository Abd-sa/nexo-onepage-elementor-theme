<?php
/**
 * Theme AJAX handlers.
 *
 * @package NEXO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nexo_handle_contact_ajax() {
	check_ajax_referer( 'nexo_nonce', 'nonce' );

	$name = '';
	if ( isset( $_POST['name'] ) ) {
		$name = sanitize_text_field( wp_unslash( $_POST['name'] ) );
	}

	$email = '';
	if ( isset( $_POST['email'] ) ) {
		$email = sanitize_email( wp_unslash( $_POST['email'] ) );
	}

	$message = '';
	if ( isset( $_POST['message'] ) ) {
		$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ) );
	}

	if ( empty( $name ) || empty( $email ) || ! is_email( $email ) || empty( $message ) ) {
		$err = array();
		$err['message'] = 'Please fill all fields correctly.';
		wp_send_json_error( $err );
	}

	$to = get_option( 'admin_email' );
	$subject = sprintf( '[NEXO] New message from %s', $name );
	$nl = chr( 10 );
	body = 'Name: ' . $name . $nl . 'Email: ' . $email . $nl . $nl . 'Message:' . $nl . $message . $nl;

	$headers = array();
	$headers[] = 'Content-Type: text/plain; charset=UTF-8';
	$headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';

	$sent = wp_mail( $to, $subject, $body, $headers );

	if ( $sent ) {
		$ok = array();
		$ok['message'] = 'Your message was sent successfully.';
		wp_send_json_success( $ok );
	}

	$fail = array();
	$fail['message'] = 'Could not send email. Please try again later.';
	wp_send_json_error( $fail );
}

add_action( 'wp_ajax_nexo_contact', 'nexo_handle_contact_ajax' );
add_action( 'wp_ajax_nopriv_nexo_contact', 'nexo_handle_contact_ajax' );
