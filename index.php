<?php
/**
 * Main template file
 *
 * @package NEXO
 */

get_header();
?>

<main id="primary" class="nexo-main">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
	else :
		?>
		<div class="nexo-container nexo-section">
			<p><?php esc_html_e( 'No content found.', 'nexo' ); ?></p>
		</div>
		<?php
	endif;
	?>
</main>

<?php
get_footer();
