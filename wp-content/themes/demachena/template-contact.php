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

get_header('alt'); ?>

	<div id="primary">
		<main class="main" role="main">

      <div class="container center">
        <div class="col-md-4 contact-details">
          <p>SOUTH AFRICA</p>
          <span><a class="contact-item" href="mailto:sam@dema-chena.com">sam@dema-chena.com</a></span>
          <span><a class="contact-item" href="tel:+27745839433">+27 74 583 9433</a></span>
        </div>
        <div class="col-md-4 contact-details">
          <p>ZIMBABWE</p>
          <span><a class="contact-item" href="mailto:farai@dema-chena.com ">farai@dema-chena.com</a></span>
          <span><a class="contact-item" href="tel:+263772572540 ">+263 77 257 2540 </a></span>
        </div>
        <div class="col-md-4 contact-details">
          <p>NEW YORK</p>
          <span><a class="contact-item" href="mailto:hello@dema-chena.com">hello@dema-chena.com</a></span>
          <span><a class="contact-item" href="tel:+13476799406">+1 347 679 9406</a></span>
        </div>
      </div>

    </main>
	</div><!-- #primary -->
<?php
get_footer('alt');
