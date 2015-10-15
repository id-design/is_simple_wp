<?php
/**
 * IS Simple functions to adjusting theme to Bootstrap
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */


/**
 * Retrieve paginated links for archive post/comment pages adapted to Bootstrap.
 * 
 * @see paginate_links()
 * @since IS Simple 1.0
 * 
 * @param	string|array	$args {
 * 		Optional. Array or string of arguments for generating paginated links for archives.
 * 		
 * 		@type	string	$base 				Base of the paginated url. Default empty.
 * 		@type	string	$format				Format for the pagination structure. Default empty.
 * 		@type	int		$total				The total amount of pages. Default is the value WP_Query's
 * 											`max_num_pages` or 1.
 * 		@type	int		$current			The current page number. Default is 'paged' query var or 1.
 * 		@type	bool	$show_all			Whether to show all pages. Default false.
 * 		@type	int		$end_size			How many numbers on either the start and the end list edges.
 * 											Default 1.
 * 		@type	int		$mid_size			How many numbers to either side of the current pages. Default 2.
 * 		@type	bool	$prev_next			Whether to include the previous and next links in the list. Default true.
 * 		@type	bool	$prev_text			The previous page text. Default '« Previous'.
 * 		@type	bool	$next_text			The next page text. Default '« Previous'.
 * 		@type	string	$type				Controls format of the returned value. Possible values are 'pagination',
 * 											'array' and 'pager'. Default is 'pagination'.
 * 		@type	array	$add_args			An array of query args to add. Default false.
 * 		@type	string	$add_fragment		A string to append to each link. Default empty.
 * 		@type	string	$pagination_id		A string to appear before the page number. Default empty.
 * 		@type	string	$pagination_class 	A string to append after the page number. Default empty.
 * 		@type	string	$before_page_number	A string to appear before the page number. Default empty.
 * 		@type	string	$after_page_number	A string to append after the page number. Default empty.
 * }
 * @return	array|string	String of page links or array of page links.
 */
