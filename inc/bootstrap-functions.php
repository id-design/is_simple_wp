<?php
/**
 * IS Simple functions to adjusting theme to Bootstrap
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */


/**
 * Custom Bootstrap Posts Pagination
 * 
 * A custom WordPress numbered pagination function to fully implement the
 * Bootstrap 3.x pagination/pager style in a custom theme.
 * Inspired by the function wp_bootstrap_pagination
 * (@link https://github.com/talentedaamer/Bootstrap-wordpress-pagination),
 * created by OOPThemes and with the licence GPLv2.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_wp_bootstrap_pagination( $args = array() ) {
	global $wp_query;
	
	// Prevent show pagination number if Infinite Scroll of JetPack is active.
	if ( ! isset( $_GET[ 'infinity' ] ) ) {
		
		// Sets the pagination args.
		$defaults = array(
			'container'				=> 'nav',
			'container_id'			=> '',
			'container_class'		=> '',
			'div_class'				=> '',
			'screen_reader_text'	=> __( 'Posts navigation', 'issimple' ),
			'type'					=> 'pagination',
			'pagination_id'			=> '',
			'pagination_class'		=> '',
			'range'					=> 4,
			'custom_query'			=> false,
			'echo'					=> true,
			'previous_text'			=> __( '<i class="glyphicon glyphicon-chevron-left"></i> <span class="sr-only">Previous</span>', 'issimple' ),
			'next_text'				=> __( '<span class="sr-only">Next</span> <i class="glyphicon glyphicon-chevron-right"></i>', 'issimple' ),
			'first_link_text'		=> __( 'First', 'issimple' ),
			'last_link_text'		=> __( 'Last', 'issimple' )
		);
		
		$args = wp_parse_args( $args, apply_filters( 'issimple_wp_bootstrap_pagination_defaults', $defaults ) );
		
		$args['range'] = (int) $args['range'] - 1;
		
		if ( ! $args['custom_query'] ) $args['custom_query'] = $wp_query;
		
		$count = (int) $args['custom_query']->max_num_pages;
		$page  = intval( get_query_var( 'paged' ) );
		$ceil  = ceil( $args['range'] / 2 );
		
		if ( $count <= 1 ) return false;
		
		if ( ! $page ) $page = 1;
		
		if ( $count > $args['range'] ) {
			if ( $page <= $args['range'] ) {
				$min = 1;
				$max = $args['range'] + 1;
			} elseif ( $page >= ( $count - $ceil ) ) {
				$min = $count - $args['range'];
				$max = $count;
			} elseif ( $page >= $args['range'] && $page < ( $count - $ceil ) ) {
				$min = $page - $ceil;
				$max = $page + $ceil;
			}
		} else {
			$min = 1;
			$max = $count;
		}
		
		$output = '';
		
		$div_class = ( ! empty( $args['div_class'] ) ) ? ' class="post-pagination ' . $args['div_class'] . '"' : ' class="post-pagination"';
		$output .= '<div' . $div_class . '>';
		
		if ( isset( $args['screen_reader_text'] ) ) {
			$output .= '<h2 class="sr-only">' . $args['screen_reader_text'] . '</h2>';
		}
		
		$pagination_id = ( $args['pagination_id'] ) ? ' id="' . $args['pagination_id'] . '"' : '';
		
		$pagination_class = ( ! empty( $args['pagination_class'] ) ) ? $args['type'] . ' ' . $args['pagination_class'] : $args['type'];
		$pagination_class = ' class="' . $pagination_class . '"';
		
		$output .= '<ul' . $pagination_id . $pagination_class . '>';
		
		$previous = intval( $page ) - 1;
		$previous = esc_attr( get_pagenum_link( $previous ) );
		if ( $previous && ( 1 != $page ) ) {
			$output .= '<li class="previous"><a href="' . $previous . '" title="' . __( 'Previous page', 'issimple') . '">' . $args['previous_text'] . '</a></li>';
		} else {
			$output .= '<li class="previous disabled"><span>' . $args['previous_text'] . '</span></li>';
		}
		
		$firstpage = esc_attr( get_pagenum_link( 1 ) );
		if ( $firstpage && ( 1 != $page ) && ( 1 < $min ) ) 
			$output .= '<li><a href="' . $firstpage . '" title="' . __( 'Go to first page', 'issimple') . '">' . 1 . '</a></li>';
		
		if ( ! empty( $min ) && ! empty( $max ) ) {
			if ( ( $min - 1 ) > 1 )
				$output .= '<li class="dots disabled"><span>' . __( '&hellip;' ) . '</span></li>';
			
			for( $i = 1; $i <= $count; $i++ ) {
				if ( $page == $i ) {
					$output .= '<li class="active"><span class="active">' . $i . '</span></li>';
				} elseif ( $i >= $min && $i <= $max ) {
					$output .= sprintf( '<li><a href="%1$s" title="' . __( 'Go to page %2$d', 'issimple') . '">%2$d</a></li>', esc_attr( get_pagenum_link( $i ) ), $i );
				}
			}
			
			if ( ( $max + 1 ) < $count )
				$output .= '<li class="dots disabled"><span>' . __( '&hellip;' ) . '</span></li>';
		}
		
		$lastpage = esc_attr( get_pagenum_link( $count ) );
		if ( $lastpage && ( $max < $count ) )
			$output .= '<li><a href="' . $lastpage . '" title="' . __( 'Go to last page', 'issimple') . '">' . $count . '</a></li>';
		
		$next = intval( $page ) + 1;
		$next = esc_attr( get_pagenum_link( $next ) );
		if ( $next && ( $count != $page ) ) {
			$output .= '<li class="next"><a href="' . $next . '" title="' . __( 'Next page', 'issimple') . '">' . $args['next_text'] . '</a></li>';
		} else {
			$output .= '<li class="next disabled"><span>' . $args['next_text'] . '</span></li>';
		}
		
		$output .= '</ul></div>';
		
		if ( isset( $args['container'] ) ) {
			$container_id = ( ! empty( $args['container_id'] ) ) ? ' id="' . $args['container_id'] . '"' : '';
			$container_class = ( ! empty( $args['container_class'] ) ) ? ' class="' . $args['container_class'] . '"' : '';
			
			$output = '<' . $args['container'] . $container_id . $container_class . '>' . $output . '</' . $args['container'] . '>';
		}
		
		if ( $args['echo'] ) {
			echo $output;
		} else {
			return $output;
		}
	}
}


/**
 * Convert simple tag links to Bootstrap Labels
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */
function issimple_make_label_tags( $links ) {
	for ( $i = 0; $i < count( $links ); $i++ ) {
		$links[$i] = str_replace( '<a', '<a class="label label-default"', $links[$i]);
	}
	
	return $links;
}
add_filter( 'term_links-post_tag', 'issimple_make_label_tags' );