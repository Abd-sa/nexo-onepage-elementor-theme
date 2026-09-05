<?php
/**
 * Template Name: NEXO OnePage
 * Template Post Type: page
 *
 * Assign this template to any page. Fully compatible with Elementor:
 * open the page → click "Edit with Elementor".
 *
 * @package NEXO
 */

get_header();
?>

<main id="primary" class="nexo-main nexo-onepage">

	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();

			if ( nexo_should_show_default_sections( get_the_ID() ) ) {
				get_template_part( 'template-parts/hero' );
				get_template_part( 'template-parts/about' );
				get_template_part( 'template-parts/services' );
				get_template_part( 'template-parts/portfolio' );
				get_template_part( 'template-parts/testimonials' );
				get_template_part( 'template-parts/pricing' );
				get_template_part( 'template-parts/faq-contact' );
			} else {
				?>
				<div class="nexo-elementor-content">
					<?php the_content(); ?>
				</div>
				<?php
			}
		endwhile;
	endif;
	?>

</main>

<?php
get_footer();
