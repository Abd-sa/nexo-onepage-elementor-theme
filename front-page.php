<?php
/**
 * Front Page
 *
 * By default shows the full designed one-page sections (Hero, About, ...).
 * Only switches to Elementor output when a real Elementor design is saved,
 * or when you are inside the Elementor editor/preview.
 *
 * @package NEXO
 */

get_header();
?>

<main id="primary" class="nexo-main nexo-onepage">

	<?php
	$post_id = get_queried_object_id();

	if ( nexo_should_show_default_sections( $post_id ) ) :
		// ===== طراحی پیش‌فرض تم (همیشه تا وقتی Elementor ذخیره نشده) =====
		get_template_part( 'template-parts/hero' );
		get_template_part( 'template-parts/about' );
		get_template_part( 'template-parts/services' );
		get_template_part( 'template-parts/portfolio' );
		get_template_part( 'template-parts/testimonials' );
		get_template_part( 'template-parts/pricing' );
		get_template_part( 'template-parts/faq-contact' );
	else :
		// ===== خروجی Elementor =====
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
	endif;
	?>

</main>

<?php
get_footer();
