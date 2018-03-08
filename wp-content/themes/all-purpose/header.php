<?php
/**
 * The Header template
 * @subpackage All Purpose
 */ 
 ?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">	
	<?php endif; ?>
	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'all-purpose' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="ap-black"></div>			
			<div class="nav-center">

				<nav id="site-navigation" class="main-navigation" role="navigation">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'all-purpose' ); ?></button>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
				</nav><!-- #site-navigation -->

			</div>

			<div class="site-branding">
						
				<?php if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php endif;

				$ap_description = get_bloginfo( 'description', 'display' );
				if ( $ap_description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $ap_description; /* WPCS: xss ok. */ ?></p>
			<?php endif;  ?>
							
			</div><!-- .site-branding -->
		
				
<!---------------- Deactivate Header Image ---------------->	
		
		<?php if (get_theme_mod('custom_header_position') != "deactivate" and has_header_image() !="") { ?>
		
<!---------------- All Pages Header Image ---------------->		
	
		<?php if ( get_theme_mod('custom_header_position') == "all" ) : ?>
		
		<div class="header-img" style="background-image: url('<?php header_image(); ?>');">	
		
			<?php if ( get_theme_mod('custom_header_overlay') == "on" ) { ?>
				<div class="dotted">
			<?php } ?>
				
				<?php if (get_theme_mod('header_title')) { ?>
					<div class="site-home">			
							<h1 class="aniview home-title" data-av-animation="zoomIn"><a href="<?php echo esc_url(get_theme_mod('header_title_link')); ?>"><?php echo esc_html(get_theme_mod('header_title')); ?></a></h1>
					</div><!-- .site-branding -->
				<?php } ?>
				
				<div id="home-buttons">
				
					<?php if (get_theme_mod('button_1')) { ?>	
						<a href="<?php echo esc_url(get_theme_mod('button_1_link')); ?>">
							<div class="aniview button-1" data-av-animation="slideInDown"><?php echo esc_html(get_theme_mod('button_1')); ?></div>
						</a>
					<?php } ?>
				
					<?php if (get_theme_mod('button_2')) { ?>	
						<a href="<?php echo esc_url(get_theme_mod('button_2_link')); ?>">
							<div class="aniview button-2" data-av-animation="slideInUp"><?php echo esc_html(get_theme_mod('button_2')); ?></div>
						</a>
					<?php } ?>	
					
				</div>
				
			<?php if ( get_theme_mod('custom_header_overlay') == "on" ) { ?>
				</div>
			<?php } ?>
			
		</div>
		
		<?php endif;  ?>
		
<!---------------- Home Page Header Image ---------------->
		
		<?php if ( ( is_front_page() || is_home() ) and get_theme_mod('custom_header_position') == "home" ) { ?>

		<div class="header-img" style="background-image: url('<?php header_image(); ?>');">	

			<?php if ( get_theme_mod('custom_header_overlay') == "on" ) { ?>
				<div class="dotted">
			<?php } ?>					

						<?php if (get_theme_mod('header_title')) { ?>
							<div class="site-home">			
									<h1 class="aniview home-title" data-av-animation="zoomIn"><a href="<?php echo esc_url(get_theme_mod('header_title_link')); ?>"><?php echo esc_html(get_theme_mod('header_title')); ?></a></h1>
							</div><!-- .site-branding -->
						<?php } ?>
						
						<div id="home-buttons">
						
							<?php if (get_theme_mod('button_1')) { ?>	
								<a href="<?php echo esc_url(get_theme_mod('button_1_link')); ?>">
									<div class="aniview button-1" data-av-animation="slideInDown"><?php echo esc_html(get_theme_mod('button_1')); ?></div>
								</a>
							<?php } ?>
						
							<?php if (get_theme_mod('button_2')) { ?>	
								<a href="<?php echo esc_url(get_theme_mod('button_2_link')); ?>">
									<div class="aniview button-2" data-av-animation="slideInUp"><?php echo esc_html(get_theme_mod('button_2')); ?></div>
								</a>
							<?php } ?>	
							
						</div>
						
				
			<?php if ( get_theme_mod('custom_header_overlay') == "on" ) { ?>
				</div>
			<?php } ?>					
		</div>
		
	<?php } 

	} ?> 

<!---------------- Default Header Image ---------------->

		<?php if ( get_theme_mod('custom_header_position') != "deactivate" and has_header_image() !="") { ?>
		
		<?php if ( get_theme_mod('custom_header_position') != "all") { ?>

		<?php if ( ( is_front_page() or is_home() ) and get_theme_mod('custom_header_position') != "home" ) { ?>

		<div class="header-img" style="background-image: url('<?php echo get_template_directory_uri(). "/framework/images/header.jpg"; ?>');">	

			<?php if ( get_theme_mod('custom_header_overlay') == "on" ) { ?>
				<div class="dotted">
			<?php } ?>	
			
							<div class="site-home">			
									<h1 class="aniview home-title" data-av-animation="zoomIn"><a href="<?php echo esc_url(get_theme_mod('header_title_link')); ?>"><?php if (get_theme_mod('header_title')) : echo esc_html(get_theme_mod('header_title')); else : bloginfo( 'name' ); endif; ?></a></h1>
							</div><!-- .site-branding -->
						
						
						<div id="home-buttons">
							<?php if (get_theme_mod('button_1')) : ?>
								<a href="<?php echo esc_url(get_theme_mod('button_1_link')); ?>">
									<div class="aniview button-1" data-av-animation="slideInDown"><?php echo esc_html(get_theme_mod('button_1')); ?></div>
								</a>
							<?php endif; ?>
							<?php if (get_theme_mod('button_2')) : ?>							
								<a href="<?php echo esc_url(get_theme_mod('button_2_link')); ?>">
									<div class="aniview button-2" data-av-animation="slideInUp"><?php echo esc_html(get_theme_mod('button_2')); ?></div>
								</a>
							<?php endif; ?>
						</div>
				
			<?php if ( get_theme_mod('custom_header_overlay') == "on" ) { ?>
				</div>
			<?php } ?>	
							
		</div>
		
		<?php } } } ?>
	
	</header><!-- #masthead -->
		
	<div class="clear"></div>
	
	<div id="content" class="site-content">