<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Contact
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
		<main class="main" role="main">

      <div class="container center">
        <div class="col-md-4 contact-details">
          <p><?php the_field('country_1'); ?></p>
          <span><a class="contact-item" href="mailto:<?php the_field('email_1'); ?>"><?php the_field('email_1'); ?></a></span>
          <span><a class="contact-item" href="tel:<?php the_field('number_1'); ?>"><?php the_field('number_1'); ?></a></span>
        </div>
				<div class="col-md-4 contact-details">
					<p><?php the_field('country_2'); ?></p>
					<span><a class="contact-item" href="mailto:<?php the_field('email_2'); ?>"><?php the_field('email_2'); ?></a></span>
					<span><a class="contact-item" href="tel:<?php the_field('number_2'); ?>"><?php the_field('number_2'); ?></a></span>
				</div>
				<div class="col-md-4 contact-details">
					<p><?php the_field('country_3'); ?></p>
					<span><a class="contact-item" href="mailto:<?php the_field('email_3'); ?>"><?php the_field('email_3'); ?></a></span>
					<span><a class="contact-item" href="tel:<?php the_field('number_3'); ?>"><?php the_field('number_3'); ?></a></span>
				</div>
      </div>

    </main>
	</div><!-- #primary -->
<?php
get_footer('alt');
