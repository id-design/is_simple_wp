<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */

get_header();
?>
	
<main id="principal" class="col_8" role="main">

	<header id="page-header">
		<h1 id="page-title"><?php _e( 'Latest Posts', 'viking-theme' ); ?></h1>
	</header><!-- #page-header -->
	
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
			//issimple_post_pagination();
			
		else:
			// If no content, include the "No posts found" template.
			get_template_part( 'content', 'none' );
			
		endif;
	?>
	
</main><!-- #principal -->

<?php
get_footer();