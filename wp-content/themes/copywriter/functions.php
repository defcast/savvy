<?php
/**
 * copywriter functions and definitions
 *
 * 
 * @package copywriter
 */
if ( ! function_exists( 'copywriter_setup' ) ) :
	function copywriter_setup() {
		load_theme_textdomain( 'copywriter', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		register_nav_menus( array(
			'primary' => esc_html__( 'Top Menu', 'copywriter' ),
		) );
		add_theme_support( 'html5', array(
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'custom-logo', array(
	        'height'      => 30,
	        'width'       => 160,
	        'flex-height' => true,
			'flex-width'  => true,
	        'header-text' => array( 'site-title','site-description' ), 
	    ) );
		add_theme_support( 'custom-background', apply_filters( 'copywriter_custom_background_args', array(
			'default-color' => 'ffffff',
		) ) );
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
	add_action( 'after_setup_theme', 'copywriter_setup' );
endif;
function copywriter_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'copywriter_content_width', 640 );
}
add_action( 'after_setup_theme', 'copywriter_content_width', 0 );
function copywriter_content_length($length){	
	return (is_admin())?$length:20;
}
add_filter('excerpt_length','copywriter_content_length');
function copywriter_custom_excerpt_length_more( $more ) {	
    return ' &hellip;<div class="read-more"><a href="'. esc_url( get_permalink( get_the_ID() ) ) . '">' . esc_html__( 'Read More', 'copywriter' ).'</a></div>';
}
add_filter( 'excerpt_more', 'copywriter_custom_excerpt_length_more' );
function copywriter_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'copywriter_pingback_header' );            

require get_template_directory() . '/functions/theme-customization.php';
require get_template_directory() . '/functions/enqueue-files.php';
require get_template_directory() . '/functions/theme-default-setup.php';