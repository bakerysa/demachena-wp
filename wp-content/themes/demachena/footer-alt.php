<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer class="footer desktop" style="position: absolute;" role="contentinfo">
		<a href="<?php echo get_site_url(); ?>/subscribe" class="btn-subscribe">Subscribe</a>
		<?php get_search_form(); ?>
		<ul class="footer-nav">
			<li>
				<a href="<?php echo get_site_url(); ?>/faqs">FAQ</a>
			</li>
			<li>
				<a href="<?php echo get_site_url(); ?>/terms-of-service">Terms of Service</a>
			</li>
			<li>
				<div class="social">
					<a href="https://www.instagram.com/dema_chena/" target="_blank">
						<i class="fa fa-instagram" aria-hidden="true"></i>
					</a>
					<a href="https://twitter.com/dema_chena" target="_blank">
						<i class="fa fa-twitter" aria-hidden="true"></i>
					</a>
					<a href="https://www.facebook.com/demachena/" target="_blank">
						<i class="fa fa-facebook-official" aria-hidden="true"></i>
					</a>
				</div>
			</li>
			<li>
				<a href="<?php echo get_site_url(); ?>/shipping-returns">Shipping &amp; Returns</a>
			</li>
			<li>
				<a href="<?php echo get_site_url(); ?>/privacy-statement">Privacy Statement</a>
			</li>
			<li>
				<a href="<?php echo get_site_url(); ?>/my-account">My Account</a>
			</li>
		</ul>
	</footer>

	<footer class="footer mobile" role="contentinfo">
		<a href="<?php echo get_site_url(); ?>/subscribe" class="btn-subscribe">Subscribe</a>
		<?php get_search_form(); ?>
			<div class="social">
				<a href="https://www.instagram.com/dema_chena/">
					<i class="fa fa-instagram" aria-hidden="true"></i>
				</a>
				<a href="https://twitter.com/dema_chena">
					<i class="fa fa-twitter" aria-hidden="true"></i>
				</a>
				<a href="https://www.facebook.com/demachena/">
					<i class="fa fa-facebook-official" aria-hidden="true"></i>
				</a>
			</div>
		<ul class="footer-nav">
			<li>
				<a href="<?php echo get_site_url(); ?>/faqs">FAQ</a>
			</li>
			<li>
				<a href="<?php echo get_site_url(); ?>/terms-of-service">Terms of Service</a>
			</li>
			<li>
				<a href="<?php echo get_site_url(); ?>/shipping-returns">Shipping &amp; Returns</a>
			</li>
			<li>
				<a href="<?php echo get_site_url(); ?>/privacy-statement">Privacy Statement</a>
			</li>
		</ul>
	</footer>

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type='application/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/bower_components/fastclick/lib/fastclick.js'></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/main.min.js"></script>

<script>
	if ('addEventListener' in document) {
		document.addEventListener('DOMContentLoaded', function() {
			FastClick.attach(document.body);
		}, false);
	}
</script>

	<script type="text/javascript" src="//s3.amazonaws.com/downloads.mailchimp.com/js/signup-forms/popup/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script><script type="text/javascript">require(["mojo/signup-forms/Loader"], function(L) { L.start({"baseUrl":"mc.us14.list-manage.com","uuid":"85f328408bd696758c7f32228","lid":"a33d5e4de2"}) })</script>

<script>
	(function(f, i, r, e, s, h, l) {
		i['GoogleAnalyticsObject'] = s;
		f[s] = f[s] || function() {
			(f[s].q = f[s].q || []).push(arguments)
		}, f[s].l = 1 * new Date();
		h = i.createElement(r),
			l = i.getElementsByTagName(r)[0];
		h.async = 1;
		h.src = e;
		l.parentNode.insertBefore(h, l)
	})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
	ga('create', 'UA-99071631-1');
	ga('send', 'pageview');
</script>

</body>
</html>
