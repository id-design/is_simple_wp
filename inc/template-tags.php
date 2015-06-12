<?php
/**
 * Custom Template Tags
 * 
 * Eventually, some of the functionality here could be replaced by
 * core features.
 * 
 * @package IS Simple
 * @since 1.0
 */


/**
 * Custom Favicon
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function custom_favicon(){
	$favicon 			= ICONS_URI . '/favicon.ico';
	$apple_icons 		= issimple_readdir( ICONS_PATH, 'png' );
	$apple_icons_name 	= array_keys( $apple_icons );
	$apple_icons_count 	= count( $apple_icons_name );
	$apple_icons_size 	= str_replace( '-', '', $apple_icons_name);
	$apple_icons_size 	= str_replace( 'appletouchicon', '', $apple_icons_size);
	
	$favicons  = '<!-- Favicon IE 9 -->';
	$favicons .= '<!--[if lte IE 9]><link rel="icon" type="image/x-icon" href="' . $favicon . '" /> <![endif]-->';
	
	$favicons .= '<!-- Favicon Other Browses -->';
	$favicons .= '<link rel="shortcut icon" type="image/png" href="' . $favicon . '" />';
	
	$favicons .='<!-- Favicon Apple -->';
	
	for ( $i = 0; $i < $apple_icons_count; $i++ ) :
		$size = ( $apple_icons_size[$i] == '' ) ? '' : ' sizes="' . $apple_icons_size[$i] . '"';
		
		$favicons .='<link rel="apple-touch-icon"' . $size . ' href="' . ICONS_URI . '/' . $apple_icons_name[$i] . '.png" />';
	endfor;
	
	echo $favicons;
}
//add_action( 'wp_head', 'custom_favicon' );
//add_action( 'admin_head', 'custom_favicon' );
//add_action( 'login_head', 'custom_favicon' );


/**
 * Custom icon to login screen
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
 * Head titles adjustments
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function custom_wp_title( $title, $sep ) {
	$site_name = get_bloginfo( 'name', 'display' );
	$site_description = get_bloginfo( 'description', 'display' );
	
	if ( is_page() || is_archive() || is_single() ) $title .= ' - ' . $site_description;
	
	return str_replace( "$site_name $sep $site_description", "$site_name - $site_description", $title );
}
add_filter( 'wp_title', 'custom_wp_title', 10, 2 );


/**
 * Add page/post slug as class in <body>
 * Credits: Starkers Wordpress Theme
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function add_slug_to_body_class( $classes ) {
	global $post;
	
	if ( is_page() ) {
		$classes[] = sanitize_html_class( $post->post_name );
	} elseif ( is_singular() ) {
		$classes[] = sanitize_html_class( $post->post_name );
	}
	
	return $classes;
}
add_filter( 'body_class', 'add_slug_to_body_class' );


/**
 * Add attribute 'role="navigation"' to Nav Menus
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
 * Description to Nav Menu Itens
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
 * Custom class to Nav Menu Itens
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function classes_to_nav_item( $classes, $item, $args, $depth ) {
	$classes[] = ( $depth > 0 ) ? 'sub-menu-item' : '';
	
	return $classes;
}
//add_filter( 'nav_menu_css_class', 'classes_to_nav_item', 10, 4 );


/**
 * Custom class to Nav Menu Links
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function class_to_nav_link( $atts, $item, $args, $depth  ) {
	$atts['class']  = ( $depth <= 0 ) ? 'menu-link' : 'menu-link sub-menu-link';
	
	return $atts;
}
//add_filter( 'nav_menu_link_attributes', 'class_nav_to_link', 10, 4 );


/**
 * Remove "id" attribute to Nav Menus Itens
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
add_filter( 'nav_menu_item_id', '__return_false' );


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
	if ( is_page_template( 'page-templates/full-width.php' ) ) :
		echo 'col-md-12';
	else:
		echo 'col-sm-8 col-md-8';
	endif;
}


/**
 * Secondary class
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_secondary_class() {
	echo 'col-sm-4 col-md-4 hidden-xs';
}


/**
 * Custom title to Archive Pages
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function custom_archive_title( $title ) {
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
add_filter( 'get_the_archive_title', 'custom_archive_title' );


/**
 * Posts Pagination
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_post_pagination() {
	issimple_wp_bootstrap_pagination( array(
		'type' => 'pager',
		'container_id' => 'post-pagination',
		'container_class' => 'panel panel-default',
		'div_class' => 'panel-body'
	) );
	
	echo '<!-- #post-pagination -->';
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
					<span class="glyphicon glyphicon-tags"></span> <?php the_tags( __( 'Tags: ', 'issimple' ), '' ); ?>
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
 * Custom comment links
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
 * Custom excerpt with length and excerpt more tag to variables excerpts
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
 * Word's length to a custom excerpt.
 * @uses issimple_excerpt( 'issimple_index' );
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_index( $length ) {
	return 50;
}


/**
 * Word's length to a custom excerpt in slider.
 * @uses issimple_excerpt( 'issimple_length_slider' );
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_length_slider( $lenght ) {
	return 10;
}


/**
 * Custom general excerpt more tag
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
 * Custom Comments Navigation
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




