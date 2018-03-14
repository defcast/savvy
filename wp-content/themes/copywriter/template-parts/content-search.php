<?php $copywriter_hide_meta = esc_html(get_theme_mod('copywriter_hide_meta', 1)); ?>
<div class="sub-nav">
    <?php echo sprintf(esc_html__('Search Results for: %s','copywriter'),get_search_query()); ?>
</div>
<div class="animated fadeIn">
    <?php if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>
    <article class="post">
        <div class="post-preview col-xs-12 col-sm-12  no-post blog-img">
            <?php if(has_post_thumbnail()){ ?>
               <div class="featured-image">
                 <?php the_post_thumbnail(); ?>    
               </div> 
               <?php } 
                the_title( sprintf( '<h2 class="hvr-underline-from-left"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' );
                the_excerpt();
        if ( 'post' === get_post_type() ) {    
            if($copywriter_hide_meta != 0){ ?>
                <div class="meta">
                    <?php $copywriter_author= esc_attr(ucfirst(get_the_author()));
                    $copywriter_author_url= esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
                    echo sprintf( '<a href="%1$s">%2$s</a> in %3$s',$copywriter_author_url,$copywriter_author,get_the_category_list(' <i class="link-spacer"></i> ')); ?>
                    <i class="link-spacer"></i>
                    <?php the_date(); ?>
                </div>
            <?php 
            } 
        }    ?>
        </div>
    </article>
<?php endwhile; endif; ?>
    <div class="page-links">
        <?php the_posts_pagination( array( 'mid_size'  => 3,'screen_reader_text' => ' ') ); ?>
    </div>    
</div>