<?php
/**
 * The template for displaying full width pages.
 *
 * Template Name: Green
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
}
</style>

	<div id="primary">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post();

				do_action( 'storefront_page_before' );

				get_template_part( 'content', 'page' );

				/**
				 * Functions hooked in to storefront_page_after action
				 *
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );

			endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
