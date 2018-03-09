<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package CNC
 */

$dropcaps      = get_theme_mod( 'project_first_letter_caps', true );
$enable_tags   = get_theme_mod( 'project_tags_post_meta', true );
$post_author   = get_theme_mod( 'project_author_area', true );
$left_side     = get_theme_mod( 'project_author_left_side', false );
$post_title    = get_theme_mod( 'title_above_project', true );
$post_category = get_theme_mod( 'project_category', true );

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-content post-grid-wide' ); ?>>
	<header class="entry-header nolist">
		<?php
		$category = get_the_terms( get_the_ID(), 'jetpack-portfolio-type' );
		if ( has_post_thumbnail() ) {
			$layout = CNC_get_layout_class();
			$size   = 'CNC-featured';

			if ( 'full-width' == $layout ) {
				$size = 'CNC-full';
			}
			$image = get_the_post_thumbnail( get_the_ID(), $size );

			$allowed_tags = array(
				'img'      => array(
					'data-srcset' => true,
					'data-src'    => true,
					'srcset'      => true,
					'sizes'       => true,
					'src'         => true,
					'class'       => true,
					'alt'         => true,
					'width'       => true,
					'height'      => true,
				),
				'noscript' => array(),
			);
		?>
		<a href="<?php echo esc_url( get_the_permalink() ); ?>">
			<?php echo wp_kses( $image, $allowed_tags ); ?>
		</a>

		<?php if ( isset( $category[0] ) && $post_category ) : ?>
			<span class="CNC-category">
				<a href="<?php echo esc_url( get_category_link( $category[0]->term_id ) ); ?>">
					<?php echo esc_html( $category[0]->name ); ?>
				</a>
			</span>
		<?php endif; ?>
		<?php
		}// End if().
	?>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php if ( $post_title ) : ?>
			<h2 class="post-title">
				<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo wp_trim_words( get_the_title(), 9 ); ?></a>
			</h2>
		<?php endif ?>

		<div class="entry-meta">
			<?php
			CNC_posted_on_no_cat();
			?>
			<!-- post-meta -->
		</div>

		<?php if ( $post_author && $left_side ) : ?>
			<div class="row">
				<div class="col-md-3 col-xs-12 author-bio-left-side">
					<?php
					CNC_author_bio();
					?>
				</div>
				<div class="col-md-9 col-xs-12 CNC-content <?php echo $dropcaps ? 'dropcaps-content' : ''; ?>">
					<?php
					the_content();

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'CNC' ),
							'after'  => '</div>',
						)
					);
					?>
				</div>
			</div>
		<?php else : ?>
			<div class="CNC-content <?php echo $dropcaps ? 'dropcaps-content' : ''; ?>">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'CNC' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>
		<?php endif; ?>
	</div><!-- .entry-content -->

	<?php
	$prev = get_previous_post_link();
	$prev = str_replace( '&laquo;', '<div class="wrapper"><span class="fa fa-angle-left"></span>', $prev );
	$prev = str_replace( '</a>', '</a></div>', $prev );
	$next = get_next_post_link();
	$next = str_replace( '&raquo;', '<span class="fa fa-angle-right"></span></div>', $next );
	$next = str_replace( '<a', '<div class="wrapper"><a', $next );
	?>
	<div class="CNC-next-prev row">
		<div class="col-md-6 text-left">
			<?php echo wp_kses_post( $prev ); ?>
		</div>
		<div class="col-md-6 text-right">
			<?php echo wp_kses_post( $next ); ?>
		</div>
	</div>

	<?php
	if ( $post_author && ! $left_side ) :
		CNC_author_bio();
	endif;

	if ( $enable_tags ) :
		$tags_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-tag', '', ' ' );
		echo ! empty( $tags_list ) ? '<div class="CNC-tags"><span class="fa fa-tags"></span>' . $tags_list . '</div>' : '';
	endif;
	?>

	<?php do_action( 'CNC_single_after_article' ); ?>
</article>
