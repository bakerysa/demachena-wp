<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Thanks
 *
 * @package storefront
 */

get_header('pink'); ?>

	<div id="primary">
		<main class="main" role="main">
	    <div class="container center">
				<div class="row text-center" style="padding-top: 4rem;">
	        <h3><?php the_field('thanks_header'); ?></h3>
	        <p><?php the_field('thanks_message'); ?></p>
	      </div>
	    </div>
	  </main>
	</div><!-- #primary -->
<?php
get_footer('alt');
