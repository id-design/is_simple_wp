<?php
/**
 * Limpeza e otimização de filtros, actions e estilos que são ingetados
 * automaticamente no template
 * 
 * @package Estúdio Viking
 * @since 1.0
 */


/**
 * Limpeza e otimização do <head>
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_cleanup_head() {
	// Feeds de categoria
	//remove_action( 'wp_head', 'feed_links_extra', 3 );
	
	// Feeds de Postagens e Comentários
	//remove_action( 'wp_head', 'feed_links', 2 );
	
	// Mostra os links para os Really Simple Discovery service endpoint, EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	
	// Mostra o link para o arquivo manifest do Windows Live Writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	
	// Index link
	remove_action( 'wp_head', 'index_rel_link' );
	
	// Previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	
	// Start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	
	// Mostra links relacionado para as postagens adjacentes a postagem atual
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	
	// Canonical
	//remove_action( 'wp_head', 'rel_canonical' );
	
	// Shortlink
	//remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
}
add_action( 'init', 'issimple_cleanup_head' );


/**
 * Filtros adicionais
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
// Remove meta tag generator do <head>
add_filter( 'the_generator', '__return_false' );

// Remove barra de administração
add_filter( 'show_admin_bar', '__return_false' );

// Permite que Shortcodes sejam executados nos resumos (apenas para resumos manuais)
add_filter( 'the_excerpt', 'do_shortcode' );

// Permite shortcodes nos widgets de texto
add_filter( 'widget_text', 'do_shortcode' );

// Remove tags <p> automáticas nos widgets de texto
add_filter( 'widget_text', 'shortcode_unautop' );


/**
 * Removendo Filtros
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
// Remove completamente tags <p> automáticas dos resumos de postagem
//remove_filter( 'the_excerpt', 'wpautop' );


/**
 * Remove estilos injetados para comentários recentes no wp_head()
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) )
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
}
add_filter( 'wp_head', 'issimple_remove_wp_widget_recent_comments_style', 1);


/**
 * Remove estilos injetados a partir de comentários recentes no wp_head()
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function my_remove_recent_comments_style() {
	global $wp_widget_factory;
	
	if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) )
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'my_remove_recent_comments_style' );


/**
 * Remove 'text/css' dos links de folhas de estilo no head
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function my_style_remove( $tag ) {
	return preg_replace( '~\s+type=["\'][^"\']++["\']~', '', $tag );
}
add_filter( 'style_loader_tag', 'my_style_remove' );


/**
 * Remove as dimensões de largura e altura das miniaturas
 * que evitam imagens fluidas em the_thumbnail
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function remove_img_dimensions( $html ) {
	return preg_replace( '/(width|height)=\"\d*\"\s/', "", $html);
}
add_filter( 'post_thumbnail_html', 'remove_img_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_img_dimensions', 10 );


/**
 * Remove valores invalidos do atributo "rel" na lista de categorias
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function remove_category_rel_from_category_list( $thelist ) {
    return str_replace( 'rel="category tag"', 'rel="tag"', $thelist );
}
add_filter( 'the_category', 'remove_category_rel_from_category_list' );



