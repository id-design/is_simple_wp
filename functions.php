<?php
/**
 * IS Simple functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */

// Setting Constants
defined( 'THEME_PATH' ) or define( 'THEME_PATH', get_template_directory() );
defined( 'THEME_URI' ) or define( 'THEME_URI', get_template_directory_uri() );
define( 'ASSETS_PATH', THEME_PATH . '/assets' );
define( 'ASSETS_URI', THEME_URI . '/assets' );
define( 'STYLES_PATH', ASSETS_PATH . '/css' );
define( 'STYLES_URI', ASSETS_URI . '/css' );
define( 'IMAGES_PATH', ASSETS_PATH . '/img' );
define( 'IMAGES_URI', ASSETS_URI . '/img' );
define( 'ICONS_PATH', ASSETS_PATH . '/icon' );
define( 'ICONS_URI', ASSETS_URI . '/icon' );
define( 'SCRIPT_PATH', ASSETS_PATH . '/js' );
define( 'SCRIPT_URI', ASSETS_URI . '/js' );
define( 'INCLUDES_PATH', THEME_PATH . '/inc' );
define( 'INCLUDES_URI', THEME_URI . '/inc' );


/**
 * Set the content width based on the theme's design and stylesheet.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
if ( ! isset( $content_width ) ) $content_width = 730;	/* pixels */

function issimple_content_width() {
	if ( is_full_page_template() ) :
		global $content_width;
		$content_width = 1130;	/* pixels */
	endif;
}
add_action( 'template_redirect', 'issimple_content_width' );


/**
 * Require IS Simple Classes
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
require_once INCLUDES_PATH . '/classes/class-bootstrap-nav.php';


/**
 * IS Simple Widgets
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
require_once INCLUDES_PATH . '/widgets/class-widget-issimple-recent-posts.php';
require_once INCLUDES_PATH . '/widgets/class-widget-issimple-recent-comments.php';
require_once INCLUDES_PATH . '/widgets/class-widget-issimple-categories.php';
require_once INCLUDES_PATH . '/widgets/class-widget-issimple-pages.php';
require_once INCLUDES_PATH . '/widgets/class-widget-issimple-archives.php';
require_once INCLUDES_PATH . '/widgets/class-widget-issimple-meta.php';
require_once INCLUDES_PATH . '/widgets/class-widget-issimple-calendar.php';
require_once INCLUDES_PATH . '/widgets/class-widget-issimple-tag-cloud.php';


if ( ! function_exists( 'issimple_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 * 
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_setup() {
	/**
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on twentyfifteen, use a find and replace
	 * to change 'twentyfifteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'issimple', THEME_PATH . '/languages' );
	
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	
	/**
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	
	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 * 
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
    add_theme_support( 'post-thumbnails' );
		// Default Post Thumbnail size
		set_post_thumbnail_size( 770, 300, true );
		// Large Thumbnail to Full Page Templates
		add_image_size( 'large-full-page', 1130, '', true );
		// Large Thumbnail
		add_image_size( 'large', 730, '', true );
		// Medium Thumbnail
		add_image_size( 'medium', 500, '', true );
		// Small Thumbnail
		add_image_size( 'small', 250, '', true );
		// Featured Thumbnail. Uses: the_post_thumbnail( 'featured-size' );
		add_image_size( 'featured-size', 770, 300, true );
		// Featured Full Page Thumbnail. Uses: the_post_thumbnail( 'full-page-size' );
		add_image_size( 'featured-full-page-size', 1200, 500, true );
		// Featured Slider Thumbnail. Uses: the_post_thumbnail( 'featured-slider-size' );
		add_image_size( 'featured-slider-size', 1920, 500, true );
	
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'header-menu' => __( 'Header Menu', 'issimple' ),
		'social-menu' => __( 'Social Menu', 'issimple' ),
	) );
	
	// Add support for Infinite Scroll of JetPack.
	add_theme_support(
		'infinite-scroll',
		array(
			'type'           => 'scroll',
			'footer_widgets' => false,
			'container'      => 'main-content',
			'wrapper'        => false,
			'render'         => false,
			'posts_per_page' => get_option( 'posts_per_page' )
		)
	);
	
	/**
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	//add_theme_support( 'post-formats', array(
	//	'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'
	//) );
	
	/**
	 * Switch default core markup for comment-list, comment-form, search-form, gallery,
	 * caption and widget to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'widget'
	) );
	
	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', array(
		'default-color'			=> 'eee',
		'default-attachment'	=> 'scroll'
	) );

	// Implement the Custom Header feature.
    require INCLUDES_PATH . '/custom-header.php';
	
	/**
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'assets/css/editor-style.css' ) );
}
endif; // issimple_setup
add_action( 'after_setup_theme', 'issimple_setup' );


/**
 * Register widget area.
 * 
 * @since IS Simple 1.0
 * 
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 * ----------------------------------------------------------------------------
 */
