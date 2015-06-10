<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */
?>

<div id="secondary" class="col-sm-4 col-md-4 hidden-xs" role="complementary">
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
		
		<?php if ( is_active_sidebar( 'widget-area' ) ) : ?>
			<div class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'widget-area' ); ?>
			</div><!-- .widget-area -->
		<?php else : ?>
			<?php
				the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 10 ) );
				the_widget( 'WP_Widget_Archives', array( 'count' => 0, 'dropdown' => 1 ) );
				the_widget( 'WP_Widget_Tag_Cloud' );
			?>
		<?php endif; ?>
	</div><!-- #sidebar-content -->
</div><!-- #secondary -->