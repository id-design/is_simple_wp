<?php
/**
 * The template for displaying pages
 * 
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */

get_header();

// Start the Loop
while ( have_posts() ) : the_post(); ?>
	
	<?php issimple_page_header(); ?>

	<div id="main">
		<div class="container-fluid">
			<div class="row">
				<div id="primary" class="<?php issimple_primary_class(); ?>">
					<main id="main-content" class="site-main" role="main">
					
						<?php
							// Include the page content template.
							get_template_part( 'content', 'page' );
							
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) comments_template();
						?>
						
					</main><!-- #main-content -->
				</div><!-- #primary -->

<?php
// End the Loop
endwhile;

get_sidebar();

get_footer();