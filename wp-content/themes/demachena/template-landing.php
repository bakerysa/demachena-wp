<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Landing
 *
 * @package demachena
 */

get_header('landing'); ?>

	<!-- <div id="primary" class="content-area"> -->
		<main role="main">

	    <div class="desktop-hide">
				<?php
				    echo do_shortcode("[metaslider id=45]");
				?>
	    </div>
			<!-- END desktop-hide -->

			<!-- START landing-grid -->
      <div class="mobile-hide">
				<div class="col-md-6">
					<?php
							echo do_shortcode("[metaslider id=31]");
					?>
				</div>
      </div>
			<div class="mobile-hide">
				<div class="col-md-6">
					<?php
							echo do_shortcode("[metaslider id=41]");
					?>
				</div>
			</div>
			<!-- END landing-grid -->

			<!-- START landing-link -->
      <div class="landing-link">
        <span><a href="about">Enter</a></span>
      </div>
			<!-- END landing-grid -->

	  </main>
	<!-- </div> -->
	<!-- #primary -->
<?php
get_footer('alt');
