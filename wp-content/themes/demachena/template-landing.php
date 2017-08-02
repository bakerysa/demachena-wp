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

	<div id="primary">
		<main role="main" class="main main-landing">

	    <div class="mobile">
				<?php
				    echo do_shortcode("[metaslider id=45]");
				?>
	    </div>
			<!-- END desktop-hide -->

			<!-- START landing-grid -->
      <div class="desktop-hide">
				<div class="col-md-6" style="padding: 0;">
					<?php
							echo do_shortcode("[metaslider id=31]");
					?>
				</div>
      </div>
			<div class="desktop-hide">
				<div class="col-md-6" style="padding: 0;">
					<?php
							echo do_shortcode("[metaslider id=41]");
					?>
				</div>
			</div>
			<!-- END landing-grid -->

	  </main>

		<!-- START landing-link -->
	  <div class="landing-link">
	    <span><a href="about">Enter</a></span>
	  </div>
		<!-- END landing-link -->
	<!-- </div> -->
	<!-- #primary -->
<?php
get_footer('none');
