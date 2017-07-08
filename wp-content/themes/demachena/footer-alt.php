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

	<footer class="footer" style="position: absolute;" role="contentinfo">
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

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type='application/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/bower_components/fastclick/lib/fastclick.js'></script>

<script>
	if ('addEventListener' in document) {
		document.addEventListener('DOMContentLoaded', function() {
			FastClick.attach(document.body);
		}, false);
	}
</script>

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
