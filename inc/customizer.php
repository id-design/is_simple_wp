<?php
/**
 * IS Simple Customizer functionality
 *
 * @package		WordPress
 * @subpackage	IS_Simple
 * @since		IS Simple 1.0
 */



/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since	IS Simple 1.0
 */
function issimple_customize_preview_js() {
	wp_enqueue_script( 'issimple-customize-preview', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '20151106', true );
}
add_action( 'customize_preview_init', 'issimple_customize_preview_js' );