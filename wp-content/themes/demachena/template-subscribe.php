<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Subscribe
 *
 * @package storefront
 */

get_header('pink'); ?>

	<div id="primary">
		<main class="main" role="main">

      <!-- Begin MailChimp Signup Form -->
    <div id="mc_embed_signup">
    <form action="//dema-chena.us14.list-manage.com/subscribe/post?u=85f328408bd696758c7f32228&amp;id=a33d5e4de2" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
        <div id="mc_embed_signup_scroll">
    <div class="mc-field-group">
    	<input type="text" value="" placeholder="Name" name="FNAME" class="" id="mce-FNAME">
    </div>
    <div class="mc-field-group">
    	<input type="text" value="" placeholder="Surname" name="LNAME" class="" id="mce-LNAME">
    </div>
    <div class="mc-field-group">
    </label>
    	<input type="email" value="" placeholder="E-Mail Address" name="EMAIL" class="required email" id="mce-EMAIL">
    </div>
    	<div id="mce-responses" class="clear">
    		<div class="response" id="mce-error-response" style="display:none"></div>
    		<div class="response" id="mce-success-response" style="display:none"></div>
    	</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_85f328408bd696758c7f32228_a33d5e4de2" tabindex="-1" value=""></div>
        <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
        </div>
    </form>
    </div>
    <!--End mc_embed_signup-->

    </main>
	</div><!-- #primary -->
<?php
get_footer('alt');
