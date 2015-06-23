<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */

get_header();

issimple_page_header(); ?>

<div id="main">
	<div class="container-fluid">
		<div class="row">
			<div id="primary" class="<?php issimple_primary_class(); ?>">
				<main id="main-content" class="site-main" role="main">
					
					<article id="post-error-404" class="not-found error-404 hentry panel panel-default">
						
						<div class="entry-content">
							<p>
								<?php _e( 'Sorry, nothing to display.', 'issimple' ); ?><br />
								<?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'issimple' ); ?>
							</p>
							<p><?php issimple_content_search_form( 'content' ); ?></p>
							<p><a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'issimple' ); ?></a></p>
						</div><!-- .entry-content -->
						
					</article><!-- #post-error-404 -->
					
				</main><!-- #main-content -->
			</div><!-- #primary -->

<?php
get_sidebar();

get_footer();