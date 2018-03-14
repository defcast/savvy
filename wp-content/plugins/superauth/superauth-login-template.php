<?php
//echo 123;die;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define("SUPERAUTHURL", "https://www.superauth.com");

$redirect_to = home_url();

if(isset($_GET['token'])){
  $token = $_GET['token'];
  
  //echo '<h1>'.$token.'</h1>';
  $apiOpt = get_option( 'solid_sso_option' );
  if(isset($apiOpt['client_id']) && isset($apiOpt['client_secret'])) {
    
    $clientId = $apiOpt['client_id'];
    $clientSecret = $apiOpt['client_secret'];
    $url = SUPERAUTHURL . "/v1/getuserinfo?token={$token}&client_id={$clientId}&client_secret={$clientSecret}";
    // var_dump($url);
    $ch = curl_init();
    // Set query data here with the URL
    curl_setopt($ch, CURLOPT_URL, $url); 
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, '3');
    $resp = trim(curl_exec($ch));
    curl_close($ch);
  }
}

if(!empty($resp)) {
  $respArr = json_decode($resp,true);
  
  //print_r($respArr);die;
  
  
 
  if(isset($respArr['user'])) {
    $user_email = $respArr['user']['email'];
    $first_name = $respArr['user']['fname'];
    $last_name = $respArr['user']['lname'];
    $user_age = $respArr['user']['age'];

    $user_name = superauth_create_username(compact('first_name', 'last_name'));
    
    if ( email_exists($user_email) == false ) {
      //register user
      $user_pass = wp_generate_password( $length=12, $include_standard_special_chars=false );
      //$user_id = wp_create_user( $user_name, $user_pass, $user_email );
      
      $user_login = $user_name;
      $userdata = compact('user_login', 'user_email', 'user_pass', 'first_name', 'last_name');
			$user_id = wp_insert_user($userdata);
      if($user_id) {
        superauth_authenticate_user_by_id($user_id);
      }
    } else {
      //for login
      $user = get_user_by('email', $user_email );
      if ( !is_wp_error( $user ) ) {
        superauth_authenticate_user_by_id($user->ID);
      }      
    }
    
  }
}

wp_safe_redirect( $redirect_to );
exit();

function superauth_authenticate_user_by_id($userId) {
  wp_clear_auth_cookie();  
	$user = get_user_by( 'id', $userId ); 
	if( $user ) {
		wp_set_current_user( $userId, $user->user_login );
		wp_set_auth_cookie( $userId );
		do_action( 'wp_login', $user->user_login );
	}
  wp_safe_redirect(home_url());
  exit();
}


function superauth_create_username($data) {
    $fname = preg_replace('/[^a-z]/', "", strtolower($data['first_name']));  
    $lname =  preg_replace('/[^a-z]/', "", strtolower($data['last_name']));  

    $username = '';
    $last_char = 0;
    if($fname)
        $username .= $fname;
    if($lname)
        $username .= '_' . $lname;
        
    //echo '<div>FIRST: '.$username.'</div>';
    
    $username_to_check = $username;    
    while(username_exists($username_to_check)) {
        $last_char = $last_char + 1;
        $username_to_check = $username . $last_char; 	
    }
    
    return $username_to_check;
}

?>
