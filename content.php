<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/author/category/search/tag.
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'panel panel-default' ); ?>>
	
	<header class="entry-header">
		
		<?php
			// Diplay post featured thumb
			issimple_post_featured_thumb();
			
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				?>
				<h3 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
				</h3>
				<?php
			endif;
			
			// Display entry meta
			issimple_entry_meta();
		?>
	
	</header><!-- .entry-header -->
	
	<?php if ( is_single() ) : ?>
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	<?php else : ?>
		<div class="entry-summary">
			<?php issimple_excerpt( 'issimple_index' ); ?>
		</div><!-- .entry-summary -->
	<?php endif; ?>
	
	<?php // Display entry footer
		issimple_entry_footer(); ?>
	
</article><!-- #post## -->