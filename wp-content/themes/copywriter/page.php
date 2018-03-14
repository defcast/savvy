<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 *
 * @package copywriter
 */
get_header(); ?>

<div class="animated fadeIn">	
<?php if(have_posts()): 
		while ( have_posts() ) : the_post(); ?>
		<article class="post">
            <div class="post-preview col-xs-12  no-post">
                <h2 class="post-title"><?php the_title(); ?></h2>
                <?php the_content(); ?>
            </div>
        </article>
			<?php 
			wp_link_pages();
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		endwhile;
	endif; ?>
</div>
<?php get_footer();