<?php
/**
* Plugin Name: SuperAuth
* Description: SuperAuth is a revolutionary application that enables your users to safely log in to your websites or apps without typing a username or password. You can easily add or remove SuperAuth function without disturbing your user management. SuperAuth also ensures that your site is secure and protected from phishing.
* Version: 1.1.1
* Author: SuperAuth
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class SuperAuthSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'SuperAuth', 
            'manage_options', 
            'my-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'solid_sso_option' );
        ?>
<div class="wrap">
  <h2>SuperAuth</h2>
  <form method="post" action="options.php">
    <?php
                // This prints out all hidden setting fields
                settings_fields( 'solid_sso_option_group' );   
                do_settings_sections( 'my-setting-admin' );
                submit_button(); 
            ?>
  </form>
</div>
<?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'solid_sso_option_group', // Option group
            'solid_sso_option', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'API Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );  

        add_settings_field(
            'client_id', // ID
            'Client Id', // Title 
            array( $this, 'id_number_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'client_secret', 
            'Client Secret', 
            array( $this, 'title_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['client_id'] ) )
            $new_input['client_id'] = sanitize_text_field( $input['client_id'] );

        if( isset( $input['client_secret'] ) )
            $new_input['client_secret'] = sanitize_text_field( $input['client_secret'] );
            
         //post
         superauth_plugin_activation();

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
	$returl = get_site_url();// $_SERVER['SERVER_NAME'];
        print 'Use the shortcode <code>[superauth]</code> to place the login button.<br><br>1. Login to <a href="https://superauth.com" target="_blank">superauth.com</a> and register your website under webapps to get api credentials.<br><br>2. Specify the return url as ' . $returl . '/superauth/ when registering webapps.<br><br>3. Enter your api credentials below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
        printf(
            '<input type="text" id="client_id" name="solid_sso_option[client_id]" value="%s" />',
            isset( $this->options['client_id'] ) ? esc_attr( $this->options['client_id']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="client_secret" name="solid_sso_option[client_secret]" value="%s" />',
            isset( $this->options['client_secret'] ) ? esc_attr( $this->options['client_secret']) : ''
        );
    }
}

//Setup Admin Interface
if( is_admin() ) {
    $my_settings_page = new SuperAuthSettingsPage();
}

//Auto create solid return url page on plugin activation
register_activation_hook( __FILE__, 'superauth_plugin_activation');
function superauth_plugin_activation() {
 //post status and options
  /*$post = array(
    'post_title' => 'SuperAuth Login',
    'post_name' => 'superauth',
    'post_content' => 'Do not delete.',
    'post_status' => 'publish',
    'post_author' => 1,
    'post_type' => 'page'
  );  
  //insert page and save the id
  $newvalue = wp_insert_post( $post, false );
  //save the id in the database
  update_option( 'hclpage', $newvalue );*/
  
  //insert or update
  $check_title=get_page_by_title('SuperAuth Login', 'OBJECT', 'page');

  //also var_dump($check_title) for testing only

  if (empty($check_title) ){
    $post = array(
      'post_title' => 'SuperAuth Login',
      'post_name' => 'superauth',
      'post_content' => 'Do not delete.',
      'post_status' => 'publish',
      'post_author' => 1,
      'post_type' => 'page'
    );  
    //insert page and save the id
    $newvalue = wp_insert_post( $post, false );
    //save the id in the database
    update_option( 'hclpage', $newvalue );
  }
  else {
    $post = array(
        'ID' =>  $check_title->ID,
        'post_title' => 'SuperAuth Login',
        'post_name' => 'superauth',
        'post_content' => 'Do not delete.',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'page'
    );
    $newvalue = wp_update_post( $post, false );
    update_option( 'hclpage', $newvalue );
  }

  
}

//Insert meta tag on html head
function do_head_insertion() {
  $apiOpt = get_option( 'solid_sso_option' );
  if(isset($apiOpt['client_id'])) {
    echo '<meta name="superauth-signin-client-id" content="'.$apiOpt['client_id'].'" />';
    //echo '<script src="https://cdn.superauth.com/jscript/platform.js" async defer></script>';
  }
}
add_action('wp_head', 'do_head_insertion');


//Custom page template
add_filter( 'page_template', 'superauth_execute_page_template' );
function superauth_execute_page_template( $page_template )
{
    if ( is_page( 'superauth' ) ) {
        $page_template = dirname( __FILE__ ) . '/superauth-login-template.php';
    }
    return $page_template;
}

//Make html type widget support shortcodes
add_filter('widget_text', 'do_shortcode');

//Solid shortcode
function superauth_authenticate_shortcode( $atts ) {
  if(is_user_logged_in()) {
    $current_user = wp_get_current_user();
    $displayName = $current_user->data->display_name;
    
    $display = '<div class="solid-greeting">Welcome <strong>'.$displayName.'</strong>! <em>(<a href="'.wp_logout_url( home_url() ).'">Logout</a>)</em></div>';
  } else {
    $display = '<div class="s-signin"></div>';
  }
  
  return $display;
}
add_shortcode('superauth', 'superauth_authenticate_shortcode');

//override wp-login.php logo
function superauth_new_login_logo() { 
    wp_enqueue_style('superauth', plugins_url( '/assets/css/style.css' , __FILE__ ));
}
add_action( 'login_enqueue_scripts', 'superauth_new_login_logo' );

add_action( 'login_form', 'superauth_login_form_override' );
add_action( 'register_form', 'superauth_login_form_override' );
function superauth_login_form_override() {
    $apiOpt = get_option( 'solid_sso_option' );
    if(isset($apiOpt['client_id'])) {
        //echo '<div id="customSuperAuthLogin"><h3>Superauth Login:</h3><div class="s-signin"></div></div>';
        echo '<div id="superauth-login-div"><h2><span>or</span></h2><div class="s-signin"></div><h2 style="margin:20px 0;"></h2></div>';
        echo '<meta name="superauth-signin-client-id" content="'.$apiOpt['client_id'].'" />';
        //echo '<script src="https://cdn.superauth.com/jscript/platform.js" async defer></script>';
    }
}

//async & defer filter
function superauth_add_defer_attribute($tag, $handle) {
   $scripts_to_defer = array('superauth');
   foreach($scripts_to_defer as $defer_script) {
      if ($defer_script !== $handle) return $tag;
      return str_replace(' src', ' defer="defer" src', $tag);
   }
   return $tag;
}
add_filter('script_loader_tag', 'superauth_add_defer_attribute', 10, 2);

function superauth_add_async_attribute($tag, $handle) {
   $scripts_to_async = array('superauth');
   foreach($scripts_to_async as $async_script) {
      if ($async_script !== $handle) return $tag;
      return str_replace(' src', ' async="async" src', $tag);
   }
   return $tag;
}
add_filter('script_loader_tag', 'superauth_add_async_attribute', 10, 2);

add_action( 'wp_enqueue_scripts', 'superauth_load_js_scripts');
add_action( 'login_enqueue_scripts', 'superauth_load_js_scripts');
function superauth_load_js_scripts() {
    wp_enqueue_script( 'superauth', 'https://cdn.superauth.com/jscript/platform.js' );    
}