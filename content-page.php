<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'panel panel-default' ); ?>>
	
	<?php if ( has_post_thumbnail() ) : ?>
		<header class="entry-header">
			<?php
				// Diplay post featured thumb
				issimple_post_featured_thumb();
			?>
		</header><!-- .entry-header -->
	<?php endif; ?>
	
	<div class="entry-content">
		<?php
			the_content();
			issimple_page_links();
		?>
	</div><!-- .entry-content -->
	
</article><!-- #post## -->