function wp_bootstrap_paginate_links( $args = '' ) {
	global $wp_query, $wp_rewrite;

	// Setting up default values based on the current URL.
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$url_parts    = explode( '?', $pagenum_link );

	// Get max pages and current page out of the current query, if available.
	$total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
	$current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

	// Append the format placeholder to the base URL.
	$pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

	// URL base depends on permalink settings.
	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	$defaults = array(
		'base'					=> $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
		'format'				=> $format, // ?page=%#% : %#% is replaced by the page number
		'total'					=> $total,
		'current'				=> $current,
		'show_all'				=> false,
		'prev_next'				=> true,
		'prev_text'				=> '<i class="glyphicon glyphicon-chevron-left"></i> <span class="sr-only">' . __( 'Previous', 'issimple' ) . '</span>',
		'next_text'				=> '<span class="sr-only">' . __( 'Next', 'issimple' ) . '</span> <i class="glyphicon glyphicon-chevron-right"></i>',
		'end_size'				=> 1,
		'mid_size'				=> 2,
		'type'					=> 'pagination',
		'add_args'				=> array(), // array of query args to add
		'add_fragment'			=> '',
		'pagination_id'			=> '',
		'pagination_class'		=> '',
		'before_page_number'	=> '',
		'after_page_number'		=> ''
	);

	$args = wp_parse_args( $args, $defaults );
	
	// Who knows what else people pass in $args
	$total = (int) $args['total'];
	if ( $total < 2 ) return;
	
	$current  = (int) $args['current'];
	
	$end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
	if ( $end_size < 1 ) $end_size = 1;
	
	$mid_size = (int) $args['mid_size'];
	if ( $mid_size < 0 ) $mid_size = 2;
	
	$add_args = $args['add_args'];
	$output = '';
	$page_links = array();
	$dots = false;

	if ( $args['prev_next'] ) :
		if ( $current && 1 < $current ) :
			$link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
			$link = str_replace( '%#%', $current - 1, $link );
			if ( $add_args )
				$link = add_query_arg( $add_args, $link );
			$link .= $args['add_fragment'];
	
			/**
			 * Filter the paginated links for the given archive pages.
			 *
			 * @since 3.0.0
			 *
			 * @param string $link The paginated link URL.
			 */
			$page_links[] = '<li class="previous"><a href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '" title="' . __( 'Previous page', 'issimple') . '">' . $args['prev_text'] . '</a></li>';
		else :
			$page_links[] = '<li class="previous disabled"><span title="' . __( 'Previous page', 'issimple') . '">' . $args['prev_text'] . '</span></li>';
		endif;
	endif;
	
	for ( $n = 1; $n <= $total; $n++ ) :
		if ( $n == $current ) :
			$page_links[] = '<li class="active"><span class="active">' . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . '</span></li>';
			$dots = true;
		else :
			if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
				$link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
				$link = str_replace( '%#%', $n, $link );
				if ( $add_args )
					$link = add_query_arg( $add_args, $link );
				$link .= $args['add_fragment'];

				/** This filter is documented in wp-includes/general-template.php */
				$page_links[] = '<li>' .
					sprintf( __( '<a href="%1$s" title="Go to page %2$d">%3$s%2$d%4$s</a>', 'issimple' ),
						esc_url( apply_filters( 'paginate_links', $link ) ), number_format_i18n( $n ), $args['before_page_number'], $args['after_page_number'] ) .
					'</li>';
				$dots = true;
			elseif ( $dots && ! $args['show_all'] ) :
				$page_links[] = '<li class="dots disabled"><span>' . __( '&hellip;' ) . '</span></li>';
				$dots = false;
			endif;
		endif;
	endfor;
	
	if ( $args['prev_next'] ) :
		if ( $current && ( $current < $total || -1 == $total ) ) :
			$link = str_replace( '%_%', $args['format'], $args['base'] );
			$link = str_replace( '%#%', $current + 1, $link );
			if ( $add_args )
				$link = add_query_arg( $add_args, $link );
			$link .= $args['add_fragment'];
	
			/** This filter is documented in wp-includes/general-template.php */
			$page_links[] = '<li class="next"><a href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '" title="' . __( 'Next page', 'issimple') . '">' . $args['next_text'] . '</a></li>';
		else :
			$page_links[] = '<li class="next disabled"><span title="' . __( 'Next page', 'issimple') . '">' . $args['next_text'] . '</span></li>';
		endif;
	endif;
	
	$pagination_id = ( ! empty( $args['pagination_id'] ) ) ? ' id="' . esc_attr( $args['pagination_id'] ) . '"' : '';
	$pagination_class = ( ! empty( $args['pagination_class'] ) ) ? ' ' . esc_attr( $args['pagination_class'] ) : '';
	
	switch ( $args['type'] ) {
		case 'array' :
			return $page_links;

		case 'pager' :
			$output .= "<ul" . $pagination_id . " class='pager" . $pagination_class . "'>\n\t";
			break;

		default :
			$output .= "<ul" . $pagination_id . " class='pagination" . $pagination_class . "'>\n\t";
			break;
	}
	
	$output .= join( "\n\t", $page_links );
	$output .= "\n</ul>\n";
	
	return $output;
}


/**
 * Custom Bootstrap Link Paginations
 * 
 * A custom WordPress numbered pagination function to fully implement the
 * Bootstrap 3.x pagination/pager style in a custom theme.
 * 
 * @see wp_bootstrap_paginate_links()
 * @since IS Simple 1.0
 * 
 * @param	string|array	$args	Optional args. See wp_bootstrap_paginate_links().
 * @return	string					Markup for pagination links.
 * ----------------------------------------------------------------------------
 */
