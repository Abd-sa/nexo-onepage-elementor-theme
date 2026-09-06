<?php
/**
 * Template Name: NEXO OnePage
 * Template Post Type: page
 *
 * @package NEXO
 */

get_header();
?>

<main id="primary" class="nexo-main nexo-onepage">

	<?php
	$post_id = get_the_ID() ? get_the_ID() : get_queried_object_id();

	if ( nexo_should_show_default_sections( $post_id ) ) :
		get_template_part( 'template-parts/hero' );
		get_template_part( 'template-parts/about' );
		get_template_part( 'template-parts/services' );
		get_template_part( 'template-parts/portfolio' );
		get_template_part( 'template-parts/testimonials' );
		get_template_part( 'template-parts/pricing' );
		get_template_part( 'template-parts/faq-contact' );
	else :
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>
				<div class="nexo-elementor-content">
					<?php the_content(); ?>
				</div>
				<?php
			endwhile;
		endif;
		get_template_part( 'template-parts/contact' );
	endif;
	?>

</main>

<?php
get_footer();
