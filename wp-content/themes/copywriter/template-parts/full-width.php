<?php 
/*
* Template Name: Full Width
*/
get_header(); ?>
<div class="container full-width">
<h2 class="post-title"><?php the_title(); ?></h2>
<?php if(have_posts()): 
        while ( have_posts() ) : the_post(); ?>
            <?php the_content(); ?>
            <?php if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
        endwhile;
    endif; ?>
</div>    
<?php get_footer();