<?php

/**
 * CNC functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package CNC
 */
if ( ! function_exists( 'CNC_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function CNC_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on CNC, use a find and replace
		 * to change 'CNC' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'CNC', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Add support for the custom logo functionality
		 */
		add_theme_support(
			'custom-logo', array(
				'height'      => 55,
				'width'       => 135,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		add_theme_support(
			'custom-header', apply_filters(
				'CNC_custom_header_args', array(
					'default-image'      => '',
					'default-text-color' => '000000',
					'width'              => 1900,
					'height'             => 225,
					'flex-width'         => true,
				)
			)
		);

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary'     => esc_html__( 'Primary', 'CNC' ),
				'social-menu' => esc_html__( 'Social Menu', 'CNC' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background', apply_filters(
				'CNC_custom_background_args', array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'CNC-full', 1110, 530, true );
		add_image_size( 'CNC-featured', 730, 350, true );
		add_image_size( 'CNC-grid', 350, 300, true );

		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		add_theme_support( 'customize-selective-refresh-widgets' );

		// Enable Shortcodes in widgets
		add_filter( 'widget_text', 'do_shortcode' );

	}
endif;
add_action( 'after_setup_theme', 'CNC_setup' );

add_filter(‘signup_header’, ‘__return_false’);

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function CNC_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'CNC_content_width', 1140 );
}

add_action( 'after_setup_theme', 'CNC_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function CNC_widgets_init() {
	register_sidebar(
		array(
			'id'            => 'sidebar-1',
			'name'          => esc_html__( 'Sidebar', 'CNC' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'id'            => 'sidebar-home',
			'name'          => esc_html__( 'Homepage', 'CNC' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	for ( $i = 1; $i < 5; $i ++ ) {
		register_sidebar(
			array(
				'id'            => 'footer-widget-' . $i,
				'name'          => sprintf( esc_html__( 'Footer Widget %s', 'CNC' ), $i ),
				'description'   => esc_html__( 'Used for footer widget area', 'CNC' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}

	if ( CNC_is_woocommerce_activated() ) {
		register_sidebar(
			array(
				'id'            => 'shop-sidebar',
				'name'          => esc_html__( 'Shop Sidebar', 'CNC' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}

}

add_action( 'widgets_init', 'CNC_widgets_init' );

/**
 * Hides the custom post template for pages on WordPress 4.6 and older
 *
 * @param array $post_templates Array of page templates. Keys are filenames, values are translated names.
 *
 * @return array Filtered array of page templates.
 */
function CNC_exclude_page_templates( $post_templates ) {

	if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
		unset( $post_templates['page-templates/full-width.php'] );
		unset( $post_templates['page-templates/no-sidebar.php'] );
		unset( $post_templates['page-templates/sidebar-left.php'] );
		unset( $post_templates['page-templates/sidebar-right.php'] );
	}

	return $post_templates;
}

add_filter( 'theme_page_templates', 'CNC_exclude_page_templates' );

/**
 * Enqueue scripts and styles.
 */
function CNC_scripts() {
	// Add Bootstrap default CSS
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css' );

	// Add Font Awesome stylesheet
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css' );

	// Add Google Fonts
	wp_enqueue_style( 'CNC-fonts', '//fonts.googleapis.com/css?family=Raleway:100,300,400,500,600,700%7COpen+Sans:400,500,600' );

	// Add slider CSS
	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/assets/css/flexslider.css' );

	//Add custom theme css
	wp_enqueue_style( 'CNC-style', get_stylesheet_uri() );

	wp_enqueue_script( 'CNC-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20160115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( post_type_exists( 'jetpack-portfolio' ) ) {
		wp_enqueue_script( 'jquery-masonry' );
	}

	// Add slider JS
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/assets/js/flexslider.min.js', array( 'jquery' ), '20160222', true );

	if ( is_page_template( 'page-templates/template-home.php' ) ) {
		wp_enqueue_script( 'CNC-parallax', get_template_directory_uri() . '/assets/js/parallax.min.js', array( 'jquery' ), '20160115', true );
	}
	/**
	 * OwlCarousel Library
	 */
	wp_enqueue_script( 'owl.carousel', get_template_directory_uri() . '/assets/js/owl-carousel/owl.carousel.min.js', array( 'jquery' ), '20160115', true );
	wp_enqueue_style( 'owl.carousel', get_template_directory_uri() . '/assets/js/owl-carousel/owl.carousel.min.css' );
	wp_enqueue_style( 'owl.carousel.theme', get_template_directory_uri() . '/assets/js/owl-carousel/owl.theme.default.css' );

	wp_enqueue_script( 'CNC-scripts', get_template_directory_uri() . '/assets/js/CNC-scripts.js', array( 'jquery', 'imagesloaded' ), '20160115', true );

}

add_action( 'wp_enqueue_scripts', 'CNC_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom nav walker
 */
require get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

/**
 * Load Social Navition
 */
require get_template_directory() . '/inc/socialnav.php';

/**
 * Load related posts
 */
require get_template_directory() . '/inc/class-CNC-related-posts.php';

/**
 * Load the CNC class
 */
require get_template_directory() . '/inc/class-CNC.php';

/**
 * Load the CNC page builder class
 */
require get_template_directory() . '/inc/class-CNC-builder.php';
CNC_Builder::get_instance();
