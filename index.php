<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" lang="en-US">
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html lang="en-US">
<!--<![endif]-->
  <head>

      <title> Savvy Watch</title>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="/resources/css/fonts.css">
      <link rel="stylesheet" href="/resources/css/theme.css">
      <link rel="stylesheet" href="/resources/css/cnc.css">
      <link rel="stylesheet" href="/resources/css/cnc-icons.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="/resources/css/flexslider.css">
      <link rel="stylesheet" href="/resources/css/animate.min.css">
      <link rel="stylesheet" href="/resources/css/style.css">
      <link href="https://fonts.googleapis.com/css?family=Comfortaa:300|Dosis|Maven+Pro|Quicksand|Rajdhani" rel="stylesheet"> 

      <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
      <script src="/resources/js/modernizr-custom.js"></script>
      <script src="/resources/js/jquery.flexslider-min.js"></script>

      
      <script src="/resources/js/modernizr-custom.js"></script>
      <script src="/resources/js/jquery.flexslider-min.js"></script>
      <script src="/resources/js/cnc.js"></script>
  </head>
  <body>
    <a href="index.php">
      <object type="image/svg+xml" data="resources/img/cnc-live-svgo.svg">
        <img src="resources/img/cnc-live.png" alt="cnc technologies" />
      </object>
    </a>
    <ul>
      <li>
        <a href="live/">Live</a>
      </li>
      <li>
        <a href="map/">Map</a>
      </li>
      <li>
        <a href="videos/">Videos</a>
      </li>
      <li>
        <a href="photos/">Photos</a>
      </li>
      <li>
        <a href="help/">Help</a>
      </li>
      <li>
        <a href="upgrade/">Upgrade</a>
      </li>
    </ul>
    <hr>
    <?php
$indicesServer = array('PHP_SELF',
'argv',
'argc',
'GATEWAY_INTERFACE',
'SERVER_ADDR',
'SERVER_NAME',
'SERVER_SOFTWARE',
'SERVER_PROTOCOL',
'REQUEST_METHOD',
'REQUEST_TIME',
'REQUEST_TIME_FLOAT',
'QUERY_STRING',
'DOCUMENT_ROOT',
'HTTP_ACCEPT',
'HTTP_ACCEPT_CHARSET',
'HTTP_ACCEPT_ENCODING',
'HTTP_ACCEPT_LANGUAGE',
'HTTP_CONNECTION',
'HTTP_HOST',
'HTTP_REFERER',
'HTTP_USER_AGENT',
'HTTPS',
'REMOTE_ADDR',
'REMOTE_HOST',
'REMOTE_PORT',
'REMOTE_USER',
'REDIRECT_REMOTE_USER',
'SCRIPT_FILENAME',
'SERVER_ADMIN',
'SERVER_PORT',
'SERVER_SIGNATURE',
'PATH_TRANSLATED',
'SCRIPT_NAME',
'REQUEST_URI',
'PHP_AUTH_DIGEST',
'PHP_AUTH_USER',
'PHP_AUTH_PW',
'AUTH_TYPE',
'PATH_INFO',
'ORIG_PATH_INFO') ;

echo '<table cellpadding="10">' ;
foreach ($indicesServer as $arg) {
    if (isset($_SERVER[$arg])) {
        echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ;
    }
    else {
        echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ;
    }
}
echo '</table>' ; 
?>
    <div>
      <h1>CNC Live Video Management System</h1>
    </div>
  </body>
</html>