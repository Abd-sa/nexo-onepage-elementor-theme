<?php
/**
 * Template Name: NEXO OnePage
 * Template Post Type: page
 *
 * Full one-page layout. Assign this template to any page (e.g. Home),
 * then set that page as the static front page under Settings → Reading.
 * The page will appear in Pages list and can be fully edited with Elementor.
 *
 * @package NEXO
 */

get_header();
?>

<main id="primary" class="nexo-main nexo-onepage">

	<?php
	/**
	 * If the page has content (edited with Elementor or classic editor),
	 * show that content so the buyer can fully customize the homepage.
	 * Otherwise fall back to the default PHP sections.
	 */
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();

			$content = get_the_content();
			$content = trim( $content );

			if ( ! empty( $content ) || ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() ) ) ) {
				// User-edited page (Elementor or editor) — full control
				the_content();
			} else {
				// Default built-in sections
				get_template_part( 'template-parts/hero' );
				get_template_part( 'template-parts/about' );
				get_template_part( 'template-parts/services' );
				get_template_part( 'template-parts/portfolio' );
				get_template_part( 'template-parts/testimonials' );
				get_template_part( 'template-parts/pricing' );
				get_template_part( 'template-parts/faq-contact' );
			}
		endwhile;
	endif;
	?>

</main>

<?php
get_footer();
