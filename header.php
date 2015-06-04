<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "principal" section.
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */
?>

<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		
		<!--[if lt IE 9]>
			<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js"></script>
		<![endif]-->
		
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<div id="page" class="container-fluid">
			
			<header id="header" role="banner">
				<nav class="navbar navbar-inverse">
					<div class="container">
						<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'issimple' ); ?>"><?php _e( 'Skip to content', 'issimple' ); ?></a>
						<hgroup id="brand" class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-menu-nav" aria-controls="navbar">
								<span class="sr-only"><?php _e( 'Click on the button to display the menu.', 'issimple' ); ?></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							
							<a id="logo-header" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
							
							<div id="head-txt">
								<?php if ( is_home() ) : ?>
									<h1 id="name"><a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<h2 id="desc" class="sub-title"><?php bloginfo( 'description' ); ?></h2>
								<?php else : ?>
									<p id="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></p>
									<p id="desc" class="sub-title"><?php bloginfo( 'description' ); ?></p>
								<?php endif; ?>
							</div><!-- #head-txt -->
						</hgroup><!-- #brand -->
						
						<?php
							wp_nav_menu( array(
								'theme_location'	=> 'header-menu',
								'container_id'		=> 'header-menu-nav',
								'menu_id'			=> 'header-menu'
							) );
							echo '<!-- #header-menu-nav -->';
						?>
						
					</div>
				</nav>
				
			</header><!-- #header -->
			
			<div id="main" class="container">
				<div class="row">
					<?php //get_slider(); ?>
					
					<?php get_sidebar(); ?>