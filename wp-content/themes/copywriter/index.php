<?php
/**
 * The main template file.
 */	
get_header();
$copywriter_hide_meta = esc_html(get_theme_mod('copywriter_hide_meta', 1)); ?>
<div class="sub-nav">
    <?php $copywriter_blog_page = esc_html(get_option('page_for_posts')); 
    if(!empty($copywriter_blog_page)){ 
                echo get_the_title(get_option( 'page_for_posts' )); 
            } else{ 
                esc_html_e( "Blog", 'copywriter' );
            }  ?>
</div>
<div class="animated fadeIn" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php  if ( have_posts() ) :  while ( have_posts() ) : the_post(); ?>
    <article class="post">
        <div class="post-preview col-xs-12 col-sm-12  no-post blog-img">
            <?php if(has_post_thumbnail()){ ?>
               <div class="featured-image ">
                 <?php the_post_thumbnail(); ?> 
               </div> 
               <?php } 
                the_title( sprintf( '<h2 class="hvr-underline-from-left"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' );
                the_excerpt(); ?>
            <?php if($copywriter_hide_meta != 0){ ?>
            <div class="meta">
                <?php $copywriter_author= esc_attr(ucfirst(get_the_author()));
                $copywriter_author_url= esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
                echo sprintf( '<a href="%1$s">%2$s</a> in %3$s',$copywriter_author_url,$copywriter_author,get_the_category_list(' <i class="link-spacer"></i> ')); ?>
                <i class="link-spacer"></i>
                <?php the_date(); ?>
            </div>
            <?php } ?>
        </div>
    </article>
<?php endwhile; endif; ?>
    <div class="page-links">
        <?php the_posts_pagination( array( 'mid_size'  => 3,'screen_reader_text' => ' ') ); ?>
    </div>    
</div>
<?php get_footer();