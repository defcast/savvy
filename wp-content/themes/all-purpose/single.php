<?php
/**
 * The template for displaying all single posts
 *
 * @package All Purpose
 */

get_header(); ?>

	<div id="content-center">
	
		<div id="primary" class="content-area">

			<main id="main" class="site-main app-post" role="main">
				<?php while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', get_post_format() );
				?>
				
				<div class="postpagination">
					<?php the_post_navigation(); ?>
				</div>
				
				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>

			</main><!-- #main -->
			
		</div><!-- #primary -->
		
		<?php get_sidebar(); ?>
		
	</div>

<?php get_footer(); ?>
