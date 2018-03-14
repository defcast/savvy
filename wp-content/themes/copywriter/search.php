<?php
/**
 * The template for displaying search results pages
 *
 *
 * @package copywriter
 */
get_header(); 
if ( have_posts() ) { 
	get_template_part( 'template-parts/content', 'search' ); 
} else {
	get_template_part( 'template-parts/content', 'none' );
}
get_footer();