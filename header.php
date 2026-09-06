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

<a class="skip-link screen-reader-text" href="#primary">پرش به محتوا</a>

<header id="masthead" class="nexo-header">
	<div class="nexo-container nexo-header-inner">
		<div class="nexo-logo">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				echo '<a href="' . esc_url( home_url( '/' ) ) . '" rel="home"><span>N</span>EXO</a>';
			}
			?>
		</div>

		<nav id="site-navigation" class="nexo-nav" aria-label="منوی اصلی">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'fallback_cb'    => 'nexo_fallback_menu',
				)
			);
			?>
		</nav>

		<div class="nexo-header-cta">
			<a href="#contact" class="nexo-btn nexo-btn-primary">گفتگو کنیم</a>
		</div>
	</div>
</header>
