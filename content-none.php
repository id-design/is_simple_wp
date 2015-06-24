<?php
/**
 * O template para exibir a mensagem de que os posts não foram encontrados
 * 
 * @package IS Simple
 * @since 1.0
 */
?>

<article id="entry-not-found" class="not-found no-results hentry panel panel-default">
	
	<header class="entry-header">
		<h3 class="entry-title"><?php _e( 'Nothing found', 'issimple' ); ?></h1>
	</header><!-- .entry-header -->
	
	<section class="entry-content">
		
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'issimple' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'issimple' ); ?></p>
			<p><?php issimple_content_search_form( 'content' ); ?></p>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'issimple' ); ?></p>
			<p><?php issimple_content_search_form( 'content' ); ?></p>

		<?php endif; ?>
		
		<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php _e( 'Return home?', 'issimple' ); ?></a></p>
	</section><!-- .entry-content -->

</article><!-- #entry-not-found -->