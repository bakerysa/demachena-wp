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

<style>
@media only screen and (max-width:992px) {
	.woocommerce-currency-switcher {
		display: none;
	}
	.select-wrapper {
		display: none;
	}
	.entry-header {
		display: none;
		}
}
</style>

	<div id="primary">
		<main class="main h-margin-top" role="main">

	    <div class="container center-2">
	      <div class="col-md-12">
					<?php while ( have_posts() ) : the_post();

						get_template_part( 'content', 'page' );

					endwhile; // End of the loop. ?>
	      </div>
	    </div>

	  </main>
	</div><!-- #primary -->
<?php
get_footer('none');
