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

get_header(); ?>

	<div id="primary" class="content-area">
		<main class="main h-margin-top" role="main">

	    <div class="container center ">
	      <div class="col-md-12">
	        <div id="myCarousel" class="carousel slide" data-ride="carousel">

	          <div class="carousel-inner">
	            <div class="item active">
	              <a href="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/1.jpg" data-rel="lightcase:lookbook">
	                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/1.jpg">
	              </a>
	            </div>

	            <div class="item">
	              <a href="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/2.jpg" data-rel="lightcase:lookbook">
	                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/2.jpg">
	              </a>
	            </div>

	            <div class="item">
	              <a href="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/3.jpg" data-rel="lightcase:lookbook">
	                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/3.jpg">
	              </a>
	            </div>

	            <div class="item">
	              <a href="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/4.jpg" data-rel="lightcase:lookbook">
	                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/4.jpg">
	              </a>
	            </div>

	            <div class="item">
	              <a href="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/5.jpg" data-rel="lightcase:lookbook">
	                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/5.jpg">
	              </a>
	            </div>

	            <div class="item">
	              <a href="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/6.jpg" data-rel="lightcase:lookbook">
	                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/6.jpg">
	              </a>
	            </div>

	            <div class="item">
	              <a href="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/7.jpg" data-rel="lightcase:lookbook">
	                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/7.jpg">
	              </a>
	            </div>

	            <div class="item">
	              <a href="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/8.jpg" data-rel="lightcase:lookbook">
	                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/8.jpg">
	              </a>
	            </div>

	            <div class="item">
	              <a href="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/9.jpg" data-rel="lightcase:lookbook">
	                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/9.jpg">
	              </a>
	            </div>

	            <div class="item">
	              <a href="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/10.jpg" data-rel="lightcase:lookbook">
	                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/10.jpg">
	              </a>
	            </div>

	            <div class="item">
	              <a href="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/11.jpg" data-rel="lightcase:lookbook">
	                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/11.jpg">
	              </a>
	            </div>

	            <div class="item">
	              <a href="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/12.jpg" data-rel="lightcase:lookbook">
	                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/12.jpg">
	              </a>
	            </div>

	            <div class="item">
	              <a href="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/13.jpg" data-rel="lightcase:lookbook">
	                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/lookbook/13.jpg">
	              </a>
	            </div>
	          </div>

	          <a class="left carousel-control" href="#myCarousel" data-slide="prev">
	            <span class="glyphicon glyphicon-chevron-left"></span>
	            <span class="sr-only">Previous</span>
	          </a>
	          <a class="right carousel-control" href="#myCarousel" data-slide="next">
	            <span class="glyphicon glyphicon-chevron-right"></span>
	            <span class="sr-only">Next</span>
	          </a>
	        </div>
	      </div>
	    </div>

	  </main>
	</div><!-- #primary -->
<?php
get_footer('alt');
