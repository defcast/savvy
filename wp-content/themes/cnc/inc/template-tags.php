<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package CNC
 */

if ( ! function_exists( 'CNC_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function CNC_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		); ?>

		<ul class="post-meta">
		<li><i class="fa fa-user"></i><span><a
					href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"
					title="<?php echo esc_attr( get_the_author() ); ?>"><?php esc_html( the_author() ); ?></a></span>
		</li>
		<li><i class="fa fa-calendar"></i><span class="posted-on"><?php echo $time_string; ?></span></li>
		<?php CNC_post_category(); ?>
		</ul>
		<?php
		echo ( is_archive() ) ? '<hr>' : '';
	}
endif;

if ( ! function_exists( 'CNC_posted_on_no_cat' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function CNC_posted_on_no_cat() {

		if ( is_singular( 'jetpack-portfolio' ) ) {
			$post_author = get_theme_mod( 'project_author', true );
			$post_date   = get_theme_mod( 'project_date', true );
		} else {
			$post_author = get_theme_mod( 'post_author', true );
			$post_date   = get_theme_mod( 'post_date', true );
		}

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		if ( $post_date || $post_author ) :
		?>

		<ul class="post-meta">
		<?php if ( $post_date ) : ?>
			<li><span class="posted-on"><?php echo $time_string; ?></span></li>
		<?php endif ?>
		<?php if ( $post_author ) : ?>
			<li><span><?php echo esc_html__( 'by', 'CNC' ); ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>"><?php esc_html( the_author() ); ?></a></span></li>
		<?php endif ?>
		</ul>
		<?php
		endif;
	}
endif;

if ( ! function_exists( 'CNC_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function CNC_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'CNC' ) );
			if ( $categories_list && CNC_categorized_blog() ) {
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'CNC' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'CNC' ) );

			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'CNC' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'CNC' ), esc_html__( '1 Comment', 'CNC' ), esc_html__( '% Comments', 'CNC' ) );
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'CNC' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function CNC_categorized_blog() {
	$all_the_cool_cats = get_transient( 'CNC_categories' );
	if ( false === $all_the_cool_cats ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories(
			array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				'number'     => 2,
			)
		);

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'CNC_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so CNC_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so CNC_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in CNC_categorized_blog.
 */
function CNC_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'CNC_categories' );
}

add_action( 'edit_category', 'CNC_category_transient_flusher' );
add_action( 'save_post', 'CNC_category_transient_flusher' );


if ( ! function_exists( 'CNC_post_category' ) ) :
	/**
	 * Get category attached to post.
	 */
	function CNC_post_category() {
		$category = get_the_category();
		if ( ! empty( $category ) ) {
			$i = ( 'uncategorized' == $category[0]->slug && array_key_exists( '1', $category ) ) ? 1 : 0;
			echo '<li><i class="fa fa-folder-open-o"></i><span class="cat-links"><a href="' . esc_url( get_category_link( $category[ $i ]->term_id ) ) . '" title="' . sprintf( esc_html__( 'View all posts in %s', 'CNC' ), esc_attr( $category[ $i ]->name ) ) . '" ' . '>' . esc_html( $category[ $i ]->name ) . '</a></span></li> ';
		}
	}
endif;

/**
 * Filter the categories widget to add a <span> element before the count
 *
 * @param $links
 *
 * @return mixed
 */
function CNC_add_span_cat_count( $links ) {
	$links = str_replace( '</a> (', '</a> <span class="CNC-cat-count">', $links );
	$links = str_replace( ')', '</span>', $links );

	return $links;
}

add_filter( 'wp_list_categories', 'CNC_add_span_cat_count' );

function CNC_add_span_archive_count( $links ) {
	$links = str_replace( '</a>&nbsp;(', '</a> <span class="CNC-cat-count">', $links );
	$links = str_replace( ')', '</span>', $links );

	return $links;
}

add_filter( 'get_archives_link', 'CNC_add_span_archive_count' );
