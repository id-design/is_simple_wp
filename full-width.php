<?php
/**
 * Template Name: Full Width Page
 *
 * Learn more: {@link https://developer.wordpress.org/themes/basics/page-templates/}
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */

get_header();
?>

<?php if ( is_home() || is_front_page() || is_archive() ) : ?>
	<header id="page-header" class="col-sm-12 col-md-12">
		<h1 id="page-title"><?php _e( 'Latest Posts', 'issimple' ); ?></h1>
	</header><!-- #page-header -->
<?php endif; ?>

<div id="primary" class="<?php issimple_primary_class(); ?>">
	<main id="main-content" class="site-main" role="main">
	
		<?php
			if ( have_posts() ) :
				// Start the Loop
				while ( have_posts() ) : the_post();
					
					/**
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				
				// End the Loop
				endwhile;
				
				// Post pagination
				issimple_post_pagination();
				
			else:
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );
				
			endif;
		?>
		
	</main>
</div><!-- #primary -->

<?php
//get_sidebar();

get_footer();