<?php
/**
 * Header template
 *
 * @package NEXO
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'nexo' ); ?></a>

<header id="masthead" class="nexo-header">
	<div class="nexo-container nexo-header-inner">
		<div class="nexo-logo">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				$site_name = get_bloginfo( 'name' );
				echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home"><span>N</span>EXO</a>';
			}
			?>
		</div>

		<nav id="site-navigation" class="nexo-nav" aria-label="<?php esc_attr_e( 'Primary Menu', 'nexo' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'menu_id'        => 'primary-menu',
				'container'      => false,
				'fallback_cb'    => 'nexo_fallback_menu',
			) );
			?>
		</nav>

		<div class="nexo-header-cta">
			<a href="#contact" class="nexo-btn nexo-btn-primary"><?php esc_html_e( "Let's Talk", 'nexo' ); ?></a>
		</div>
	</div>
</header>
