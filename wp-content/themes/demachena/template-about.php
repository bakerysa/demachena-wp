<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: About
 *
 * @package storefront
 */

get_header('pink'); ?>

	<div id="primary">
		<main class="main" role="main">

	    <div class="container center">
	      <div class="col-md-6">
	        <img class="img-responsive" src="<?php echo get_stylesheet_directory_uri(); ?>/images/about.jpg" />
	      </div>
	      <div class="col-md-6 margin-top sans">
	        <p><?php the_field('about_text'); ?></p>
	      </div>
	    </div>

	  </main>
	</div><!-- #primary -->

	<script type="text/javascript" src="//s3.amazonaws.com/downloads.mailchimp.com/js/signup-forms/popup/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script><script type="text/javascript">require(["mojo/signup-forms/Loader"], function(L) { L.start({"baseUrl":"mc.us14.list-manage.com","uuid":"85f328408bd696758c7f32228","lid":"a33d5e4de2"}) })</script>


<?php
get_footer('alt');
