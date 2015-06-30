<?php
/**
 * Custom Header functionality for Twenty Fifteen
 * 
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */


/**
 * Set up the WordPress core custom header feature.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'issimple_custom_header_args', array(
		// Default image and text color
		'default-image'          => '',
		'default-text-color'     => '',
		
		// Default image sizes
		'width'                  => 2000,
		'height'                 => 50,
		
		// Extra options
		'random-default'         => false,	// Random header images
		'flex-height'            => false,
		'flex-width'             => true,
		'header-text'            => true,	// Enable text customization support
		'uploads'                => true,	// Enable image uploads
		
		// Funtion to show styles in <head> element
		'wp-head-callback'       => 'issimple_header_style',
	) ) );
	
	/**
	 * Custom Images Pack to header
	 * Remove comments to enable
	 * ----------------------------------------------------------------------------
	 */
	
	/**
	 * Default custom headers packaged with the theme.
	 * %s is a placeholder for the theme template directory URI.
	 */
	//$headers_uri = '%s/assets/img/headers/';
	//register_default_headers( array(
	//	'logo_header' => array(
	//		'url'           => $headers_uri . 'bg_header.png',
	//		'thumbnail_url' => $headers_uri . 'bg_header-thumbnail.png',
	//		'description'   => _x( 'IS Simple Header', 'header image description', 'issimple' )
	//	),
	//) );
}
add_action( 'after_setup_theme', 'issimple_custom_header_setup', 11 );


/**
 * Style the header text displayed on the blog.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_header_style() {
	$header_image = get_header_image();
	$text_color   = get_header_textcolor();
	
	// If no custom options for text are set, let's bail.
	if ( ! $text_color && empty( $header_image ) ) return;
	
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css" id="issimple-header-css">
	<?php
		// Has a Custom Header been added?
		if ( ! empty( $header_image ) ) :
	?>
		#nav-header {
			background: url(<?php header_image(); ?>) no-repeat scroll top center;
			background-size: 100% auto;
		}
	<?php endif;
		
		// Has the text been visible?
		if ( display_header_text() ) :
	?>
		#name a { color: #<?php echo esc_attr( $text_color ); ?>; }
	<?php endif;
		
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		#header-txt {
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute !important;
		}
	<?php endif; ?>
	</style>
	<?php
}