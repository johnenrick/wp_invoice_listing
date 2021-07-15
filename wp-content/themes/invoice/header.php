<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package invoice
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'invoice' ); ?></a>

	<header id="masthead" class="site-header d-flex align-items-center bg-primary text-white py-1">
		<div class="site-branding ml-4 mr-3">
			<?php
			the_custom_logo();
			?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<div class="d-flex justify-content-end ">
				<button class="menu-toggle bg-white" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'invoice' ); ?></button>
			</div>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id' => 'primary-menu',
					'add_li_class' => 'mx-1 p-1'
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
