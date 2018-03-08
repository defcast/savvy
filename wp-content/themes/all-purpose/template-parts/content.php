<?php
/**
 * Template part for displaying posts
 *
 */

?>

<article id="post-<?php the_ID(); ?>">

	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php all_purpose_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->
	
	<?php if ( is_front_page() || is_home() || is_category() || is_archive() ) : ?>
		<?php if ( has_post_thumbnail() ) { ?>
		<a class="app-img-effect" href="<?php the_permalink(); ?>">	
			<div class="app-first">
				<div class="app-sub">
					<div class="app-basic">
						<div class="app-transform">
							<div class='app-transform-front'><?php the_post_thumbnail(); ?></div>
							<div class="app-transform-back">
								<h2><?php echo esc_html_e( 'Read More', 'all-purpose' ); ?></h2>
							</div>						
						</div>
					</div>
				</div>
			</div>
		</a>
		<?php } ?>
		<?php if ( (get_theme_mod('no_post_img') == "default" or get_theme_mod('no_post_img') == "") and !has_post_thumbnail()) { ?>		
		<a class="app-img-effect" href="<?php the_permalink(); ?>">	
			<div class="app-first">
				<div class="app-sub">
					<div class="app-basic">
						<div class="app-transform">
							<div class='app-transform-front'><img alt="post-img" src="<?php echo get_template_directory_uri(). "/framework/images/post.png"; ?>"></div>
							<div class="app-transform-back">
								<h2><?php echo esc_html_e( 'Read More', 'all-purpose' ); ?></h2>
							</div>						
						</div>
					</div>
				</div>
			</div>
		</a>		
		<?php } ?>
		
	<?php the_excerpt(); ?>
	
	<?php else : ?>
	
	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'all-purpose' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'all-purpose' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	
	<?php endif; ?>
	
	<footer class="entry-footer">
		<?php all_purpose_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
