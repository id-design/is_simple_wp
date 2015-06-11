<?php
/**
 * IS Simple functions to adjusting theme to Bootstrap
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */


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