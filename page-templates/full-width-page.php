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

<?php
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

get_footer();