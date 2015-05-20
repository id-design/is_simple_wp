<?php 
/**
 * Shortcodes úteis no tema
 * 
 * @package Estúdio Viking
 * @since 1.0
 */

/**
 * Link para página inicial do site
 * 
 * @uses [home-link]
 * ----------------------------------------------------------------------------
 */
function my_home_link( $atts ) {
	$output_link = '<a href="' . get_bloginfo( 'url', 'display' ) . '" title="' . get_bloginfo( 'name', 'display' ) . '" rel="home">' . get_bloginfo( 'name', 'display' ) . '</a>';
	return $output_link;
}
add_shortcode( 'home-link', 'my_home_link' );


/**
 * Link para página inicial do site
 * 
 * @uses [current-year]
 * ----------------------------------------------------------------------------
 */
function my_current_year( $atts ) {
	return date( 'Y' );
}
add_shortcode( 'current-year', 'my_current_year' );