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
		
		<nav id="fixed-nav-header" class="navbar navbar-inverse navbar-fixed-top">
			<header id="header" class="container-fluid" role="banner">
				<a class="screen-reader-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'issimple' ); ?>"><?php _e( 'Skip to content', 'issimple' ); ?></a>
				<hgroup id="brand" class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-menu-nav" aria-controls="navbar">
						<span class="sr-only"><?php _e( 'Click on the button to display the menu.', 'issimple' ); ?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					
					<a id="logo-header" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					
					<div id="header-txt">
						<?php if ( is_home() || is_front_page() ) : ?>
							<h1 id="name"><a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<h2 id="desc" class="screen-reader-text"><?php bloginfo( 'description' ); ?></h2>
						<?php else : ?>
							<p id="name" class="h1"><a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></p>
							<p id="desc" class="h2 screen-reader-text"><?php bloginfo( 'description' ); ?></p>
						<?php endif; ?>
					</div><!-- #head-txt -->
				</hgroup><!-- #brand -->
				
				<div id="header-menu-nav" class="collapse navbar-collapse">
					<?php
						wp_nav_menu( array(
							'theme_location'	=> 'header-menu',
							'container'			=> false,
							'menu_id'			=> 'header-menu',
							'menu_class'		=> 'nav navbar-nav',
							'depth'				=> 2,
							'fallback_cb'		=> 'ISSimple_WP_Bootstrap_Nav_Walker::fallback',
							'walker'			=> new ISSimple_WP_Bootstrap_Nav_Walker()
						) );
						echo '<!-- #header-menu-nav -->';
						
						get_search_form();
					?>
				</div>
			
			</header><!-- #header -->
		</nav><!-- #fixed-nav-header -->
		
		<div id="main" class="container-fluid">
			<div class="row">
				<?php //get_slider(); ?>