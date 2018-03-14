<?php
/**
 * The template for displaying all single posts
 *
 * @package copywriter
 */
get_header();
$copywriter_hide_meta = esc_html(get_theme_mod('copywriter_hide_meta', 1)); ?>
<div class="animated fadeIn">
    <?php  if ( have_posts() ) :  while ( have_posts() ) : the_post(); ?>
        <article class="single-post">
            <div class="post-preview col-xs-12  no-post-single">
             <?php if(has_post_thumbnail()){ ?>
               <div class="featured-image">
                 <?php the_post_thumbnail(); ?>    
               </div> 
               <?php } ?>
                <h2 class="post-title"><?php the_title(); ?></h2>
                <?php if($copywriter_hide_meta != 0){ ?>
                <div class="meta">
                    <span class="post-date"><?php the_date(); ?></span>
                     &nbsp;<i class="link-spacer"></i>&nbsp;
                    <?php $copywriter_comments = wp_count_comments(get_the_ID());     
                    $copywriter_total_comments = $copywriter_comments->total_comments;
                    echo sprintf('%s',get_the_category_list(' <i class="link-spacer"></i> ')); 
                    if($copywriter_total_comments != ''){ ?>
                    <i class="link-spacer"></i>
                    <a href="<?php echo esc_url(comments_link()); ?>"><i class="fa fa-comments" aria-hidden="true"></i> <?php echo sprintf('%s',$copywriter_total_comments); ?> <?php esc_html_e('Comments','copywriter'); ?></a>
                    <?php } ?>
                </div>
                <?php } 
                the_content(); 
                if($copywriter_hide_meta != 0){ ?>
                <div class="meta">
                    <?php echo sprintf('%s',get_the_tag_list('Tags | ',' <i class="link-spacer"></i> ')); ?>
                </div>
                <?php } ?>
            </div>
        </article>
    <?php
    wp_link_pages();
    the_post_navigation( array(
        'prev_text'                 => '<button>'.esc_html__('Previous','copywriter').'</button>',
        'next_text'                 => '<button>'.esc_html__('Next','copywriter').'</button>',
        'screen_reader_text'        => ' ',
    ) );
    comments_template('', true); 
    endwhile; endif; ?>   
<!--Post-Table-->
        </div>
    </div>
<?php get_footer();