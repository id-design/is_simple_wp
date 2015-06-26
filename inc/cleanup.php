<?php
/**
 * Cleaning and optimization to filters, actions and styles that are automatically
 * injected into the template
 * 
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */


/**
 * Cleanup wp_head().
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_cleanup_head() {
	// Category feeds.
	//remove_action( 'wp_head', 'feed_links_extra', 3 );
	
	// Post and Comment feeds.
	//remove_action( 'wp_head', 'feed_links', 2 );
	
	// EditURI link.
	remove_action( 'wp_head', 'rsd_link' );
	
	// Windows live writer.
	remove_action( 'wp_head', 'wlwmanifest_link' );
	
	// Index link.
	remove_action( 'wp_head', 'index_rel_link' );
	
	// Previous link.
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	
	// Start link.
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	
	// Links for adjacent posts.
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	
	// Canonical.
	//remove_action( 'wp_head', 'rel_canonical' );
	
	// Shortlink.
	//remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
	
	// WP version.
	remove_action( 'wp_head', 'wp_generator' );
}
add_action( 'init', 'issimple_cleanup_head' );


/**
 * Additional Filters.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
//Remove WP version from RSS.
add_filter( 'the_generator', '__return_false' );

// Remove Admin Bar.
//add_filter( 'show_admin_bar', '__return_false' );

// Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter( 'the_excerpt', 'do_shortcode' );

// Allows Shortcodes in Dynamic Sidebar.
add_filter( 'widget_text', 'do_shortcode' );

// Remove <p> tags in Dynamic Sidebars (better!)
add_filter( 'widget_text', 'shortcode_unautop' );


/**
 * Removing Filters.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
// Remove <p> tags in Post Excerpts
//remove_filter( 'the_excerpt', 'wpautop' );


/**
 * Remove injected CSS for recent comments widget.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) )
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
}
add_filter( 'wp_head', 'issimple_remove_wp_widget_recent_comments_style', 1);


/**
 * Remove injected CSS from recent comments widget.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function my_remove_recent_comments_style() {
	global $wp_widget_factory;
	
	if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) )
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'my_remove_recent_comments_style' );


/**
 * Remove 'text/css' from enqueued stylesheets.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function my_style_remove( $tag ) {
	return preg_replace( '~\s+type=["\'][^"\']++["\']~', '', $tag );
}
add_filter( 'style_loader_tag', 'my_style_remove' );


/**
 * Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function remove_img_dimensions( $html ) {
	return preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
}
add_filter( 'post_thumbnail_html', 'remove_img_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_img_dimensions', 10 );


/**
 * Remove invalid values to 'rel' attribute in Category Lists
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function remove_category_rel_from_category_list( $text ) {
    return str_replace( 'rel="category tag"', 'rel="tag"', $text );
}
add_filter( 'the_category', 'remove_category_rel_from_category_list' );
add_filter( 'wp_list_categories', 'remove_category_rel_from_category_list' );



