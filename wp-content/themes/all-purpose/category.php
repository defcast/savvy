<?php
/*
* A Simple Category Template
*/
 get_header(); ?>
 
<div id="content-center">

	<div id="primary" class="content-area">
	
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', get_post_format() ); ?>

			<?php endwhile; ?>
			
			<div class="nextpage">
			
				<div class="pagination">
				
					<?php the_post_navigation(); ?>
					
				</div> 
				
			</div> 
			
			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>
	
		</main><!-- #main -->
		
	</div><!-- #primary -->
	
	<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>