function issimple_widgets_init() {
	// Define Sidebar Widget Area
	register_sidebar( array(
		'name'			=> __( 'Sidebar Widget Area', 'issimple' ),
		'id'			=> 'sidebar-widget-area',
		'description'	=> __( 'Add widgets here to appear in your sidebar.', 'issimple' ),
		'before_widget'	=> '<aside id="%1$s" class="widget panel panel-default %2$s">',
		'before_title'	=> '<div class="panel-heading"><h3 class="widget-title panel-title">',
		'after_title'	=> '</h3></div>',
		'after_widget'	=> '</aside>'
	) );
	
	// Define Footer Widget Area 1
	register_sidebar( array(
		'name'			=> __( 'Footer Widget Area 1', 'issimple' ),
		'id'			=> 'footer-widget-area-1',
		'description'	=> __( 'Add widgets here to appear in your sidebar.', 'issimple' ),
		'before_widget'	=> '<aside id="%1$s" class="widget panel panel-default %2$s">',
		'before_title'	=> '<div class="panel-heading"><h3 class="widget-title panel-title">',
		'after_title'	=> '</h3></div>',
		'after_widget'	=> '</aside>'
	) );
	
	// Define Footer Widget Area 2
	register_sidebar( array(
		'name'			=> __( 'Footer Widget Area 2', 'issimple' ),
		'id'			=> 'footer-widget-area-2',
		'description'	=> __( 'Add widgets here to appear in your sidebar.', 'issimple' ),
		'before_widget'	=> '<aside id="%1$s" class="widget panel panel-default %2$s">',
		'before_title'	=> '<div class="panel-heading"><h3 class="widget-title panel-title">',
		'after_title'	=> '</h3></div>',
		'after_widget'	=> '</aside>'
	) );
	
	// Define Footer Widget Area 3
	register_sidebar( array(
		'name'			=> __( 'Footer Widget Area 3', 'issimple' ),
		'id'			=> 'footer-widget-area-3',
		'description'	=> __( 'Add widgets here to appear in your sidebar.', 'issimple' ),
		'before_widget'	=> '<aside id="%1$s" class="widget panel panel-default %2$s">',
		'before_title'	=> '<div class="panel-heading"><h3 class="widget-title panel-title">',
		'after_title'	=> '</h3></div>',
		'after_widget'	=> '</aside>'
	) );
}
add_action( 'widgets_init', 'issimple_widgets_init' );


/**
 * Enqueue styles.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_styles() {
	// Bootstrap
	wp_enqueue_style( 'bootstrap', STYLES_URI . '/bootstrap.min.css', array(), null, 'all' );
	
	// Bootstrap theme
	wp_enqueue_style( 'bootstrap-theme', STYLES_URI . '/bootstrap-theme.min.css', array(), null, 'all' );
	
	// LightBox
	wp_enqueue_style( 'lightbox', STYLES_URI . '/lightbox.css', array(), null, 'all' );
	
	// Font Awesome
	wp_enqueue_style( 'font-awesome', ASSETS_URI . '/fonts/font-awesome/css/font-awesome.min.css', array(), null, 'all' );
	
	// CSS Principal
	wp_enqueue_style( 'issimple_style', STYLES_URI . '/style.css', array(), null, 'all' );
}
add_action( 'wp_enqueue_scripts', 'issimple_styles' );


/**
 * Enqueue scripts.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_header_scripts() {
	if ( ! is_admin() ) :
		// JQuery
		wp_enqueue_script( 'jquery' );
		
		// JCycle 2
		wp_enqueue_script( 'jcycle2', SCRIPT_URI . '/lib/jcycle2.js', array(), null, true );
		
		// Lightbox 2
		wp_enqueue_script( 'lightbox', SCRIPT_URI . '/lib/lightbox.js', array(), null, true );
		
		// Bootstrap
		wp_enqueue_script( 'bootstrap', SCRIPT_URI . '/lib/bootstrap.min.js', array(), null, true );
		
		// Load Thread comments WordPress script.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		
		// Scripts personalizados do tema
		//wp_enqueue_script( 'issimple_scripts', SCRIPT_URI . '/general.js', array(), null, true );
		wp_enqueue_script( 'issimple_scripts', SCRIPT_URI . '/main.js', array(), null, true );
	endif;
}
add_action( 'init', 'issimple_header_scripts');


/**
 * Return true if the post/page uses full width template.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function is_full_page_template() {
	if ( is_page_template( 'page-templates/full-width-post.php' )
		|| is_page_template( 'page-templates/full-width-page.php' ) ) {
		return true;
	} else {
		return false;
	}
}


/**
 * Print slider.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function get_slider() {
	if ( is_home() || is_front_page() || is_archive() ) get_template_part( 'slider' );
}


/**
 * Custom Gravatar.
 * Setup in Settings > Discussion.
 * ----------------------------------------------------------------------------
 * Obs.: Don't work in local server (wampserver, xamp, etc..).
 * When the theme is online will work.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_gravatar( $avatar_defaults ) {
	$my_avatar = IMAGES_URI . '/gravatar.png';
	$avatar_defaults[ $my_avatar ] = 'IS Simple Gravatar';
	return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'issimple_gravatar' );


/**
 * Threaded Comments.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function enable_threaded_comments() {
	if ( ! is_admin() ) :
		if ( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1 ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	endif;
}
add_action( 'get_header', 'enable_threaded_comments' );


/**
 * Inclusão de recursos ao tema
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
// Funções para algumas utilidades básicas no tema
require_once INCLUDES_PATH . '/utilities.php';
// Bootstrap functions
require_once INCLUDES_PATH . '/bootstrap-functions.php';
// Limpeza e otimização do tema
require_once INCLUDES_PATH . '/cleanup.php';
// Shortcodes úteis no tema
require_once INCLUDES_PATH . '/shortcodes.php';
// Funções exclusivas do tema
require_once INCLUDES_PATH . '/template-tags.php';
// Funções para incrementar o formulário de contato no tema ou post
require_once INCLUDES_PATH . '/issimple-contact-form.php';