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
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main class="main" role="main">

			<header class="header">
	      <div class="logo mobile-logo">
	        <a href="/">
	          <img src="images/logo-v2-light.png" alt="Logo">
	        </a>
	      </div>
	    </header>

	    <div class="desktop-hide">
	      <div id="myCarousel" class="carousel slide" data-ride="carousel">
	      <div class="carousel-inner">
	        <div class="item active">
	          <img src="images/landing/1.jpg">
	        </div>
	        <div class="item">
	          <img src="images/landing/2.jpg">
	        </div>
	        <div class="item">
	          <img src="images/landing/3.jpg">
	        </div>
	        <div class="item">
	          <img src="images/landing/4.jpg">
	        </div>

	        <div class="item">
	          <img src="images/landing/5.jpg">
	        </div>

	        <div class="item">
	          <img src="images/landing/6.jpg">
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
	                    <img src="images/landing/1.jpg">
	                  </div>

	                  <div class="item">
	                    <img src="images/landing/3.jpg">
	                  </div>

	                  <div class="item">
	                    <img src="images/landing/5.jpg">
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
	                  <img src="images/landing/2.jpg">
	                </div>

	                <div class="item">
	                  <img src="images/landing/4.jpg">
	                </div>

	                <div class="item">
	                  <img src="images/landing/6.jpg">
	                </div>
	              </div>
	            </div>
	            </div>
	          </div>
	        </div>
	      </div>

	      <div class="landing-link">
	        <span><a href="about.html">Enter</a></span>
	      </div>

	  </main>
	</div><!-- #primary -->
<?php
get_footer();
