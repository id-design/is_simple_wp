<?php
/**
 * Tags de modelo personalizadas para este tema
 * 
 * Eventualmente, algumas das funcionalidades aqui poderia ser substituída
 * por características do wordpress
 * 
 * @package IS Simple
 * @since 1.0
 */


/**
 * Favicon personalizado
 * 
 * @since IS Simple 1.0
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
 * @since IS Simple 1.0
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
//add_action( 'login_enqueue_scripts', 'issimple_login_icon' );


/**
 * Título das páginas
 * 
 * @since IS Simple 1.0
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
 * @since IS Simple 1.0
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
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function add_role_navigation_to_nav_menu( $nav_menu, $args ) {
	if( 'nav' != $args->container ) return $nav_menu;
	
	return str_replace( '<'. $args->container, '<'. $args->container . ' role="navigation"', $nav_menu );
}
add_filter( 'wp_nav_menu', 'add_role_navigation_to_nav_menu', 10, 2 );


/**
 * Display a search form with custom attributes "id" and "class"
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_content_search_form( $form_id = false, $form_class = false ) {
	$search_form_id = ( false !== $form_id ) ? $form_id . '-search-form' : 'search-form';
	$search_form_class = ( false !== $form_class ) ? ' class="' . $form_class . '"' : '';
	?>
	
	<form id="<?php echo $search_form_id; ?>"<?php echo $search_form_class; ?> method="get" action="<?php echo home_url( '/' ); ?>" role="search">
		<div class="form-group">
			<label for="s" class="control-label sr-only"><?php _e( 'Search', 'issimple' ); ?></label>
			<div class="input-group">
				<input class="form-control" type="search" name="s" placeholder="<?php _e( 'Search', 'issimple' ); ?>">
				<span class="input-group-btn">
					<button class="btn btn-default" type="submit" role="button"><span class="sr-only"><?php _e( 'Search', 'issimple' ); ?></span> <span class="glyphicon glyphicon-search"></span></button>
				</span>
			</div>
		</div>
	</form><!-- #<?php echo $search_form_id; ?> -->
	
	<?php
}


/**
 * Primary class based on page template
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_primary_class() {
	if ( is_page_template( 'full-width.php' ) ) :
		echo 'col-sm-12 col-md-12';
	else:
		echo 'col-sm-8 col-md-8';
	endif;
}

/**
 * Títulos personalizados para páginas arquivos
 * 
 * @since IS Simple 1.0
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
 * Posts Pagination
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_post_pagination() {
	issimple_wp_bootstrap_pagination( array( 'type' => 'pager' ) );
	
	echo '<!-- .post-pagination -->';
}


/**
 * Custom Bootstrap Posts Pagination
 * 
 * A custom WordPress numbered pagination function to fully implement the
 * Bootstrap 3.x pagination/pager style in a custom theme.
 * Inspired by the function wp_bootstrap_pagination
 * (@link https://github.com/talentedaamer/Bootstrap-wordpress-pagination),
 * created by OOPThemes and with the licence GPLv2.
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_wp_bootstrap_pagination( $args = array() ) {
	global $wp_query;
	
	// Prevent show pagination number if Infinite Scroll of JetPack is active.
	if ( ! isset( $_GET[ 'infinity' ] ) ) {
		
		// Sets the pagination args.
		$defaults = array(
			'container'				=> 'nav',
			'container_id'			=> '',
			'container_class'		=> '',
			'screen_reader_text'	=> __( 'Posts navigation', 'issimple' ),
			'type'					=> 'pagination',
			'pagination_id'			=> '',
			'pagination_class'		=> '',
			'range'					=> 4,
			'custom_query'			=> false,
			'echo'					=> true,
			'previous_text'			=> __( '<i class="glyphicon glyphicon-chevron-left"></i> <span class="sr-only">Previous</span>', 'issimple' ),
			'next_text'				=> __( '<span class="sr-only">Next</span> <i class="glyphicon glyphicon-chevron-right"></i>', 'issimple' ),
			'first_link_text'		=> __( 'First', 'issimple' ),
			'last_link_text'		=> __( 'Last', 'issimple' )
		);
		
		$args = wp_parse_args( $args, apply_filters( 'issimple_wp_bootstrap_pagination_defaults', $defaults ) );
		
		$args['range'] = (int) $args['range'] - 1;
		
		if ( ! $args['custom_query'] ) $args['custom_query'] = $wp_query;
		
		$count = (int) $args['custom_query']->max_num_pages;
		$page  = intval( get_query_var( 'paged' ) );
		$ceil  = ceil( $args['range'] / 2 );
		
		if ( $count <= 1 ) return false;
		
		if ( ! $page ) $page = 1;
		
		if ( $count > $args['range'] ) {
			if ( $page <= $args['range'] ) {
				$min = 1;
				$max = $args['range'] + 1;
			} elseif ( $page >= ( $count - $ceil ) ) {
				$min = $count - $args['range'];
				$max = $count;
			} elseif ( $page >= $args['range'] && $page < ( $count - $ceil ) ) {
				$min = $page - $ceil;
				$max = $page + $ceil;
			}
		} else {
			$min = 1;
			$max = $count;
		}
		
		$output = '';
		
		if ( isset( $args['screen_reader_text'] ) ) {
			$output .= '<h2 class="sr-only">' . $args['screen_reader_text'] . '</h2>';
		}
		
		$pagination_id = ( $args['pagination_id'] ) ? ' id="' . $args['pagination_id'] . '"' : '';
		
		$pagination_class = ( ! empty( $args['pagination_class'] ) ) ? $args['type'] . ' ' . $args['pagination_class'] : $args['type'];
		$pagination_class = ' class="' . $pagination_class . '"';
		
		$output .= '<ul' . $pagination_id . $pagination_class . '>';
		
		$previous = intval( $page ) - 1;
		$previous = esc_attr( get_pagenum_link( $previous ) );
		if ( $previous && ( 1 != $page ) ) {
			$output .= '<li class="previous"><a href="' . $previous . '" title="' . __( 'Previous page', 'issimple') . '">' . $args['previous_text'] . '</a></li>';
		} else {
			$output .= '<li class="previous disabled"><span>' . $args['previous_text'] . '</span></li>';
		}
		
		$firstpage = esc_attr( get_pagenum_link( 1 ) );
		if ( $firstpage && ( 1 != $page ) && ( 1 < $min ) ) 
			$output .= '<li><a href="' . $firstpage . '" title="' . __( 'Go to first page', 'issimple') . '">' . 1 . '</a></li>';
		
		if ( ! empty( $min ) && ! empty( $max ) ) {
			if ( ( $min - 1 ) > 1 )
				$output .= '<li class="dots disabled"><span>' . __( '&hellip;' ) . '</span></li>';
			
			for( $i = 1; $i <= $count; $i++ ) {
				if ( $page == $i ) {
					$output .= '<li class="active"><span class="active">' . $i . '</span></li>';
				} elseif ( $i >= $min && $i <= $max ) {
					$output .= sprintf( '<li><a href="%1$s" title="' . __( 'Go to page %2$d', 'issimple') . '">%2$d</a></li>', esc_attr( get_pagenum_link( $i ) ), $i );
				}
			}
			
			if ( ( $max + 1 ) < $count )
				$output .= '<li class="dots disabled"><span>' . __( '&hellip;' ) . '</span></li>';
		}
		
		$lastpage = esc_attr( get_pagenum_link( $count ) );
		if ( $lastpage && ( $max < $count ) )
			$output .= '<li><a href="' . $lastpage . '" title="' . __( 'Go to last page', 'issimple') . '">' . $count . '</a></li>';
		
		$next = intval( $page ) + 1;
		$next = esc_attr( get_pagenum_link( $next ) );
		if ( $next && ( $count != $page ) ) {
			$output .= '<li class="next"><a href="' . $next . '" title="' . __( 'Next page', 'issimple') . '">' . $args['next_text'] . '</a></li>';
		} else {
			$output .= '<li class="next disabled"><span>' . $args['next_text'] . '</span></li>';
		}
		
		$output .= '</ul>';
		
		if ( isset( $args['container'] ) ) {
			$container_id = ( ! empty( $args['container_id'] ) ) ? ' id="' . $args['container_id'] . '"' : '';
			$container_class = ( ! empty( $args['container_class'] ) ) ? ' class="post-pagination ' . $args['container_class'] . '"' : ' class="post-pagination"';
			
			$output = '<' . $args['container'] . $container_id . $container_class . '>' . $output . '</' . $args['container'] . '>';
		}
		
		if ( $args['echo'] ) {
			echo $output;
		} else {
			return $output;
		}
	}
}


/**
 * Coleta informações da imagem destacada da postagem
 * 
 * @since IS Simple 1.0
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
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_post_featured_thumb( $size = 'featured-size' ) {
	$thumb_id = get_post_thumbnail_id();
	
	$thumb_link_full = wp_get_attachment_image_src( $thumb_id, 'full' );
	$thumb_link_full = $thumb_link_full[0];
	
	$thumb_caption = issimple_get_thumb_meta( $thumb_id, 'caption' );
	
	if ( has_post_thumbnail() ) :
		?>
		
		<figure class="post-featured-thumb">
			<a class="featured-link img-link"
			   href="<?php if ( is_single() ) : echo $thumb_link_full; else : the_permalink(); endif; ?>"
			   title="<?php the_title(); ?>"
			   <?php if ( is_single() ) : ?>data-lightbox="post-<?php the_ID(); ?>" data-title="<?php echo $thumb_caption; ?>"<?php endif; ?>>
				<?php the_post_thumbnail( $size, array( 'class' => 'featured-img img-responsive', 'alt' => get_the_title() ) ); ?>
			</a>
		</figure><!-- .post-featured-thumb -->
		
		<?php
	endif;
}


/**
 * Detalhes personalizadas para as postagens
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_entry_meta() {
	if ( 'post' == get_post_type() ) :
		?>
		<p class="entry-meta bg-default">
			<span class="entry-author"><span class="glyphicon glyphicon-user"></span> <?php the_author_posts_link(); ?></span>
			<span class="entry-categ"><span class="glyphicon glyphicon-folder-open"></span> <?php the_category( ', ' ); ?></span> 
			<span class="entry-date"><span class="glyphicon glyphicon-calendar"></span> <?php issimple_date_link(); ?></span>
			<span class="entry-comments"><span class="glyphicon glyphicon-comment"></span> <?php issimple_comment_link(); ?></span>
			<?php edit_post_link( __( 'Edit', 'issimple' ), '<span class="edit-link"><span class="glyphicon glyphicon-pencil"></span> ', '</span>' ); ?>
		</p><!-- .entry-meta -->
		<?php
	endif;
}


/**
 * Footer Post Info
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_entry_footer() {
	if ( 'post' == get_post_type() && is_single() ) :
		?>
		<footer class="entry-footer bg-default">
			<?php if ( get_the_author_meta( 'description' ) ) get_template_part( 'author-info' ); ?>
			
			<p><?php _e( 'This post was written by ', 'issimple' ); the_author_posts_link(); _e( ' in ', 'issimple' ); issimple_date_link(); ?>.</p>
			<p>
				<?php if ( get_the_category() ) : ?>
					<span class="glyphicon glyphicon-folder-open"></span> <?php _e( 'Categorised in: ', 'issimple' ); the_category( ', ' ); // Separed by commas ?>.
				<?php endif; ?>
			</p>
			<p>
				<?php if ( get_the_tags() ) : ?>
					<span class="glyphicon glyphicon-tags"></span> <?php the_tags( __( 'Tags: ', 'issimple' ) . '<span class="label label-default">', '</span><span class="label label-default">', '</span>' ); ?>
				<?php endif; ?>
			</p>
		</footer><!-- .entry-footer -->
		<?php
	endif;
}


/**
 * Cria datas como links
 * 
 * @since IS Simple 1.0
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
 * @since IS Simple 1.0
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
 * @since IS Simple 1.0
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
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_index( $length ) {
	return 50;
}


/**
 * Tamanho em palavras para os resumos personalizados do slider.
 * Uso: issimple_excerpt( 'issimple_length_slider' );
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_length_slider( $lenght ) {
	return 10;
}


/**
 * Cria link Ver Artigo personalizado para a postagem
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_read_more( $more ) {
	global $post;
	
	$tagmore  = '...</p><p class="view-article">';
	$tagmore .= '<a class="btn btn-info" ';
	$tagmore .= 'href="' . get_permalink( $post->ID ) . '" ';
	$tagmore .= 'title ="' . __( 'View post:', 'issimple' ) . ' ' . get_the_title() . '">';
	$tagmore .= __( 'View post', 'issimple' );
	$tagmore .= '</a>';
	
	return $tagmore;
}
add_filter( 'excerpt_more', 'issimple_read_more' );


/**
 * Navegação dos comentários
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_comment_nav() {
	// Há comentários para navegação?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav class="nav comment-nav" role="navigation">
			<h2 class="sr-only"><?php _e( 'Comment navigation', 'issimple' ); ?></h2>
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




