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
<title>Dema-Chena</title>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="icon" type="image/png" href="images/favicon.png?v=3" />

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="theme-color" content="#162d1c">
<meta name="description" content="Dema Chena creates unique, artisanal, luxurious womenswear. Inspired by Africa, designed and made in Africa.">
<meta name="keywords" content="dema-chean, dema, chena, african, fashion, womenswear">

<meta property="og:url" content="http://dema-chena.com" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Dema-Chena" />
<meta property="og:description" content="Helping you go from day to night. Black to white. Dema to Chena." />
<meta property="og:image" content="http://dema-chena.com/fb.jpg" />

<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/bower_components/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/bower_components/lightcase/src/css/lightcase.css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/evil-icons/1.9.0/evil-icons.min.css">

<?php wp_head(); ?>
</head>

<body <?php body_class( 'theme-green' ); ?>>
<div id="page" class="hfeed site">
	<?php
	do_action( 'storefront_before_header' ); ?>

	<header class="header">
    <div class="logo">
      <a href="<?php echo get_home_url(); ?>">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo-v2-light.png" alt="Logo">
        </a>
    </div>
		<?php wp_nav_menu( array( 'container_class' => 'nav', 'before' => '<span>',
        'after' => '</span>' ) ); ?>
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
