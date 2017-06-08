<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<title>Dema-Chena</title>
<link rel="icon" type="image/png" href="images/favicon.png?v=3" />

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="theme-color" content="#162d1c">
<meta name="description" content="Dema Chena creates unique, artisanal, luxurious womenswear. Inspired by Africa, designed and made in Africa.">
<meta name="keywords" content="dema-chean, dema, chena, african, fashion, womenswear">

<link rel="stylesheet" type="text/css" href="styles/main.css">
<link rel="stylesheet" type="text/css" href="bower_components/font-awesome/css/font-awesome.min.css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="bower_components/lightcase/src/css/lightcase.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/evil-icons/1.9.0/evil-icons.min.css">

<meta property="og:url"                content="http://dema-chena.com" />
<meta property="og:type"               content="website" />
<meta property="og:title"              content="Dema-Chena" />
<meta property="og:description"        content="Helping you go from day to night. Black to white. Dema to Chena." />
<meta property="og:image"              content="http://dema-chena.com/fb.jpg" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php
	do_action( 'storefront_before_header' ); ?>

	<header id="masthead" class="site-header" role="banner" style="<?php storefront_header_styles(); ?>">
		<div class="col-full">

			<?php
			/**
			 * Functions hooked into storefront_header action
			 *
			 * @hooked storefront_skip_links                       - 0
			 * @hooked storefront_social_icons                     - 10
			 * @hooked storefront_site_branding                    - 20
			 * @hooked storefront_secondary_navigation             - 30
			 * @hooked storefront_product_search                   - 40
			 * @hooked storefront_primary_navigation_wrapper       - 42
			 * @hooked storefront_primary_navigation               - 50
			 * @hooked storefront_header_cart                      - 60
			 * @hooked storefront_primary_navigation_wrapper_close - 68
			 */
			do_action( 'storefront_header' ); ?>

		</div>
	</header><!-- #masthead -->

	<?php
	/**
	 * Functions hooked in to storefront_before_content
	 *
	 * @hooked storefront_header_widget_region - 10
	 */
	do_action( 'storefront_before_content' ); ?>

	<div id="content" class="site-content" tabindex="-1">
		<div class="col-full">

		<?php
		/**
		 * Functions hooked in to storefront_content_top
		 *
		 * @hooked woocommerce_breadcrumb - 10
		 */
		do_action( 'storefront_content_top' );
