<?php
/**
 * Front Page Template
 *
 * Priority:
 * 1. If a static front page is set and has content / Elementor → show that (fully editable).
 * 2. Otherwise load the default NEXO one-page sections.
 *
 * Recommended for commercial use:
 * Create a Page → Template: "NEXO OnePage" → Settings → Reading → set as homepage.
 * Then the page appears in Pages list and can be edited with Elementor.
 *
 * @package NEXO
 */

get_header();
?>

<main id="primary" class="nexo-main nexo-onepage">

	<?php
	$show_default_sections = true;

	// Static front page assigned?
	if ( is_front_page() && is_page() ) {
		while ( have_posts() ) {
			the_post();

			$built_with_elementor = false;
			if ( defined( 'ELEMENTOR_VERSION' ) && class_exists( '\Elementor\Plugin' ) ) {
				$built_with_elementor = \Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() );
			}

			$content = trim( get_the_content() );

			if ( $built_with_elementor || ! empty( $content ) ) {
				the_content();
				$show_default_sections = false;
			}
		}
	}

	if ( $show_default_sections ) {
		get_template_part( 'template-parts/hero' );
		get_template_part( 'template-parts/about' );
		get_template_part( 'template-parts/services' );
		get_template_part( 'template-parts/portfolio' );
		get_template_part( 'template-parts/testimonials' );
		get_template_part( 'template-parts/pricing' );
		get_template_part( 'template-parts/faq-contact' );
	}
	?>

</main>

<?php
get_footer();
