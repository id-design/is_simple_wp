<?php
/**
 * The template for displaying all single posts and attachments
 * 
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */

get_header();
?>

<div id="main">
	<div class="container-fluid">
		<div class="row">
			<div id="primary" class="<?php issimple_primary_class(); ?>">
				<main id="main-content" class="site-main" role="main">
				
					<?php
						// Start the Loop
						while ( have_posts() ) : the_post();
							
							/**
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );
							
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) comments_template();
							
							// Previous/next post navigation.
							issimple_post_navigation();
						
						// End the Loop
						endwhile;
					?>
					
				</main><!-- #main-content -->
			</div><!-- #primary -->

<?php
get_sidebar();

get_footer();
	


			
