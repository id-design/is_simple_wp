<?php
/**
 * Options to customize IS Simple Wordpress Theme.
 *
 * @package		WordPress
 * @subpackage	IS Simple
 * @since		IS Simple 1.0
 */


/**
 * Require Theme Options Class
 *
 * @since	IS Simple 1.0
 */
require_once get_template_directory() . '/core/classes/class-theme-options.php';


if ( ! function_exists( 'issimple_theme_options' ) ) :
/**
 * IS Simple Theme Options Setup
 *
 * @since	IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_theme_options() {

	$theme				= wp_get_theme();
	$theme_name			= $theme->get( 'Name' );
	$theme_tags			= $theme->get( 'Tags' );
	$theme_screenshot	= $theme->get_screenshot();

	$settings = new ISSimple_Theme_Options(
		'issimple-settings',										// Slug/ID of the Settings Page (Required)
		sprintf( __( '%s Settings', 'issimple' ), $theme_name ),	// Settings page name (Required)
		'manage_options'											// Page capability (Optional) [default is manage_options]
	);

	$settings->set_tabs( array(
		array(
			'id'	=> 'issimple_general_options',					// Slug/ID of the Settings tab (Required)
			'title'	=> __( 'General', 'issimple' ),					// Settings tab title (Required)
		),
		array(
			'id' 	=> 'issimple_style_options',					// Slug/ID of the Settings tab (Required)
			'title'	=> __( 'Style', 'issimple' ),					// Settings tab title (Required)
		),
		array(
			'id' 	=> 'issimple_slider_options',					// Slug/ID of the Settings tab (Required)
			'title'	=> __( 'Slider', 'issimple' ),					// Settings tab title (Required)
		)
	) );

	// Default Footer Copyright Text
	$default_footer_text = sprintf( '&copy; %1$d %2$s - %3$s',
		date( 'Y' ), '[home-link]', __( 'All rights reserved.', 'issimple' )
	);

	// Post Tag Array
	$tags = get_tags();
	$array_tags = array();
	$array_tags['none'] = __( 'None', 'issimple' );
	foreach ( $tags as $tag ) {
		$array_tags[ $tag->term_id ] = ucfirst( $tag->name );
	}

	// Slider FX
	$slider_fx = array(
		'none'			=> __( 'None', 'issimple' ),
		'fade'			=> 'Fade',
		'fadeout'		=> 'Fade Out',
		'scrollHorz'	=> 'Scroll Horizontal'
	);

	$settings->set_fields( array(
		'issimple_general_fields_section' => array(																// Slug/ID of the section (Required)
			'tab'		=> 'issimple_general_options',															// Tab ID/Slug (Required)
			'title'		=> sprintf( __( 'General options to customize %s Theme.', 'issimple' ), $theme_name ),	// Section title (Required)
			'fields'	=> array(																				// Section fields (Required)
				// Header Logo.
				array(
					'id'			=> 'header_logo',
					'label'			=> __( 'Header Logo', 'issimple' ),
					'type'			=> 'image',
					'description'	=> __( 'Select the logo to show in header.', 'issimple' )
				),
				// Footer Text.
				array(
					'id'			=> 'footer_text',
					'label'			=> __( 'Footer Text', 'issimple' ),
					'type'			=> 'textarea',
					'default'		=> $default_footer_text,
					'description'	=> __( 'Type the copyright text appears in the footer.', 'issimple' )
				)
			)
		),
		'issimple_style_fields_section' => array(																// Slug/ID of the section (Required)
			'tab'		=> 'issimple_style_options',															// Tab ID/Slug (Required)
			'title'		=> sprintf( __( 'Style options to customize %s Theme.', 'issimple' ), $theme_name ),	// Section title (Required)
			'fields'	=> array(																				// Section fields (Required)
				// Header Navbar Style.
				array(
					'id'			=> 'header_navbar_style',
					'label'			=> __( 'Header Navbar Style', 'issimple' ),
					'type'			=> 'select',
					'default'		=> 'navbar-inverse',
					'options'		=> array(
						'navbar-default' => __( 'Navbar Default', 'issimple' ),
						'navbar-inverse' => __( 'Navbar Inverse', 'issimple' )
					),
					'description'	=> __( 'Select the Header Navbar Style you want.', 'issimple' )
				),
				// Header Navbar Fixing.
				array(
					'id'			=> 'header_navbar_fixing',
					'label'			=> __( 'Header Navbar Fixing', 'issimple' ),
					'type'			=> 'select',
					'default'		=> 'navbar-fixed-top',
					'options'		=> array(
						'none'				=> __( 'None', 'issimple' ),
						'navbar-static-top'	=> __( 'Navbar Static Top', 'issimple' ),
						'navbar-fixed-top'	=> __( 'Navbar Fixed Top', 'issimple' )
					),
					'description'	=> __( 'Select the Header Navbar Fixing you want.', 'issimple' )
				)
			)
		),
		'issimple_slider_fields_section' => array(																// Slug/ID of the section (Required)
			'tab'		=> 'issimple_slider_options',															// Tab ID/Slug (Required)
			'title'		=> sprintf( __( 'Slider options to customize %s Theme.', 'issimple' ), $theme_name ),	// Section title (Required)
			'fields'	=> array(																				// Section fields (Required)
				// Slider Tag.
				array(
					'id'			=> 'slider_tag',
					'label'			=> __( 'Slider Tag', 'issimple' ),
					'type'			=> 'select',
					'default'		=> 'none',
					'options'		=> $array_tags,
					'description'	=> __( 'Select the Post Tag to show in slider.', 'issimple' )
				),
				// Slider FX.
				array(
					'id'			=> 'slider_fx',
					'label'			=> __( 'Slider FX', 'issimple' ),
					'type'			=> 'select',
					'default'		=> 'scrollHorz',
					'options'		=> $slider_fx,
					'description'	=> __( 'Select the transition that you want for slider.', 'issimple' )
				),
				// Slider Timeout.
				array(
					'id'			=> 'slider_timeout',
					'label'			=> __( 'Slider Timeout', 'issimple' ),
					'type'			=> 'input',
					'default'		=> 4000,
					'description'	=> __( 'Set the time between slide transitions in milliseconds.', 'issimple' ),
					'attributes'	=> array(
						'type'	=> 'number',
						'min'	=> 1000,
						'max'	=> 10000,
						'step'	=> 500
					)
				),
				// Pause on hover.
				array(
					'id'			=> 'pause_on_hover',
					'label'			=> __( 'Pause on hover', 'issimple' ),
					'type'			=> 'checkbox',
					'default'		=> 0,
					'description'	=> __( 'Pause the slideshow when the mouse moves over it.', 'issimple' )
				)
			)
		)
	) );

	$settings->set_all_defaults();
}
endif; // issimple_theme_options
add_action( 'init', 'issimple_theme_options', 1 );


/**
 * Get custom general theme option.
 *
 * @since	IS Simple 1.0
 *
 * @return	string/bool/array	Term required
 */
