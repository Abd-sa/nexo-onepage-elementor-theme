<?php
/**
 * 404 template
 *
 * @package NEXO
 */

get_header();
?>

<main id="primary" class="nexo-main">
	<div class="nexo-container nexo-section" style="text-align:center;padding:120px 20px;">
		<h1 style="font-size:6rem;margin:0;color:var(--nexo-color-primary);">404</h1>
		<h2><?php esc_html_e( 'Page Not Found', 'nexo' ); ?></h2>
		<p><?php esc_html_e( 'The page you are looking for does not exist or has been moved.', 'nexo' ); ?></p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nexo-btn nexo-btn-primary" style="margin-top:24px;">
			<?php esc_html_e( 'Back to Home', 'nexo' ); ?>
		</a>
	</div>
</main>

<?php
get_footer();
