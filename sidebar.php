<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */
?>

<div id="secondary" class="col-sm-4 col-md-4" role="complementary">
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
					'link_before'		=> '<span class="screen-reader-text">',
					'link_after'		=> '</span>'
				) );
				echo '<!-- #social-menu-nav -->';
			endif;
		?>
		
		<?php if ( is_active_sidebar( 'widget-area' ) ) : ?>
			<div class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'widget-area' ); ?>
			</div><!-- .widget-area -->
		<?php endif; ?>
	</div>
</div><!-- #secondary -->