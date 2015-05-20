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

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="post-header">
		
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="post-title">', '</h1>' );
			else :
				?>
				<h2 class="post-title">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
				</h2>
				<?php
			endif;
			
			// Display post details
			issimple_post_details();
		?>
	
	</header><!-- .post-header -->
	
	<section class="post-content">
		<?php
			if ( is_single() ) :
				the_content();
			else :
				issimple_excerpt( 'issimple_index' );
			endif;
		?>
	</section><!-- .post-content -->
	
	<?php if ( is_single() ) : ?>
		<footer class="post-footer">
			<?php if ( get_the_author_meta( 'description' ) ) get_template_part( 'author-info' ); ?>
			
			<p>
				<?php _e( 'This post was written by ', 'issimple' ); the_author_posts_link(); _e( ' in ', 'issimple' ); issimple_date_link(); ?>.<br />
				<i class="fa fa-folder-open"></i> <?php _e( 'Categorised in: ', 'issimple' ); the_category( ', ' ); // Separado por vírgula ?>.<br />
				<i class="fa fa-tags"></i> <?php the_tags( __( 'Tags: ', 'issimple' ) ); ?>.
			</p>
		</footer><!-- .post-footer -->
	<?php endif; ?>
	
</article>
<!-- #post## -->

<hr />