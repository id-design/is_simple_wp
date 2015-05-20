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
		
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<div id="page" class="site">
			
			<header id="header" class="container" role="banner">
				<div class="row">
					
					<hgroup id="brand" class="col_12">
						<a id="logo-header" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
						
						<div id="head-txt">
							<?php if ( is_home() || is_front_page() || is_archive() ) : ?>
								<h1 id="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php else : ?>
								<p id="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></p>
							<?php endif;
							
							$description = get_bloginfo( 'description', 'display' ); ?>
							<p id="desc" class="sub-title"><?php echo $description; ?></p>
						</div><!-- #head-txt -->
					</hgroup><!-- #brand -->
					
					<div id="toggle-container">
						<span class="screen-reader-text">
							<?php _e( 'Click on the button to display the menu.', 'viking-theme' ); ?>
						</span>
						<button id="toggle" type="button"><i class="fa fa-bars"></i></button>
					</div><!-- #toggle-container -->
					
				</div>
			</header><!-- #header -->
			
			<div id="main" class="container">
				<div class="row">
					<?php //get_slider(); ?>
					
					<?php get_sidebar(); ?>