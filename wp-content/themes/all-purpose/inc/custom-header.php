<?php if( ! defined( 'ABSPATH' ) ) exit;
/**
 * Sample implementation of the Custom Header feature.
 *
 */
function all_purpose_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'all_purpose_custom_header_args', array(
		'default-image' => get_template_directory_uri() . '/framework/images/header.jpg',	
		'default-text-color'     => 'fff',
		'width'                  => 1300,
		'height'                 => 800,
		'flex-height'            => true,
		'flex-width'            => true,
		'wp-head-callback'       => 'all_purpose_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'all_purpose_custom_header_setup' );

register_default_headers( array(
	'yourimg' => array(
	'url' => get_template_directory_uri() . '/framework/images/header.jpg',
	'thumbnail_url' => get_template_directory_uri() . '/framework/images/header.jpg',
	'description' => _x( 'Default Image', 'header image description', 'all-purpose' )),
));

if ( ! function_exists( 'all_purpose_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see all_purpose_custom_header_setup().
 */
function all_purpose_header_style() {
	$all_purpose_header_text_color = get_header_textcolor();

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
		<?php
			// Has the text been hidden?
			if ( ! display_header_text() ) :
		?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
			.site-title,
			.site-description {
				display: none !important;
			}
		<?php
			// If the user has set a custom color for the text use that.
			else :
		?>
			header .site-branding .site-title a, header .header-img .site-title a, header .header-img .site-description,
			header  .site-branding .site-description {
				color: #<?php echo esc_attr( $all_purpose_header_text_color ); ?>;
			}
		<?php endif; ?>
	</style>
	<?php
}
endif;

/**
 * Custom Header Options
 */

add_action( 'customize_register', 'all_purpose_customize_custom_header_meta' );

function all_purpose_customize_custom_header_meta($wp_customize ) {
	
    $wp_customize->add_setting(
        'custom_header_position',
        array(
            'default'    => 'default',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'all_purpose_sanitize_select',			
        )
    );

    $wp_customize->add_control(
        'custom_header_position',
        array(
            'settings' => 'custom_header_position',	
			'priority'    => 1,
            'label'    => __( 'Activate Header Image:', 'all-purpose' ),
            'section'  => 'header_image',
            'type'     => 'select',
            'choices'  => array(
                'deactivate' => __( 'Deactivate Header Image', 'all-purpose' ),
                'default' => __( 'Default Image', 'all-purpose' ),
                'all' => __( 'All Pages', 'all-purpose' ),
                'home'  => __( 'Home Page', 'all-purpose' )
            ),
			'default'    => 'deactivate'
        )
    );
	
    $wp_customize->add_setting(
        'custom_header_overlay',
        array(
            'default'    => '',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'all_purpose_sanitize_overlay',			
        )
    );

    $wp_customize->add_control(
        'custom_header_overlay',
        array(
            'settings' => 'custom_header_overlay',
			'priority'    => 1,			
            'label'    => __( 'Hide Overlay:', 'all-purpose' ),
            'section'  => 'header_image',
            'type'     => 'select',
            'choices'  => array(
                'on' => __( 'Show Overlay', 'all-purpose' ),
                ''  => __( 'Hide Overlay', 'all-purpose' )
            ),
			'default'    => ''
        )
    );
	
    $wp_customize->add_setting(
        'header_title',
        array(
            'default'    => '',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',			
        )
    );

    $wp_customize->add_control(
        'header_title',
        array(
            'settings' => 'header_title',
			'priority'    => 1,			
            'label'    => __( 'Header Title:', 'all-purpose' ),
            'section'  => 'header_image',
            'type'     => 'text',
        )
    );

		
    $wp_customize->add_setting(
        'header_title_link',
        array(
            'default'    => '',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',			
        )
    );

    $wp_customize->add_control(
        'header_title_link',
        array(
            'settings' => 'header_title_link',
			'priority'    => 1,			
            'label'    => __( 'Header Title Link:', 'all-purpose' ),
            'section'  => 'header_image',
            'type'     => 'url',
        )
    );

	
    $wp_customize->add_setting(
        'button_1',
        array(
            'default'    => '',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',			
        )
    );

    $wp_customize->add_control(
        'button_1',
        array(
            'settings' => 'button_1',
			'priority'    => 1,			
            'label'    => __( 'Button 1:', 'all-purpose' ),
            'section'  => 'header_image',
            'type'     => 'text',
        )
    );	

	
    $wp_customize->add_setting(
        'button_1_link',
        array(
            'default'    => '',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',			
        )
    );

    $wp_customize->add_control(
        'button_1_link',
        array(
            'settings' => 'button_1_link',
			'priority'    => 1,			
            'label'    => __( 'Button 1 Link:', 'all-purpose' ),
            'section'  => 'header_image',
            'type'     => 'url',
        )
    );
	
    $wp_customize->add_setting(
        'button_2',
        array(
            'default'    => '',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',			
        )
    );

    $wp_customize->add_control(
        'button_2',
        array(
            'settings' => 'button_2',
			'priority'    => 1,			
            'label'    => __( 'Button 2:', 'all-purpose' ),
            'section'  => 'header_image',
            'type'     => 'text',
        )
    );	

    $wp_customize->add_setting(
        'button_2_link',
        array(
            'default'    => '',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',			
        )
    );

    $wp_customize->add_control(
        'button_2_link',
        array(
            'settings' => 'button_2_link',
			'priority'    => 1,			
            'label'    => __( 'Button 2 Link:', 'all-purpose' ),
            'section'  => 'header_image',
            'type'     => 'url',
        )
    );

	$wp_customize->add_setting( 'header_height', array(
		'default' => '',
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'header_height', array(
		'type' => 'number',
		'priority' => 1,
		'section' => 'header_image',
		'label' => __( 'Custom Height', 'all-purpose' ),
		'description' => __( 'Min-height 40vw. Max-height 100vw.', 'all-purpose' ),
		'input_attrs' => array(
			'min' => 40,
			'max' => 100,
			'step' => 1,
		),
	) );
	
}

function all_purpose_customize_css () { ?>
	<style>
		<?php if(get_theme_mod('header_height')) { ?> .header-img { height: <?php echo esc_attr(get_theme_mod('header_height')); ?>vw; } <?php } ?>
	</style>
<?php	
}

add_action('wp_head','all_purpose_customize_css');


function all_purpose_sanitize_select( $input ) {
	$valid = array(
                'deactivate' => __( 'Deactivate Header Image', 'all-purpose' ),
                'default' => __( 'Default Image', 'all-purpose' ),
                'all' => __( 'All Pages', 'all-purpose' ),
                'home'  => __( 'Home Page', 'all-purpose' )
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

function all_purpose_sanitize_overlay( $input ) {
	$valid = array(
        'on' => __( 'Show Overlay', 'all-purpose' ),
        ''  => __( 'Hide Overlay', 'all-purpose' )
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}