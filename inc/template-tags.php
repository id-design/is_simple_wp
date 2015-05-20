<?php
/**
 * Tags de modelo personalizadas para este tema
 * 
 * Eventualmente, algumas das funcionalidades aqui poderia ser substituída
 * por características do wordpress
 * 
 * @package Estúdio Viking
 * @since 1.0
 */


/**
 * Favicon personalizado
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function my_favicon(){
	$favicon 			= ICONS_URI . '/favicon.ico';
	$apple_icons 		= issimple_readdir( ICONS_PATH, 'png' );
	$apple_icons_name 	= array_keys( $apple_icons );
	$apple_icons_count 	= count( $apple_icons_name );
	$apple_icons_size 	= str_replace( '-', '', $apple_icons_name);
	$apple_icons_size 	= str_replace( 'appletouchicon', '', $apple_icons_size);
	
	$favicons  = '<!-- Favicon IE 9 -->';
	$favicons .= '<!--[if lte IE 9]><link rel="icon" type="image/x-icon" href="' . $favicon . '" /> <![endif]-->';
	
	$favicons .= '<!-- Favicon Outros Navegadores -->';
	$favicons .= '<link rel="shortcut icon" type="image/png" href="' . $favicon . '" />';
	
	$favicons .='<!-- Favicon Apple -->';
	
	for ( $i = 0; $i < $apple_icons_count; $i++ ) :
		$size = ( $apple_icons_size[$i] == '' ) ? '' : ' sizes="' . $apple_icons_size[$i] . '"';
		
		$favicons .='<link rel="apple-touch-icon"' . $size . ' href="' . ICONS_URI . '/' . $apple_icons_name[$i] . '.png" />';
	endfor;
	
	echo $favicons;
}
//add_action( 'wp_head', 'my_favicon' );
//add_action( 'admin_head', 'my_favicon' );
//add_action( 'login_head', 'my_favicon' );


/**
 * Ícone personalizado para a tela de login
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_login_icon(){
	$login_icon_url    = IMAGES_URI . '/issimple-logo.svg';
	$login_icon_width  = 100;
	$login_icon_height = 100;
	
	$output  = '
		<style id="issimple_login_icon" type="text/css">
			.login h1 a {
				background-image: url( "' . $login_icon_url . '" );
				background-size: ' . $login_icon_width . 'px auto;
				width: ' . $login_icon_width . 'px;
				height: ' . $login_icon_height . 'px;
			}
		</style>
	';
	
	echo $output;
}
add_action( 'login_enqueue_scripts', 'issimple_login_icon' );


/**
 * Título das páginas
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function my_wp_title( $title, $sep ) {
	$site_name = get_bloginfo( 'name', 'display' );
	$site_description = get_bloginfo( 'description', 'display' );
	
	if ( is_page() || is_archive() || is_single() ) $title .= ' - ' . $site_description;
	
	return str_replace( "$site_name $sep $site_description", "$site_name - $site_description", $title );
}
add_filter( 'wp_title', 'my_wp_title', 10, 2 );


/**
 * Adiciona o nome da página como classe no elemento <body>
 * Créditos: Starkers Wordpress Theme
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function add_name_to_body_class( $classes ) {
	global $post;
	
	if ( is_home() || is_page( 'home' ) ) {
		$key = array_search( 'blog', $classes );
		if ( $key > -1 ) unset( $classes[$key] );
	} elseif ( is_page() || is_singular() ) {
		$classes[] = sanitize_html_class( $post->post_name );
	}
	
	return $classes;
}
add_filter( 'body_class', 'add_name_to_body_class' );


/**
 * Adiciona o atributo 'role' aos menus de navegação
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function add_role_navigation_to_nav_menu( $nav_menu, $args ) {
	if( 'nav' != $args->container ) return $nav_menu;
	
	return str_replace( '<'. $args->container, '<'. $args->container . ' role="navigation"', $nav_menu );
}
add_filter( 'wp_nav_menu', 'add_role_navigation_to_nav_menu', 10, 2 );


/**
 * Títulos personalizados para páginas arquivos
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function my_archive_title( $title ) {
	if ( is_category() ) :
		$title = sprintf( __( 'Posts in category: %s', 'issimple' ), single_cat_title( '', false ) );
	elseif ( is_tag() ) :
		$title = sprintf( __( 'Posts in tag: %s', 'issimple' ), single_tag_title( '', false ) );
	elseif ( is_author() ) :
		$title = sprintf( __( 'Posts of the author: %s', 'issimple' ), get_the_author() );
	elseif ( is_day() ) :
		$title = sprintf( __( 'Posts of the day: %s', 'issimple' ), get_the_date( get_option( 'date_format' ) ) );
	elseif ( is_month() ) :
		$title = sprintf( __( 'Posts of the month: %s', 'issimple' ), get_the_date( 'F \/ Y' ) );
	elseif ( is_year() ) :
		$title = sprintf( __( 'Posts of the year: %s', 'issimple' ), get_the_date( 'Y' ) );
	endif;
	
	return $title;
}
add_filter( 'get_the_archive_title', 'my_archive_title' );


/**
 * Paginação de Artigos
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_post_pagination() {
	the_posts_pagination( array(
		'prev_text'          => '<i class="fa fa-arrow-left"></i> ' . '<span class="meta-nav screen-reader-text">' . __( 'Previous page', 'issimple' ) . ' </span>',
		'next_text'          => '<span class="meta-nav screen-reader-text">' . __( 'Next page', 'issimple' ) . ' </span>' . ' <i class="fa fa-arrow-right"></i>',
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'issimple' ) . ' </span>',
	) );
	
	echo '<!-- .pagination -->';
}


/**
 * Coleta informações da imagem destacada da postagem
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_get_thumb_meta( $thumbnail_id, $meta ) {
	$thumb = get_post( $thumbnail_id );
	
	$thumb = array(
		'alt'			=> get_post_meta( $thumb->ID, '_wp_attachment_image_alt', true ),
		'caption'		=> $thumb->post_excerpt,
		'description'	=> $thumb->post_content,
		'href'			=> get_permalink( $thumb->ID ),
		'src'			=> $thumb->guid,
		'title'			=> $thumb->post_title
	);
	
	return $thumb[$meta];
}


/**
 * Miniaturas personalizadas para as postagens
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_post_thumb( $size = 'post-size' ) {
	$thumb_id = get_post_thumbnail_id();
	
	$thumb_link_full = wp_get_attachment_image_src( $thumb_id, 'full' );
	$thumb_link_full = $thumb_link_full[0];
	
	$thumb_caption = issimple_get_thumb_meta( $thumb_id, 'caption' );
	?>
	
	<figure class="post-thumb<?php if ( is_page() ) : echo ' col_4'; endif; ?>">
		<a class="link-thumb img-link"
		   href="<?php if ( is_single() ) : echo $thumb_link_full; else : the_permalink(); endif; ?>"
		   title="<?php the_title(); ?>"
		   <?php if ( is_single() ) : ?>data-lightbox="post-<?php the_ID(); ?>" data-title="<?php echo $thumb_caption; ?>"<?php endif; ?>>
			<?php the_post_thumbnail( $size, array( 'class' => 'img-thumb' ) ); ?>
		</a>
	</figure><!-- .post thumbnail -->
	
	<?php
}


/**
 * Detalhes personalizadas para as postagens
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_post_details() {
	$post = get_post();
	
	foreach ( ( array ) get_the_category( $post->ID ) as $categ ) :
		$categ_slug = sanitize_html_class( $categ->slug, $categ->term_id );
	endforeach;
	
	?>
	<section class="post-details">
		<?php issimple_post_thumb(); ?>
		
		<span class="post-categ shadow categ-<?php echo $categ_slug; ?>"><?php the_category( ', ' ); ?></span>
		
		<?php if ( is_single() ) : ?>
			<div class="post-details-bar">
				<span class="post-author"><?php the_author_posts_link(); ?></span> | 
				<span class="post-date"><?php issimple_date_link(); ?></span> | 
				<span class="post-comments"><?php issimple_comment_link(); ?></span>
			</div>
		<?php endif; ?>
	</section><!-- .post details -->
	<?php
		edit_post_link( __( 'Edit', 'issimple' ), '<span class="edit-link">', '</span>' );
}


/**
 * Cria datas como links
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_date_link() {
	$year		= get_the_time( 'Y' );
	
	$month		= get_the_time( 'm' );
	$month_name	= get_the_time( 'F' );
	$month_date	= get_the_time( 'F \/ Y' );
	
	$day		= get_the_time( 'd' );
	$day_date	= get_the_time( get_option( 'date_format' ) );
	
	$time_title	= get_the_time( 'l, ' . get_option( 'date_format' ) . ', h:ia' );
	$time_datetime	= esc_attr( get_the_date( 'c' ) );
	
	$day_link	= '<a href="' . get_day_link( $year, $month, $day ) . '" title="' . sprintf( __( 'Posts of %s', 'issimple' ), $day_date ) . '">' . $day . '</a>';
	$month_link	= '<a href="' . get_month_link( $year, $month ) . '" title="' . sprintf( __( 'Posts of %s', 'issimple' ), $month_date ) . '">' . $month_name . '</a>';
	$year_link	= '<a href="' . get_year_link( $year ) . '" title="' . sprintf( __( 'Posts of %s', 'issimple' ), $year ) . '">' . $year . '</a>';
	
	
	
	$output  = sprintf( '<time class="date" title="%s" datetime="%s">' , $time_title, $time_datetime );
	$output .= sprintf( __( '%s of %s of %s', 'issimple' ), $day_link, $month_link, $year_link );
	$output .= '</time>';
	
	echo $output;
}


/**
 * Link para os comentários
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_comment_link() {
	if ( comments_open( get_the_ID() ) )
		comments_popup_link(
			__( 'Leave your thoughts', 'issimple' ),
			__( '1 comment', 'issimple' ),
			__( '% comments', 'issimple' )
		);
}


/**
 * Criar resumos personalizados
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_excerpt( $length_callback = '', $more_callback = '' ) {
	global $post;
	
    if ( function_exists( $length_callback ) ) {
    	add_filter( 'excerpt_length', $length_callback );
	}
	
	if ( function_exists( $more_callback ) ) {
		add_filter( 'excerpt_more', $more_callback );
	}
	
	the_excerpt();
}


/**
 * Tamanho em palavras para os resumos personalizados.
 * Uso: issimple_excerpt( 'issimple_index' );
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_index( $length ) {
	return 50;
}


/**
 * Tamanho em palavras para os resumos personalizados do slider.
 * Uso: issimple_excerpt( 'issimple_length_slider' );
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_length_slider( $lenght ) {
	return 10;
}


/**
 * Cria link Ver Artigo personalizado para a postagem
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_view_article( $more ) {
	global $post;
	
	$tagmore  = '...</p><p class="view-article">';
	$tagmore .= '<a class="button" ';
	$tagmore .= 'href="' . get_permalink( $post->ID ) . '" ';
	$tagmore .= 'title ="Ver artigo: ' . get_the_title() . '">';
	$tagmore .= 'Ver artigo';
	$tagmore .= '</a>';
	
	return $tagmore;
}
add_filter( 'excerpt_more', 'issimple_view_article' );


/**
 * Navegação dos comentários
 * 
 * @since Estúdio Viking 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_comment_nav() {
	// Há comentários para navegação?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav class="nav comment-nav" role="navigation">
			<h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'issimple' ); ?></h2>
			<div class="nav-links">
				<?php
					if ( $prev_link = get_previous_comments_link( __( 'Older comments', 'issimple' ) ) ) :
						printf( '<div class="nav-previous">%s</div>', $prev_link );
					endif;
	
					if ( $next_link = get_next_comments_link( __( 'Newer comments', 'issimple' ) ) ) :
						printf( '<div class="nav-next">%s</div>', $next_link );
					endif;
				?>
			</div><!-- .nav-links -->
		</nav><!-- .comment-nav -->
	<?php endif;
}




