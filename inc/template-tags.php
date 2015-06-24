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
function add_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'header-menu' == $args->theme_location && $item->description ) :
		$item_output = str_replace( $args->link_after . '</a>', $args->link_after . '<div class="menu-item-desc"><div class="arrow"></div>' . $item->description . '</div>' . '</a>', $item_output );
	endif;
	
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'add_nav_description', 10, 4 );


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
function issimple_content_search_form( $form_id = '', $form_class = '' ) {
	$form_atts = array();
	$form_atts['id'] = ( ! empty( $form_id ) ) ? $form_id . '-search-form' : 'search-form';
	$form_atts['class'] = ( ! empty( $form_class ) ) ? $form_class : '';
	
	$search_form_atts = array2atts( $form_atts );
	?>
	
	<form<?php echo $search_form_atts; ?> method="get" action="<?php echo home_url( '/' ); ?>" role="search">
		<div class="form-group">
			<label for="s" class="control-label sr-only"><?php _e( 'Search', 'issimple' ); ?></label>
			<div class="input-group">
				<input class="form-control" type="search" name="s" placeholder="<?php _e( 'Search', 'issimple' ); ?>">
				<span class="input-group-btn">
					<button class="btn btn-default" type="submit" role="button">
						<span class="sr-only"><?php _e( 'Search', 'issimple' ); ?></span> <span class="glyphicon glyphicon-search"></span>
					</button>
				</span>
			</div>
		</div>
	</form><!-- #<?php echo $form_atts['id']; ?> -->
	
	<?php
}


/**
 * Page Header
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_page_header() {
	if ( ! is_single() || ! is_front_page() ) : ?>
		<header id="page-header">
			<div class="jumbotron">
				<div class="container-fluid">
					<?php
						if ( is_page() ) :
							the_title( '<h1 id="page-title">', '</h1>' );
							edit_post_link( __( 'Edit', 'issimple' ), '<span class="edit-link"><span class="glyphicon glyphicon-pencil"></span> ', '</span>' );
						elseif ( is_404() ) : ?>
							<h1 id="page-title"><?php _e( 'Page not found', 'issimple' ); ?></h1><?php
						elseif ( is_archive() ) :
							the_archive_title( '<h1 id="page-title">', '</h1>' );
							
							if ( is_author() ) :
								if ( get_the_author_meta( 'description' ) ) : ?>
									<p id="author-bio">
										<?php get_template_part( 'author-info' ); ?>
									</p><!-- #author-bio --><?php
								endif;
							else:
								the_archive_description( '<div class="taxonomy-description">', '</div>' );
							endif;
						elseif ( is_search() ) : ?>
							<h1 id="page-title"><?php
								printf( __( 'Search results for: %s', 'issimple' ), get_search_query() );  ?>
							</h1><?php
						else : ?>
							<h1 id="page-title"><?php _e( 'Latest Posts', 'issimple' ); ?></h1><?php
						endif;
					?>
				</div>
			</div>
		</header><!-- #page-header --><?php
	endif;
}



/**
 * Primary class based on page template
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_primary_class() {
	if ( is_page_template( 'page-templates/full-width-post.php' ) || is_page_template( 'page-templates/full-width-page.php' ) ) :
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
 * Custom Posts Pagination
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_post_pagination() {
	wp_bootstrap_pagination_links( array(
		'type'				=> 'pager',
		'container_id'		=> 'post-pagination',
		'container_class'	=> 'panel panel-default',
		'div_class'			=> 'panel-body',
		'paginate_content'	=> 'posts'
	) );
	
	echo '<!-- #post-pagination -->';
}


/**
 * Custom Posts Navigation
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_post_navigation() {
	wp_bootstrap_post_navigation( array(
		'container_class' => 'post-navigation panel panel-default',
		'prev_text' => '<span class="meta-nav">' . __( 'Previous', 'issimple' ) . '</span> ' .
			'<span class="sr-only">' . __( 'Previous post:', 'issimple' ) . '</span> ' .
			'<span class="post-title h3">%title</span>',
		'next_text' => '<span class="meta-nav">' . __( 'Next', 'issimple' ) . '</span> ' .
			'<span class="sr-only">' . __( 'Next post:', 'issimple' ) . '</span> ' .
			'<span class="post-title h3">%title</span>'
	) );
	
	echo '<!-- #post-navigation -->';
}


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
 * Custom Comments Pagination
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_comments_pagination() {
	wp_bootstrap_pagination_links( array(
		'type'					=> 'pager',
		'container_id'			=> 'comments-pagination',
		'container_class'		=> 'panel panel-default',
		'div_class'				=> 'panel-body',
		'screen_reader_text'	=> __( 'Comments navigation', 'issimple' ),
		'paginate_content'		=> 'comments'
	) );
	
	echo '<!-- #comments-pagination -->';
}


/**
 * Custom Featured Thumbnail
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_post_featured_thumb( $size = 'featured-size' ) {
	$thumb_id = get_post_thumbnail_id();
	
	$thumb_link_full = wp_get_attachment_image_src( $thumb_id, 'full' );
	$thumb_link_full = $thumb_link_full[0];
	
	$thumb_caption = get_post_thumbnail_meta( $thumb_id, 'caption' );
	
	$link_atts = array();
	$link_atts['class'] = 'featured-link img-link';
	$link_atts['title'] = get_the_title();
	$link_atts['href'] = ( is_singular() ) ? $thumb_link_full : get_permalink();
	$link_atts['data-lightbox'] = ( is_singular() ) ? 'post-' . get_the_ID() : '';
	$link_atts['data-title'] = ( is_singular() ) ? $thumb_caption : '';
	
	$link_attributes = array2atts( $link_atts );
	
	if ( has_post_thumbnail() ) : ?>
		<figure class="post-featured-thumb">
			<a<?php echo $link_attributes; ?>>
				<?php the_post_thumbnail( $size, array( 'class' => 'featured-img img-responsive', 'alt' => get_the_title() ) ); ?>
			</a>
		</figure><!-- .post-featured-thumb -->
	<?php endif;
}


/**
 * Prints HTML with meta information
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
			
			<?php if ( get_the_category() ) : ?>
				<p>
					<span class="glyphicon glyphicon-folder-open"></span> <?php _e( 'Categorised in: ', 'issimple' ); the_category( ', ' ); // Separed by commas ?>.
				</p>
			<?php endif; ?>
			
			<?php if ( get_the_tags() ) : ?>
				<p>
					<span class="glyphicon glyphicon-tags"></span> <?php the_tags( __( 'Tags: ', 'issimple' ), '' ); ?>
				</p>
			<?php endif; ?>
		</footer><!-- .entry-footer -->
		<?php
	endif;
}


/**
 * Page links
 * 
 * @since IS Simple 1.0
 * ----------------------------------------------------------------------------
 */
function issimple_page_links() {
	wp_link_pages( array(
		'before'      => '<hr /><div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'issimple' ) . '</span>',
		'after'       => '</div>',
		'link_before' => '<span>',
		'link_after'  => '</span>',
		'pagelink'    => '<span class="sr-only">' . __( 'Page', 'issimple' ) . ' </span>%',
		'separator'   => '<span class="sr-only">, </span>',
	) );
	
	echo '<!-- .page-links -->';
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




