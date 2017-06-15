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

	<footer class="footer" role="contentinfo" style="position: absolute;">
		<a href="subscribe.html" class="btn-subscribe" style="margin-top: 5rem;">Subscribe</a>
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
