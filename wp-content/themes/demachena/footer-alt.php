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

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
	window.jQuery || document.write('<script src="assets/components/jquery.js"><\/script>');
</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/evil-icons/1.9.0/evil-icons.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/bower_components/lightcase/src/js/lightcase.js"></script>
<script type='application/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/bower_components/fastclick/lib/fastclick.js'></script>

<script>
var totalItems = $('.item').length;
var currentIndex = $('div.active').index() + 1;
$('.num').html(''+currentIndex+'/'+totalItems+'');

$('#myCarousel').carousel({
		interval: 5000
});

$('#myCarousel').on('slid.bs.carousel', function() {
		currentIndex = $('div.active').index() + 1;
	 $('.num').html(''+currentIndex+'/'+totalItems+'');
});
</script>

<script>
$('#carousel-1').carousel({
		interval: 5500
});

$('#carousel-2').carousel({
		interval: 3000
});
</script>

<script>
	if ('addEventListener' in document) {
		document.addEventListener('DOMContentLoaded', function() {
			FastClick.attach(document.body);
		}, false);
	}
</script>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('a[data-rel^=lightcase]').lightcase(
			{
				maxWidth: '1920',
				maxHeight: '1080',
			}
		);
	});
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
