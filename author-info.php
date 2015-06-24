<?php
/**
 * The template for displaying Author infos
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */
?>

<div id="author-info">
	<?php if ( is_single() ) : ?>
		<h2 class="author-heading"><?php _e( 'Published by:', 'issimple' ); ?></h2>
	<?php endif; ?>
	<div class="author-avatar alignleft">
		<?php
		// Filtro para o tamanho personalizado para o avatar 
		$author_bio_avatar_size = apply_filters( 'issimple_author_bio_avatar_size', 120 );
		echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size, '', '', array( 'class' => 'img-thumbnail img-circle' ) );
		?>
	</div><!-- .author-avatar -->

	<div class="author-description">
		<h3 class="author-title"><?php echo get_the_author(); ?></h3>

		<p class="author-bio">
			<?php the_author_meta( 'description' ); ?><br />
			<?php if ( is_single() ) : ?>
				<a class="author-link"
				   href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"
				   rel="author"><?php printf( __( 'View all posts by %s', 'issimple' ), get_the_author() ); ?></a>.
			<?php endif; ?>
		</p><!-- .author-bio -->

	</div><!-- .author-description -->
</div><!-- #author-info -->