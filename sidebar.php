<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */
?>

<div id="secondary" class="<?php issimple_secondary_class(); ?>" role="complementary">
	<div id="sidebar-content">
		<?php
			if ( has_nav_menu( 'social-menu' ) ) :
				wp_nav_menu( array(
					'theme_location'	=> 'social-menu',
					'container'			=> 'nav',
					'container_id'		=> 'social-menu-nav',
					'menu_id'			=> 'social-menu',
					'menu_class'		=> 'nav-menu',
					'depth'				=> 1,
					'link_before'		=> '<span class="sr-only">',
					'link_after'		=> '</span>'
				) );
				echo '<!-- #social-menu-nav -->';
			endif;
		?>
		
		
		<div id="sidebar-widget-area" class="widget-area" role="complementary">
			<?php
				if ( is_active_sidebar( 'sidebar-widget-area' ) ) :
					dynamic_sidebar( 'sidebar-widget-area' );
				else :
					the_widget( 'WP_Bootstrap_Recent_Posts', array( 'number' => 10 ), array(
						'before_widget'	=> '<aside class="widget panel panel-default widget_recent_entries">',
						'before_title'	=> '<div class="panel-heading"><h3 class="widget-title panel-title">',
						'after_title'	=> '</h3></div>',
						'after_widget'	=> '</aside>'
					) );
					the_widget( 'WP_Bootstrap_Archives', array( 'count' => 0 ), array(
						'before_widget'	=> '<aside class="widget panel panel-default widget_archive">',
						'before_title'	=> '<div class="panel-heading"><h3 class="widget-title panel-title">',
						'after_title'	=> '</h3></div>',
						'after_widget'	=> '</aside>'
					) );
					the_widget( 'WP_Bootstrap_Tag_Cloud', array(), array(
						'before_widget'	=> '<aside class="widget panel panel-default widget_tag_cloud">',
						'before_title'	=> '<div class="panel-heading"><h3 class="widget-title panel-title">',
						'after_title'	=> '</h3></div>',
						'after_widget'	=> '</aside>'
					) );
				endif;
			?>
		</div><!-- #sidebr-widget-area -->
	</div><!-- #sidebar-content -->
</div><!-- #secondary -->