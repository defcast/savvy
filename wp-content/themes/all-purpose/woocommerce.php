<?php
/**
 * The main template file.
 *
**/
get_header(); ?>

<div id="content-center">

	<div id="primary" class="content-area">
	
		<main id="main" class="site-main app-page" role="main">
		
			<article id="post-<?php the_ID(); ?>">

				<?php woocommerce_content(); ?>
						
			</article>
		
		</main><!-- #main -->
		
	</div><!-- #primary -->
	
	<?php get_sidebar(); ?>
	
</div>	

<?php get_footer(); ?>
