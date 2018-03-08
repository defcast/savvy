<?php
/**
 * The template for displaying the footer
 *
 * @package All Purpose
 */

?>

	</div><!-- #content -->
	
	<footer id="colophon"  role="contentinfo">
	
		<div class="site-info">

				<?php esc_html_e('All rights reserved', 'all-purpose'); ?>  &copy; <?php bloginfo('name'); ?>
							
				<a title="Seos Themes" href="<?php echo esc_url(__('https://seosthemes.com/', 'all-purpose')); ?>" target="_blank"><?php esc_html_e('Theme by Seos Themes', 'all-purpose'); ?></a>
			
		</div><!-- .site-info -->
		
	</footer><!-- #colophon -->
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
