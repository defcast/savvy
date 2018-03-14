<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section.
 *
 *
 * @package copywriter
 */ ?>
 <!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    
<header>
    <div class="scroll-header">  
        <div class="copywriter-container container"> 
            <div class="col-md-3 logo col-sm-12">
                <?php if (has_custom_logo()) { 
                       the_custom_logo();
                    } else { ?>
                    <a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                        <h2 class="site-title logo-box"><?php esc_html(bloginfo( 'name' )); ?></h2>
                        <span class="site-description"><?php esc_html(bloginfo( 'description' )); ?></span>
                    </a>
                <?php } ?>
            </div>
            <div class="col-md-9 center-content  ">
                <div class="menu-bar"> 
                    <div class="navbar-header res-nav-header toggle-respon">
                        <button type="button" class="navbar-toggle menu_toggle" data-toggle="collapse" data-target="#example-navbar-collapse">
                            <span class="sr-only"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse no-padding main-menu" id="example-navbar-collapse">
                    <?php
                        $copywriter_defaults = array(
                            'theme_location'  => 'primary',                            
                            'container'       => 'ul',
                            'menu_class'      => 'nav navbar-nav menu cwmenu-list',
                            'echo'            => true,
                            'depth'           => 0,                            
                        );                               
                            wp_nav_menu($copywriter_defaults);  ?>        
                    </div>        
                </div>
            </div>
        </div>
    </div>
</header>
<main class="main">    
    <?php if(is_page_template( 'template-parts/full-width.php')){ ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
    <?php    }else{  ?>
    <div class="col-md-3 col-sm-4 col-xs-12">
    <section class="single-left single-blog-sidebar">
       <?php dynamic_sidebar('main-sidebar'); ?>
    </section>
    </div>
    <div class="col-md-9 col-sm-8 col-xs-12">     
    <div class="main-content">
    <?php } ?>