<?php
/**
 * Front Page
 *
 * - If Elementor is editing / previewing / has saved design → output the_content()
 * - Otherwise show default NEXO one-page sections
 *
 * The Home page is a real Page (appears under Pages) and is fully editable with Elementor.
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
				// Default built-in sections (no Elementor design yet)
				get_template_part( 'template-parts/hero' );
				get_template_part( 'template-parts/about' );
				get_template_part( 'template-parts/services' );
				get_template_part( 'template-parts/portfolio' );
				get_template_part( 'template-parts/testimonials' );
				get_template_part( 'template-parts/pricing' );
				get_template_part( 'template-parts/faq-contact' );
			} else {
				// Elementor canvas / user content — MUST call the_content()
				?>
				<div class="nexo-elementor-content">
					<?php the_content(); ?>
				</div>
				<?php
			}
		endwhile;
	else :
		// Fallback if no front page post in query
		get_template_part( 'template-parts/hero' );
		get_template_part( 'template-parts/about' );
		get_template_part( 'template-parts/services' );
		get_template_part( 'template-parts/portfolio' );
		get_template_part( 'template-parts/testimonials' );
		get_template_part( 'template-parts/pricing' );
		get_template_part( 'template-parts/faq-contact' );
	endif;
	?>

</main>

<?php
get_footer();
