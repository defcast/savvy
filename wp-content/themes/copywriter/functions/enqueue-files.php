<?php
/*
 * Enqueue css and js files
 */
function copywriter_enqueue() {
	/*----------------------css-----------------------*/
	wp_enqueue_style( 'copywriter-google-fonts-dosis', '//fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700,800', array(), '1.0.0' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/css/font-awesome.css', array(),'4.7.0');	
	wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/css/bootstrap.css', array(),'3.3.7');
	wp_enqueue_style( 'copywriter-custom-style', get_template_directory_uri().'/css/default.css', array());
	copywriter_dynamic_styles();
	
	/*----------------------end css-----------------------*/
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), '3.3.7', true );
	wp_enqueue_script( 'copywriter-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), '', true );
}
add_action( 'wp_enqueue_scripts', 'copywriter_enqueue' );