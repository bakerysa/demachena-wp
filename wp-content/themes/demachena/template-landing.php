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

	<div id="primary" class="content-area">
		<main class="main" role="main">

	    <div class="desktop-hide">
	      <div id="myCarousel" class="carousel slide" data-ride="carousel">
	      <div class="carousel-inner">
	        <div class="item active">
	          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/landing/1.jpg">
	        </div>
	        <div class="item">
	          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/landing/2.jpg">
	        </div>
	        <div class="item">
	          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/landing/3.jpg">
	        </div>
	        <div class="item">
	          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/landing/4.jpg">
	        </div>

	        <div class="item">
	          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/landing/5.jpg">
	        </div>

	        <div class="item">
	          <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/landing/6.jpg">
	        </div>
	      </div>
	    </div>
	    </div>

	      <div class="landing-grid mobile-hide">
	        <div class="left-container">
	          <div class="left-contents" >
	            <div class="content">
	              <div id="carousel-1" class="carousel slide" data-ride="carousel">
	                <div class="carousel-inner">
	                  <div class="item active">
	                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/landing/1.jpg">
	                  </div>

	                  <div class="item">
	                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/landing/3.jpg">
	                  </div>

	                  <div class="item">
	                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/landing/5.jpg">
	                  </div>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	        <div class="right-container mobile-hide">
	          <div class="right-contents" >
	            <div class="content">
	              <div id="carousel-2" class="carousel slide" data-ride="carousel">
	              <div class="carousel-inner">
	                <div class="item active">
	                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/landing/2.jpg">
	                </div>

	                <div class="item">
	                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/landing/4.jpg">
	                </div>

	                <div class="item">
	                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/landing/6.jpg">
	                </div>
	              </div>
	            </div>
	            </div>
	          </div>
	        </div>
	      </div>

	      <div class="landing-link">
	        <span><a href="about">Enter</a></span>
	      </div>

	  </main>
	</div><!-- #primary -->
<?php
get_footer('alt');
