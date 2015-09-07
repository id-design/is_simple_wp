<?php
/**
 * Template Name: Home Page
 * 
 * Learn more: {@link https://developer.wordpress.org/themes/basics/page-templates/}
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
							/**
                             * @hooked issimple_homepage_content - 10
                             * @hooked issimple_product_categories - 20
                             * @hooked issimple_recent_products - 30
                             * @hooked issimple_featured_products - 40
                             * @hooked issimple_popular_products - 50
                             * @hooked issimple_on_sale_products - 60
                             */
                            do_action( 'homepage' );
						?>
						
					</main><!-- #main-content -->
				</div><!-- #primary -->

<?php
// End the Loop
endwhile;

get_footer();