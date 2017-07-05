<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Lookbook
 *
 * @package storefront
 */

get_header('green'); ?>

	<div id="primary">
		<main class="main h-margin-top" role="main">

	    <div class="container center ">
	      <div class="col-md-12">
					<?php
					    echo do_shortcode("[metaslider id=52]");
					?>
	      </div>
	    </div>

	  </main>
	</div><!-- #primary -->
<?php
get_footer('alt');
