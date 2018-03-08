<?php if( ! defined( 'ABSPATH' ) ) exit;
/**
 * All Purpose functions and definitions
 */

/*******************************
Basic
********************************/

if ( ! function_exists( 'all_purpose_setup' ) ) :

function all_purpose_setup() {

	load_theme_textdomain( 'all-purpose', ALL_PURPOSE_THEME_URI . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );			
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'all-purpose' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'all_purpose_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'all_purpose_setup' );

/*******************************
$content_width
********************************/

function all_purpose_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'all_purpose_content_width', 640 );
}
add_action( 'after_setup_theme', 'all_purpose_content_width', 0 );


/*******************************
* Register widget area.
********************************/


	function all_purpose_widgets_init() {
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'all-purpose' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'all-purpose' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	
}
add_action( 'widgets_init', 'all_purpose_widgets_init' );


	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );
	
/*******************************
* Enqueue scripts and styles.
********************************/
 
 
function all_purpose_scripts() {

		wp_enqueue_style( 'all-purpose-style', get_stylesheet_uri());
		wp_enqueue_style( 'all-purpose-animate', ALL_PURPOSE_THEME_URI . '/framework/css/animate.css');
		wp_enqueue_style( 'all-purpose-fontawesome', ALL_PURPOSE_THEME_URI . '/framework/css/font-awesome.css' );	
		wp_enqueue_style( 'all-purpose-genericons', ALL_PURPOSE_THEME_URI . '/framework/genericons/genericons.css', array(), '3.4.1' );	
		wp_enqueue_style( 'all-purpose-woocommerce', ALL_PURPOSE_THEME_URI . '/inc/woocommerce/woo-css.css' );

		
	    wp_enqueue_script('jquery');
		wp_enqueue_script( 'all-purpose-navigation', ALL_PURPOSE_THEME_URI . '/framework/js/navigation.js', array(), '20120206', true );
		wp_enqueue_script( 'all-purpose-skip-link-focus-fix', ALL_PURPOSE_THEME_URI . '/framework/js/skip-link-focus-fix.js', array(), '20130115', true );
		wp_enqueue_script( 'all-purpose-aniview', ALL_PURPOSE_THEME_URI . '/framework/js/jquery.aniview.js' );

		if ( is_singular() && wp_attachment_is_image() ) {
			wp_enqueue_script( 'all-purpose-keyboard-image-navigation', ALL_PURPOSE_THEME_SCRIPTS_URI . '/keyboard-image-navigation.js', array( 'jquery' ), '20151104' );
		}
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
}

add_action( 'wp_enqueue_scripts', 'all_purpose_scripts' );


function all_purpose_admin_scripts() {
	
		wp_enqueue_style( 'all-purpose-admin', ALL_PURPOSE_THEME_URI . '/inc/css/admin.css');
}		
add_action( 'admin_enqueue_scripts', 'all_purpose_admin_scripts' );


/*******************************
* Includes.
*******************************/

	require ALL_PURPOSE_THEME . '/inc/template-tags.php';
	require ALL_PURPOSE_THEME . '/inc/extras.php';
	require ALL_PURPOSE_THEME . '/inc/customizer.php';
	require ALL_PURPOSE_THEME . '/inc/jetpack.php';
	require ALL_PURPOSE_THEME . '/inc/custom-header.php';
	require ALL_PURPOSE_THEME . '/inc/premium-options.php';
	
/*********************************************************************************************************
* Excerpt Read More
**********************************************************************************************************/

function all_purpose_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}
	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Read More<span class="screen-reader-text"> "%s"</span>', 'all-purpose' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'all_purpose_excerpt_more' );	