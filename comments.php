<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 * 
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */
?>

<div id="comments">
	<?php
		/**
		 * If the current post is protected by a password and the visitor has not yet entered the password
		 * we will return early without loading the comments.
		 */
		if ( post_password_required() ) : ?>
			
	<p class="comments-protected"><?php _e( 'Post is password protected. Enter the password to view any comments.', 'issimple' ); ?></p>
</div><!-- #comments --><?php
			
			return;
		endif;
	?>
	
	<?php if ( have_comments() ) : ?>
		
		<h2 class="comments-title">
			<?php
				comments_number( __( 'Leave your thoughts', 'issimple' ), __( '1 comment', 'issimple' ), __( '% comments', 'issimple' ) );
				echo ' ' . __( 'on', 'issimple' ) . ' <span>&quot;' . get_the_title() . '&quot;</span>';
			?>
		</h2>
		
		<?php issimple_comment_nav(); ?>
		
		<ol class="comments-list">
			<?php // Comments list
				wp_list_comments( array( 'callback' => 'issimple_bootstrap_comments_loop' ) );
				//wp_list_comments();
			?>
		</ol><!-- .comments-list -->
		
		<?php issimple_comment_nav(); ?>
		
	<?php endif; // have_comments ?>
	
	<?php // If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed here.', 'issimple' ); ?></p>
	<?php endif; ?>
	
	<?php // Comment form
		$commenter 	= wp_get_current_commenter();
		$req 		= get_option( 'require_name_email' );
		$aria_req 	= ( $req ? " aria-required='true'" : '' );
		
		comment_form( array(
			'title_reply' => __( 'Leave your thoughts', 'issimple' ),
			'comment_notes_after'	=> '',
			'comment_field'			=> '<div class="comment-form-comment form-group"><label for="comment">' . __( 'Comment', 'issimple' ) . '</label> ' .
									   '<textarea id="comment" name="comment" cols="45" rows="8" aria-describedby="form-allowed-tags" aria-required="true"></textarea></div>',
			'fields'				=> apply_filters( 'comment_form_default_fields', array(
				'author' => '<div class="comment-form-author form-group">' . '<label for="author">' . __( 'Name', 'issimple' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
							'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="40"' . $aria_req . ' /></div>',
				'email'  => '<div class="comment-form-email form-group"><label for="email">' . __( 'Email', 'issimple' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
							'<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="40" aria-describedby="email-notes"' . $aria_req . ' /></div>',
				'url'    => '<div class="comment-form-url form-group"><label for="url">' . __( 'Website', 'issimple' ) . '</label> ' .
							'<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="40" /></div>',
			) )
		) );
	?>
	
</div><!-- #comments -->