function wp_bootstrap_pagination_links( $args = array() ) {
	// Sets the pagination default args.
	$args = wp_parse_args( $args, array(
		'paginate_content'		=> 'posts',
		'type'					=> 'pagination',
		'mid_size'				=> 2,
		'echo'					=> true
	) );
	
	$links = '';
	
	if ( 'posts' == $args['paginate_content'] ) {
		// Prevent show pagination number if Infinite Scroll of JetPack is active.
		if ( isset( $_GET[ 'infinity' ] ) ) return;
		
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages > 1 ) {
			// Make sure we get a string back. Pagination is the next best thing.
			if ( isset( $args['type'] ) && 'array' == $args['type'] ) {
				$args['type'] = 'pagination';
			}
			
			// Set up paginated links.
			$links = wp_bootstrap_paginate_links( $args );
		}
	}
	
	if ( 'comments' == $args['paginate_content'] ) {
		global $wp_rewrite;
		
		if ( ! is_singular() || ! get_option( 'page_comments' ) ) return;
		
		$page = get_query_var('cpage');
		if ( ! $page ) $page = 1;
		
		$max_page = get_comment_pages_count();
		
		$defaults = array(
			'base'					=> add_query_arg( 'cpage', '%#%' ),
			'format'				=> '',
			'total'					=> $max_page,
			'current'				=> $page,
			'screen_reader_text'	=> __( 'Comments navigation', 'issimple' ),
			'add_fragment'			=> '#comments'
		);
		if ( $wp_rewrite->using_permalinks() )
			$defaults['base'] = user_trailingslashit( trailingslashit( get_permalink() ) . $wp_rewrite->comments_pagination_base . '-%#%', 'commentpaged');
		
		$args = wp_parse_args( $args, $defaults );
		
		$links = wp_bootstrap_paginate_links( $args );
	}
	
	if ( empty( $links ) ) return;
	
	$output = '';
	$output = wp_bootstrap_navigation_markup( $links, $args );
	
	if ( $args['echo'] ) {
		echo $output;
	} else {
		return $output;
	}
}


/**
 * Wraps passed links in navigational markup in Bootstrap format
 * 
 * @since IS Simple 1.0
 * 
 * @param	string	$links	Navigational links.
 * @param	array	$args	Optional. Custom class for nav element. Default: 'posts-navigation'.
 * @return	string			Navigation template tag.
 * ============================================================================
 */
function wp_bootstrap_navigation_markup( $links, $args = array() ) {
	if ( empty( $links ) ) return;
	
	// Set default args...
	$args = wp_parse_args( $args, array(
		'container'				=> 'nav',
		'container_id'			=> '',
		'container_class'		=> '',
		'div_class'				=> '',
		'screen_reader_text'	=> __( 'Posts navigation', 'issimple' ),
	) );
	
	$output = '';
	
	if ( ! empty( $args['screen_reader_text'] ) )
		$output .= '<h2 class="sr-only">' . $args['screen_reader_text'] . '</h2>' . $links;
	
	if ( false !== $args['div_class'] ) {
		$div_class = array();
		$div_class[] = 'pagination-content';
		$div_class[] = ( ! empty( $args['div_class'] ) ? $args['div_class'] : '' );
		$output = '<div class="' . esc_attr( join( ' ', $div_class ) ) . '">' . $output . '</div>';
	}
	
	if ( false !== $args['container'] ) {
		$container_atts = array();
		$container_atts['id'] 	 = ( ! empty( $args['container_id'] ) ) ? $args['container_id'] : '';
		$container_atts['class'] = ( ! empty( $args['container_class'] ) ) ? $args['container_class'] : '';
		$container_atts['role']  = ( $args['container'] == 'nav' ) ? 'navigation' : '';
		
		$container_attributes = array2atts( $container_atts );
		
		$output = '<' . $args['container'] . $container_attributes . '>' . $output . '</' . $args['container'] . '>';
	}
	
	return $output;
}


/**
 * Return navigation to next/previous set of posts when applicable adapted to Bootstrap
 *
 * @since IS Simple 1.0
 *
 * @global	WP_Query	$wp_query	WordPress Query object.
 *
 * @param	array	$args {
 * 		Optional. Default posts navigation arguments. Default empty array.
 * 		
 * 		@type	string	$prev_text				Anchor text to display in the previous posts link.
 * 												Default 'Older posts'.
 * 		@type	string	$next_text				Anchor text to display in the next posts link.
 * 												Default 'Newer posts'.
 * 		@type	string	$screen_reader_text		Screen reader text for nav element.
 * 												Default 'Posts navigation'.
 * }
 * @return	string	Markup for posts links.
 * ============================================================================
 */
