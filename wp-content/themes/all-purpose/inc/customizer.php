<?php
/**
 * All Purpose Theme Customizer
 *
 * @package All Purpose
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function all_purpose_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	$wp_customize->add_section( 'default_post_image' , array(
		'title'      => __('Default Post Image','all-purpose'),
		'priority'   => 30,
	) );	

	
    $wp_customize->add_setting(
        'no_post_img',
        array(
            'default'    => 'default',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'all_purpose_sanitize_no_img',			
        )
    );

    $wp_customize->add_control(
        'no_post_img',
        array(
            'settings' => 'no_post_img',	
			'priority'    => 1,
            'label'    => __( 'Activate Default Image:', 'all-purpose' ),
            'section'  => 'default_post_image',
            'type'     => 'select',
            'choices'  => array(
                'hide' => __( 'Hide Default Post Image', 'all-purpose' ),
                'default' => __( 'Activate Default Post Image', 'all-purpose' ),
            ),
			'default'    => 'default'
        )
    );	
	
    $wp_customize->add_setting(
        'no_cube_animation',
        array(
            'default'    => 'default',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'all_purpose_sanitize_no_animation',			
        )
    );

    $wp_customize->add_control(
        'no_cube_animation',
        array(
            'settings' => 'no_cube_animation',	
			'priority'    => 1,
            'label'    => __( 'Deactivate Cube Animation:', 'all-purpose' ),
            'section'  => 'default_post_image',
            'type'     => 'select',
            'choices'  => array(
                'hide' => __( 'Deactivate', 'all-purpose' ),
                'default' => __( 'Activate', 'all-purpose' ),
            ),
			'default'    => 'default'
        )
    );
	
}
add_action( 'customize_register', 'all_purpose_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function all_purpose_customize_preview_js() {
	wp_enqueue_script( 'all_purpose_customizer', get_template_directory_uri() . '/framework/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'all_purpose_customize_preview_js' );

function all_purpose_sanitize_no_img( $input ) {
	$valid = array(
        'hide' => __( 'Hide Default Post Image', 'all-purpose' ),
        'default' => __( 'Activate Default Post Image', 'all-purpose' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

function all_purpose_sanitize_no_animation( $input ) {
	$valid = array(
        'hide' => __( 'Deactivate', 'all-purpose' ),
        'default' => __( 'Activate', 'all-purpose' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

function all_purpose_cube_animation () { ?>
	
	<style>
		<?php if (get_theme_mod('no_cube_animation') == "hide") { ?>

		.app-basic:hover .app-transform-front {
			-webkit-transform: none !important;
			-moz-transform: none !important;
			-o-transform: none !important;
			-ms-transform: none !important;
			transform: none !important;
			opacity: 1 !important;
		}

		.app-basic:hover .app-transform-back {
			-webkit-transform: none !important;
			-moz-transform: none !important;
			-o-transform: none !important;
			-ms-transform: none !important;
			transform: none !important;
			opacity: 0 !important;
		}
		
		.app-basic:hover {
			opacity: 0.8;
			
		}
		<?php } ?>
	</style>
	
<?php } add_action('wp_head','all_purpose_cube_animation');

/***********************************************************************************
 * Premium Section
***********************************************************************************/

		function all_purpose_support($wp_customize){
			class all_purpose_Customize extends WP_Customize_Control {
				public function render_content() { ?>
				<div class="all_purpose-info"> 
						<a href="<?php echo esc_url( 'https://seosthemes.com/free-wordpress-all-purpose-theme/' ); ?>" title="<?php esc_attr_e( 'All-Purpose Pro', 'all-purpose' ); ?>" target="_blank">
						<strong><?php _e( 'All-Purpose with a lot new features.', 'all-purpose' ); ?></strong>
						</a>
					
					<br />
					<br />
					<a style="color: #fff; text-decoration: none;" href="<?php echo esc_url( 'https://seosthemes.com/free-wordpress-all-purpose-theme/' ); ?>" title="<?php esc_attr_e( 'All-Purpose Pro', 'all-purpose' ); ?>" target="_blank">
						<img class="sb-demo" src="<?php echo get_template_directory_uri() . '/framework/images/premium.jpg'; ?>"/>	
					</a>
				</div>
				<?php
				}
			}
		}
		add_action('customize_register', 'all_purpose_support');

		function customize_styles_all_purpose( $input ) { ?>
			<style type="text/css">
				#customize-theme-controls #accordion-panel-all_purpose_buy_panel .accordion-section-title,
				#customize-theme-controls #accordion-panel-all_purpose_buy_panel > .accordion-section-title {
					background: #555555;
					color: #FFFFFF;
				}

				.all_purpose-info button a {
					color: #FFFFFF; 
				}	
			</style>
		<?php }
		
		add_action( 'customize_controls_print_styles', 'customize_styles_all_purpose');

		if ( ! function_exists( 'all_purpose_buy' ) ) :
			function all_purpose_buy( $wp_customize ) {
				
				
			$wp_customize->add_panel( 'all_purpose_buy_panel', array(
				'title'			=> __('All-Purpose Pro', 'all-purpose'),
				'description'	=> __('	Learn more about All-Purpose. ','all-purpose'),
				'priority'		=> 3,
			));				
/****************************
Theme Options
****************************/				
			$wp_customize->add_section( 'all_purpose_buy_section', array(
				'title'			=> __('All-Purpose Pro Theme Options', 'all-purpose'),
				'panel'         => 'all_purpose_buy_panel',
				'description'	=> __('	Learn more about All-Purpose. ','all-purpose'),
				'priority'		=> 3,
			));
			
			$wp_customize->add_setting( 'all_purpose_setting', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new all_purpose_Customize(
					$wp_customize,'all_purpose_setting', array(
						'label'		=> __('All-Purpose Pro Theme Options', 'all-purpose'),
						'section'	=> 'all_purpose_buy_section',
						'settings'	=> 'all_purpose_setting',
					)
				)
			);
			
/****************************
Slider
****************************/

			$wp_customize->add_section( 'all_purpose_buy_section1', array(
				'title'			=> __('Slider', 'all-purpose'),
				'panel'         => 'all_purpose_buy_panel',
				'description'	=> __('<a target="_blank" href="https://seosthemes.com/free-wordpress-all-purpose-theme/">Buy All-Purpose Pro - €39.99</a> <br /><br />
				<a target="_blank" href="https://seosthemes.info/all-purpose-free-wordpress-theme/">All-Purpose Pro Demo</a> ','all-purpose'),
				'priority'		=> 3,
			));
			
			$wp_customize->add_setting( 'all_purpose_slider', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,'all_purpose_slider', array(
						'type'		=> 'radio',
						'section'	=> 'all_purpose_buy_section1',
						'settings'	=> 'all_purpose_slider',
					)
				)
			);
								
/****************************
Slider
****************************/

			$wp_customize->add_section( 'all_purpose_buy_section2', array(
				'title'			=> __('Custom CSS', 'all-purpose'),
				'panel'         => 'all_purpose_buy_panel',
				'description'	=> __('<a target="_blank" href="https://seosthemes.com/free-wordpress-all-purpose-theme/">Buy All-Purpose Pro - €39.99</a> <br /><br />
				<a target="_blank" href="https://seosthemes.info/all-purpose-free-wordpress-theme/">All-Purpose Pro Demo</a> ','all-purpose'),
				'priority'		=> 3,
			));
			
			$wp_customize->add_setting( 'all_purpose_panel_2', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,'all_purpose_panel_2', array(
						'type'		=> 'radio',
						'section'	=> 'all_purpose_buy_section2',
						'settings'	=> 'all_purpose_panel_2',
					)
				)
			);
												
/****************************
Disable All Comments
****************************/

			$wp_customize->add_section( 'all_purpose_buy_section3', array(
				'title'			=> __('Disable All Comments', 'all-purpose'),
				'panel'         => 'all_purpose_buy_panel',
				'description'	=> __('<a target="_blank" href="https://seosthemes.com/free-wordpress-all-purpose-theme/">Buy All-Purpose Pro - €39.99</a> <br /><br />
				<a target="_blank" href="https://seosthemes.info/all-purpose-free-wordpress-theme/">All-Purpose Pro Demo</a> ','all-purpose'),
				'priority'		=> 3,
			));
			
			$wp_customize->add_setting( 'all_purpose_panel_3', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,'all_purpose_panel_3', array(
						'type'		=> 'radio',
						'section'	=> 'all_purpose_buy_section3',
						'settings'	=> 'all_purpose_panel_3',
					)
				)
			);
						
												
/****************************
Disable Meta
****************************/

			$wp_customize->add_section( 'all_purpose_buy_section4', array(
				'title'			=> __('Disable Meta', 'all-purpose'),
				'panel'         => 'all_purpose_buy_panel',
				'description'	=> __('<a target="_blank" href="https://seosthemes.com/free-wordpress-all-purpose-theme/">Buy All-Purpose Pro - €39.99</a> <br /><br />
				<a target="_blank" href="https://seosthemes.info/all-purpose-free-wordpress-theme/">All-Purpose Pro Demo</a> ','all-purpose'),
				'priority'		=> 3,
			));
			
			$wp_customize->add_setting( 'all_purpose_panel_4', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,'all_purpose_panel_4', array(
						'type'		=> 'radio',
						'section'	=> 'all_purpose_buy_section4',
						'settings'	=> 'all_purpose_panel_4',
					)
				)
			);
										
												
/****************************
Disable Titles
****************************/

			$wp_customize->add_section( 'all_purpose_buy_section5', array(
				'title'			=> __('Disable Titles', 'all-purpose'),
				'panel'         => 'all_purpose_buy_panel',
				'description'	=> __('<a target="_blank" href="https://seosthemes.com/free-wordpress-all-purpose-theme/">Buy All-Purpose Pro - €39.99</a> <br /><br />
				<a target="_blank" href="https://seosthemes.info/all-purpose-free-wordpress-theme/">All-Purpose Pro Demo</a> ','all-purpose'),
				'priority'		=> 3,
			));
			
			$wp_customize->add_setting( 'all_purpose_panel_5', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,'all_purpose_panel_5', array(
						'type'		=> 'radio',
						'section'	=> 'all_purpose_buy_section5',
						'settings'	=> 'all_purpose_panel_5',
					)
				)
			);
			
		}
		endif;
		 
		add_action('customize_register', 'all_purpose_buy');
		
		function all_purpose_customize_support( $input ) { ?>
			<style type="text/css">
				#customize-theme-controls #accordion-section-all_purpose_buy_section .accordion-section-title:after,
				#customize-theme-controls #accordion-section-all_purpose_buy_section1 .accordion-section-title:after,
				#customize-theme-controls #accordion-section-all_purpose_buy_section2 .accordion-section-title:after,
				#customize-theme-controls #accordion-section-all_purpose_buy_section3 .accordion-section-title:after,
				#customize-theme-controls #accordion-section-all_purpose_buy_section4 .accordion-section-title:after,
				#customize-theme-controls #accordion-section-all_purpose_buy_section5 .accordion-section-title:after {
					font-size: 13px;
					font-weight: bold;
					content: "Premium";
					float: right;
					right: 40px;
					position: relative;
					color: #FF0000;
				}
			</style>
		<?php }
add_action( 'customize_controls_print_styles', 'all_purpose_customize_support');