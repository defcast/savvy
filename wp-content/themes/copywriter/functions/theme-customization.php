<?php
/**
* Customization options
**/
function copywriter_sanitize_select( $input, $setting ) {
    
  // Ensure input is a slug.
  $input = sanitize_key( $input );

  // Get list of choices from the control associated with the setting.
  $choices = $setting->manager->get_control( $setting->id )->choices;

  // If the input is a valid key, return it; otherwise, return the default.
  return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
function copywriter_customize_register( $wp_customize ) {
  /*-----------color option-----------*/
  $wp_customize->add_setting(
      'theme_color',
      array(
          'default' => '#153143',
          'capability'     => 'edit_theme_options',
          'sanitize_callback' => 'sanitize_hex_color',
      )
  );
  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'theme_color',
      array(
          'label'      => esc_html__('Theme Color ', 'copywriter'),
          'section' => 'colors',
          'priority' => 10
      )
    )
  );
  $wp_customize->add_setting(
      'secondary_color',
      array(
          'default' => '#C03221',
          'capability'     => 'edit_theme_options',
          'sanitize_callback' => 'sanitize_hex_color',
      )
  );
  $wp_customize->add_control(
    new WP_Customize_Color_Control(
      $wp_customize,
      'secondary_color',
      array(
          'label'      => esc_html__('Secondary Color ', 'copywriter'),
          'section' => 'colors',
          'priority' => 10
      )
    )
  );
  /*---------------end-------------------*/
  /*--------------start footer-----------------------*/
  $wp_customize->add_panel(
    'footer',
    array(
      'title' => esc_html__( 'Footer','copywriter' ),
      'description' => esc_html__('layout options', 'copywriter'), 
      'priority' => 45,
    )
  );
  /* Content Widget Layout */
  $wp_customize->add_section(
    'footer_copyrights_section',
    array(
      'title' => esc_html__('Footer Copyrights Section','copywriter'),
      'panel' => 'footer'
    )
  );
  $wp_customize->add_section(
    'footer_socials',
    array(
      'title' => esc_html__('Social Accounts','copywriter'),
      'description' => __( 'In first input box, you need to add Font Awesome class which you can find <a target="_blank" href="https://fontawesome.bootstrapcheatsheets.com/">here</a> For Example (<b>fa-facebook</b>) and in second input box, you need to add your social media profile URL.<br /> Leave it empty to hide the icon.' , 'copywriter'),
      'panel' => 'footer'
    )
  );
  
  //adding setting for footer text area
  $wp_customize->add_setting('footer_copyrights',
    array(
      'sanitize_callback' => 'wp_kses',
    )
  );
  $wp_customize->add_control('footer_copyrights',
    array(
      'label'   => esc_html__('Footer Copy Rights','copywriter'),
      'section' => 'footer_copyrights_section',
      'type'    => 'textarea',
    )
  );
  /*--------------Blog page-------------*/
  $wp_customize->add_panel(
    'blogpage_setting',
    array(
        'title' => esc_html__( 'Blog Page Settings', 'copywriter' ),
        'description' => esc_html__('Blog Page options','copywriter'),
        'priority' => 41
    )
    );
  $wp_customize->add_section( 'copywriter_hide_meta_data' , array(
        'title'       => esc_html__( 'Hide Meta Data', 'copywriter' ),
        'capability'     => 'edit_theme_options',
        'panel' => 'blogpage_setting'
    ) );
    $wp_customize->add_setting(
        'copywriter_hide_meta',
        array(
            'default' => 1,
            'capability'     => 'edit_theme_options',
            'sanitize_callback' => 'copywriter_sanitize_select',
            'priority' => 20, 
        )
    );
    $wp_customize->add_control(
        'copywriter_hide_meta',
        array(
          'section' => 'copywriter_hide_meta_data',                
          'label'   => esc_html__('Hide Meta Data','copywriter'),
          'type'    => 'select',
          'choices'        => array(
            "1"   => esc_html__( "Show", 'copywriter' ),
            "0"   => esc_html__( "Hide", 'copywriter' ),
          ),
        )
    );
  /*------------end blog page---------*/
  $wp_customize->add_setting('social_icon_area', array(
        'default' => false,  
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('social_icon_area', array(
        'label'   => esc_html__('Show Social Icon Area','copywriter'),
        'section' => 'footer_socials',
        'type'    => 'checkbox',
        'priority' => 1
    ));
  /* End Content Widget Layout */
  $copywriter_social_icon = array();
  for($i=1;$i <= 5;$i++):
  $copywriter_social_icon[] =  array( 'slug'=>sprintf('copywriter_social_icon%d',$i),
   'default' => '',
   'label' => sprintf(esc_html__( 'Social Account %s', 'copywriter' ),$i),
   'priority' => sprintf('%d',$i) );
  endfor;
  foreach($copywriter_social_icon as $copywriter_social_icons){
    $wp_customize->add_setting(
      $copywriter_social_icons['slug'],
      array(
        'default' => '',
        'capability'     => 'edit_theme_options',
        'type' => 'theme_mod',
        'sanitize_callback' => 'sanitize_text_field',
      )
    );
    $wp_customize->add_control(
      $copywriter_social_icons['slug'],
      array(
        'type'  => 'text',
        'section' => 'footer_socials',
        'input_attrs' => array( 'placeholder' => esc_attr__('Enter Icon','copywriter') ),
        'label'      =>   $copywriter_social_icons['label'],
        'priority' => $copywriter_social_icons['priority']
      )
    );
  }
  $copywriter_social_icon_link = array();
  for($i=1;$i <= 5;$i++):
  $copywriter_social_icon_link[] =  array( 'slug'=>sprintf('copywriter_social_icon_link%d',$i),
   'default' => '',
   'label' => sprintf(esc_html__( 'Social Link %s', 'copywriter' ),$i),
   'priority' => sprintf('%d',$i) );
  endfor;
  foreach($copywriter_social_icon_link as $copywriter_social_icons){
    $wp_customize->add_setting(
      $copywriter_social_icons['slug'],
      array(
        'default' => '',
        'capability'     => 'edit_theme_options',
        'type' => 'theme_mod',
        'sanitize_callback' => 'esc_url_raw',
      )
    );
    $wp_customize->add_control(
      $copywriter_social_icons['slug'],
      array(
        'type'  => 'text',
        'section' => 'footer_socials',
        'priority' => $copywriter_social_icons['priority'],
        'input_attrs' => array( 'placeholder' => esc_html__('Enter URL','copywriter')),
      )
    );
  }
}
add_action( 'customize_register', 'copywriter_customize_register' );
/**
 * Add Dynamic styling from theme
 */
function copywriter_dynamic_styles() {
      wp_enqueue_style( 'copywriter-style', get_stylesheet_uri() );
      
      $custom_css='';
      $custom_css .= "body,.post .post-preview p, .single-blog-sidebar ul li a:hover, .meta a:hover,.read-more a:hover,.comment-form .logged-in-as a:hover, .comment-metadata a:hover, .comment-area .reply a:hover{ color: ".esc_attr(get_theme_mod('secondary_color','#C03221'))."; }
    h1, h2, h3, h4, h5, h6,.post .post-preview h2 a, .single-blog-sidebar aside h4,.single-blog-sidebar .icon-bar{ color: ".esc_attr(get_theme_mod('theme_color','#153143'))."; }
    .button, button, input[type='button'], input[type='reset'], input[type='submit'],.main .page-numbers.current, .main a.page-numbers:hover,.tagcloud a, .scroll-header{ background-color: ".esc_attr(get_theme_mod('theme_color','#153143')).";border: 1px solid ".esc_attr(get_theme_mod('theme_color','#153143'))."; }
    .button:focus, .button:hover, button:focus, button:hover, input[type='button']:focus, input[type='button']:hover, input[type='reset']:focus, input[type='reset']:hover, input[type='submit']:focus, input[type='submit']:hover,.main .page-numbers,.main a.page-numbers,.tagcloud a:hover,.single-blog-sidebar{ border-color: ".esc_attr(get_theme_mod('theme_color','#153143'))."; color: ".esc_attr(get_theme_mod('theme_color','#153143'))."; }
    .footer-area, .cwmenu-list li a:before{ background-color: ".esc_attr(get_theme_mod('secondary_color','#C03221'))."; }
    .single-blog-sidebar  ul li a, .read-more a, .meta a,.comment-form .logged-in-as a,.link-spacer:before, .comment-metadata a, .comment-area .reply a,.comment-author b{ color: ".esc_attr(get_theme_mod('theme_color','#153143')).";}
    .nav>li>a:focus, .nav>li>a:hover, .hvr-underline-from-left:before,.cwmenu-list ul li a:link{background-color: ".esc_attr(get_theme_mod('theme_color','#153143')).";}
    .sub-nav, .sub-nav a.active, .comment-area .reply a{color: ".esc_attr(get_theme_mod('theme_color','#153143'))."; border-color: ".esc_attr(get_theme_mod('theme_color','#153143')).";}
    .single-blog-sidebar aside h4{ border-color: ".esc_attr(get_theme_mod('secondary_color','#c03221')).";}
    .cwmenu-list ul.sub-menu li a:link{background-color: ".esc_attr(get_theme_mod('theme_color','#153143')).";border-color: ".esc_attr(get_theme_mod('theme_color','#153143')).";}";
    
    wp_add_inline_style( 'copywriter-style', $custom_css );
}