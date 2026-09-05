<?php
/**
 * Front Page Template - One Page Layout
 *
 * This template loads all one-page sections.
 * When using Elementor, you can replace this with a Canvas template.
 *
 * @package NEXO
 */

get_header();
?>

<main id="primary" class="nexo-main nexo-onepage">

	<?php
	// Hero Section
	get_template_part( 'template-parts/hero' );

	// About Section
	get_template_part( 'template-parts/about' );

	// Services Section
	get_template_part( 'template-parts/services' );

	// Portfolio Section (Dynamic CPT)
	get_template_part( 'template-parts/portfolio' );

	// Testimonials Section (Dynamic CPT)
	get_template_part( 'template-parts/testimonials' );

	// Pricing Section
	get_template_part( 'template-parts/pricing' );

	// FAQ + Contact
	get_template_part( 'template-parts/faq-contact' );
	?>

</main>

<?php
get_footer();