function issimple_get_option( $id ) {
	global $issimple_options;
	return $issimple_options[ $id ];
}


/**
 * Get custom style theme option.
 *
 * @since	IS Simple 1.0
 *
 * @return	string/bool/array	Term required
 */
function issimple_get_style_option( $id ) {
	global $issimple_style_options;
	return $issimple_style_options[ $id ];
}


/**
 * Get custom slider theme option.
 *
 * @since	IS Simple 1.0
 *
 * @return	string/bool/array	Term required
 */
function issimple_get_slider_option( $id ) {
	global $issimple_slider_options;
	return $issimple_slider_options[ $id ];
}


/**
 * Bootstrap Navbar Style to header navigation.
 *
 * @since	IS Simple 1.0
 *
 * @return	string	Bootstrap Navbar Style Class
 */
function bootstrap_header_navbar_style() {
	$navbar_style = issimple_get_style_option( 'header_navbar_style' );
	$navbar_style = ( isset( $navbar_style ) ) ? sanitize_html_class( $navbar_style ) : '';

	return apply_filters( 'issimple_header_navbar_style', $navbar_style );
}


/**
 * Bootstrap Navbar Fixing to header navigation.
 *
 * @since	IS Simple 1.0
 *
 * @return	string	Bootstrap Navbar Fixing Class.
 */
function bootstrap_header_navbar_fixing() {
	$navbar_fixing = issimple_get_style_option( 'header_navbar_fixing' );

	if ( isset( $navbar_fixing ) ) {
		$navbar_fixing =  ( $navbar_fixing != 'none' ) ? sanitize_html_class( $navbar_fixing ) : '';
	}

	return apply_filters( 'issimple_header_navbar_fixing', $navbar_fixing );
}


/**
 * Show header logo.
 *
 * @since	IS Simple 1.0
 */
function issimple_header_logo() {
	$logo_id	= issimple_get_option( 'header_logo' );

	$logo_atts	= wp_get_attachment_image_src( $logo_id );
	$logo_src	= $logo_atts[0];
	$logo_width	= $logo_atts[1];

	if ( empty( $logo_src ) ) return;

	?>
	<style type="text/css" id="issimple-header-logo-css">
		#name a {
			background: url( "<?php echo $logo_src; ?>" ) no-repeat 15px center; 
			padding-left: <?php echo 25 + $logo_width ?>px;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'issimple_header_logo' );


/**
 * Echo custom footer text.
 *
 * @since	IS Simple 1.0
 */
function issimple_footer_text() {
	$footer_text = sprintf( '%1$s %2$s %3$s %4$s %5$s.',
		issimple_get_option( 'footer_text' ),
		__( 'Powered by', 'issimple' ),
		sprintf( '<a href="%s" rel="nofollow" target="_blank">%s</a>',
			'https://github.com/id-design/is_simple_wp',
			'ID Design' ),
		__( 'on', 'issimple' ),
		sprintf( '<a href="%s" rel="nofollow" target="_blank">%s</a>',
			'http://wordpress.org/',
			'WordPress' )
	);

	echo do_shortcode( $footer_text );
}


$issimple_options = get_option( 'issimple_general_options' );
$issimple_style_options = get_option( 'issimple_style_options' );
$issimple_slider_options = get_option( 'issimple_slider_options' );