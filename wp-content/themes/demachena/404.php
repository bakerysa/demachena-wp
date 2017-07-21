<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package storefront
 */

get_header('pink'); ?>

<div id="primary">
	<main class="main" role="main">

		<div class="container center" style="text-align: center;">
			<h4>Oh no!</h4>
			<p>
				The page you're looking for does not exist. <br /> Let's get back to shopping!
			</p>
			<button class="btn-404"><a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"  style="margin-top: 4rem;">Return To Shop</a></button>
		</div>

	</main>
</div><!-- #primary -->

<?php get_footer('alt');
