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
 * Configura o valor da largura do conteúdo baseado no design do tema
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
if ( ! isset( $content_width ) ) $content_width = 770;	/* pixels */

function issimple_content_width() {
	if ( is_page_template( 'full-width.php' ) ) :
		global $content_width;
		$content_width = 1170;	/* pixels */
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
 * IS Simple Features Support
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_setup() {
	// Language Support
	load_theme_textdomain( 'issimple', THEME_PATH . '/languages' );
	
	// Habilita RSS feed links de postagens e comentários para o <head>
	add_theme_support( 'automatic-feed-links' );
	
	// Enable tag <title> in wp_head
	add_theme_support( 'title-tag' );
	
	// Thumbnails Support
    add_theme_support( 'post-thumbnails' );
		// Large Thumbnail to Full Page Template
		add_image_size( 'large-full-page', 1130, '', true );
		// Large Thumbnail
		add_image_size( 'large', 730, '', true );
		// Medium Thumbnail
		add_image_size( 'medium', 500, '', true );
		// Small Thumbnail
		add_image_size( 'small', 250, '', true );
		// Miniatura personalizada. Uso: the_post_thumbnail( 'featured-size' );
		add_image_size( 'featured-size', 770, 300, true );
		// Miniatura personalizada. Uso: the_post_thumbnail( 'full-page-size' );
		add_image_size( 'featured-full-page-size', 1200, 500, true );
		// Miniatura personalizada. Uso: the_post_thumbnail( 'featured-slider-size' );
		add_image_size( 'featured-slider-size', 1920, 500, true );
	
	// Register Nav Menus
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
	
	// Post Formats Support
	//add_theme_support( 'post-formats', array(
	//	'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'
	//) );
	
	// HTML5 Support
	add_theme_support( 'html5', array(
		'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'widget'
	) );
	
	// Set Custom Background Supporte
	add_theme_support( 'custom-background', array(
		'default-color'			=> 'eee',
		'default-attachment'	=> 'scroll'
	) );

	// Require to Custom Header Support
    require INCLUDES_PATH . '/custom-header.php';
	
	// Custom Editor Style
	add_editor_style( array( 'css/editor-style.css', ) );
}
endif; // issimple_setup
add_action( 'after_setup_theme', 'issimple_setup' );


/**
 * Registro da áreas de widgets
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
 * Print stylesheets in the tag <head>
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
 * Print scripts
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
 * Adiciona a imagem destacada dos artigos como background nos elementos
 * da navegação dos posts
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_post_nav_background() {
	if ( ! is_single() ) return;
	
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';
	
	if ( is_attachment() && 'attachment' == $previous->post_type ) return;

	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) :
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-size' );
		$prevthumb = $prevthumb[0];
		$css .= '
			.post-navigation .nav-previous {
				background-image: url(' . esc_url( $prevthumb ) . ');
			}
		';
	endif; // $previous

	if ( $next && has_post_thumbnail( $next->ID ) ) :
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-size' );
		$nextthumb = $nextthumb[0];
		$css .= '
			.post-navigation .nav-next {
				background-image: url(' . esc_url( $nextthumb ) . ');
			}
		';
	endif; // $next

	wp_add_inline_style( 'issimple_style', $css );
}
add_action( 'wp_enqueue_scripts', 'issimple_post_nav_background' );


/**
 * Chamada para o slider
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function get_slider() {
	if ( is_home() || is_front_page() || is_archive() ) get_template_part( 'slider' );
}


/**
 * Gravatar personalizado
 * Acesse em Configurações > Discussão
 * ----------------------------------------------------------------------------
 * Obs.: Não funciona com imagens em servidor local (wampserver, xamp, etc..).
 * Quando o tema estiver online irá funcionar.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_gravatar( $avatar_defaults ) {
	$my_avatar = IMAGES_URI . '/gravatar.png';
	$avatar_defaults[ $my_avatar ] = "Viking Gravatar";
	return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'issimple_gravatar' );


/**
 * Comentários 'Threaded'
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
 * Descrição para os itens dos Nav Menus
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'header-menu' == $args->theme_location && $item->description ) :
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-desc">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	endif;
	
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'issimple_nav_description', 10, 4 );


/**
 * Classe para os links dos Nav Menus
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function classes_nav_item( $classes, $item, $args, $depth ) {
	$classes[] = ( $depth > 0 ) ? 'sub-menu-item' : '';
	
	return $classes;
}
//add_filter( 'nav_menu_css_class', 'classes_nav_item', 10, 4 );


/**
 * Classe para os links dos Nav Menus
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function class_nav_link( $atts, $item, $args, $depth  ) {
	$atts['class']  = ( $depth <= 0 ) ? 'menu-link' : 'menu-link sub-menu-link';
	
	return $atts;
}
//add_filter( 'nav_menu_link_attributes', 'class_nav_link', 10, 4 );


/**
 * Remove o "id" dos itens dos Nav Menus
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
add_filter( 'nav_menu_item_id', '__return_false' );

/**
 * Inclusão de recursos ao tema
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
// Limpeza e otimização do tema
require_once INCLUDES_PATH . '/cleanup.php';
// Shortcodes úteis no tema
require_once INCLUDES_PATH . '/shortcodes.php';
// Funções para algumas utilidades básicas no tema
require_once INCLUDES_PATH . '/utilities.php';
// Funções exclusivas do tema
require_once INCLUDES_PATH . '/template-tags.php';
// Funções para incrementar o formulário de contato no tema ou post
require_once INCLUDES_PATH . '/issimple-contact-form.php';