function wp_bootstrap_post_navigation( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'container_class'		=> 'post-navigation',
		'prev_text'				=> '%title',
		'next_text'				=> '%title',
		'screen_reader_text'	=> __( 'Posts navigation', 'issimple' ),
		'echo'					=> true
	) );
	
	$navigation = '';
	$prev = get_previous_post_link( '<div class="nav-previous">%link</div>', $args['prev_text'] );
	$next = get_next_post_link( '<div class="nav-next">%link</div>', $args['next_text'] );
	
	// Only add markup if there's somewhere to navigate to.
	if ( $prev || $next ) {
		$navigation = wp_bootstrap_navigation_markup( $prev . $next, $args );
	}
	
	if ( $args['echo'] ) {
		echo $navigation;
	} else {
		return $navigation;
	}
}


/**
 * Convert simple tag links to Bootstrap Labels
 * 
 * @since IS Simple 1.0
 */
function wp_bootstrap_make_label_tags( $links ) {
	for ( $i = 0; $i < count( $links ); $i++ ) {
		$links[$i] = str_replace( '<a', '<a class="label label-default"', $links[$i] );
	}
	
	return $links;
}
add_filter( 'term_links-post_tag', 'wp_bootstrap_make_label_tags' );


/**
 * Custom comments loop adapted to Bootstrap
 * 
 * Inspired by the function odin_comments_loop (@link https://github.com/wpbrasil/odin/blob/master/inc/comments-loop.php),
 * created by WordPress Brasil Group and with the licence GPLv2.
 * 
 * @since IS Simple 1.0
 * 
 * @param	object	$comment 	Comment object.
 * @param	array	$args		Comment arguments.
 * @param	int		$depth		Comment depth.
 * 
 * @return	void
 */
function wp_bootstrap_comments_loop( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	
	switch ( $comment->comment_type ) {
		case 'pingback' :
		case 'trackback' :
			?>
<li class="post pingback">
	<p><?php _e( 'Pingback:', 'issimple' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'issimple' ), '<span class="edit-link">', '</span>' ); ?></p>
			<?php
			break;
		default :
			?>
<li id="li-comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
	<?php
		$panel_type = ( get_comment_author() === get_the_author() ) ? 'primary' : 'default';
	?>
	<article id="comment-<?php comment_ID(); ?>" class="comment panel panel-<?php echo $panel_type ?>">
		<footer class="comment-meta panel-heading">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 70, '', '', array( 'class' => 'img-thumbnail img-circle' ) ) ?>
				<div class="comment-metadata">
					<?php
						$author_link = ( get_comment_author() === get_the_author() ) ? '<span class="glyphicon glyphicon-user"></span> ' . get_comment_author_link() : get_comment_author_link();
						printf( '<b class="fn">%1$s</b><br />%2$s <a href="%3$s"><time datetime="%4$s" title="%5$s">%6$s %7$s %8$s</time></a> %9$s',
							$author_link,
							__( 'In', 'issimple' ),
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							get_comment_time( 'l, ' . get_option( 'date_format' ) . ', H:i' ),
							get_comment_date(),
							__( 'at', 'issimple' ),
							get_comment_time(),
							__( '<span class="says">said:</span>', 'issimple' )
						); ?>
				</div>
				<?php edit_comment_link( __( 'Edit', 'issimple' ), '<span class="edit-link"><span class="glyphicon glyphicon-pencil"></span> ', '</span>' ); ?>
				<div class="clearfix"></div>
			</div><!-- .comment-author.vcard -->

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<div class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'issimple' ); ?></div>
			<?php endif; ?>
		</footer><!-- .comment-meta -->
		
		<div class="panel-body">
			<div class="comment-content"><?php comment_text(); ?></div>
			<div class="reply">
				<?php
					comment_reply_link( array_merge( $args, array(
						'reply_text'	=> __( 'Respond', 'issimple' ),
						'depth'			=> $depth,
						'max_depth'		=> $args['max_depth'],
						'panel_type'	=> $panel_type
					) ) );
				?>
			</div><!-- .reply -->
		</div>
	</article><!-- #comment-## -->
			<?php
			break;
	}
}


/**
 * Convert comment reply links to Bootstrap Button
 * 
 * @since IS Simple 1.0
 */
function wp_bootstrap_make_btn_comment_reply_link( $link, $args, $comment, $post ) {
	return preg_replace( '/comment-reply-link/', 'btn btn-' . $args['panel_type'] . ' comment-reply-link', $link, 1 );
}
add_filter( 'comment_reply_link', 'wp_bootstrap_make_btn_comment_reply_link', 10, 4 );

