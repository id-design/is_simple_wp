<?php
/**
 * The template for displaying slider
 *
 * @package		WordPress
 * @subpackage	IS Simple
 * @since		IS Simple 1.0
 */

/**
 * Set default parrameters to new WP_Query object
 */
$param = array(
	'tag__in'			=> issimple_get_slider_option( 'slider_tag' ),
	'posts_per_page'	=> 5,
	'post_status'		=> 'publish',
	'orderby'			=> 'date',
	'order'				=> 'DESC',
	'meta_key'			=> '_thumbnail_id'
);

// Currently-queried Object.
$obj_query = get_queried_object();

if ( is_tag() ) :
	$tag_slug = $obj_query->slug;
	$param['tag_slug__and'] = $tag_slug;
endif;

if ( is_category() ) :
	$cat_slug = $obj_query->slug;
	$param['category_name'] = $cat_slug;
endif;

if ( is_date() ) :
	$day_num	= get_the_date( 'j' );;
	$month_num	= get_the_date( 'n' );;
	$year_num	= get_the_date( 'Y' );;

	if ( is_day() )
		$date_param = array(
			'day'	=> $day_num,
			'month'	=> $month_num,
			'year'	=> $year_num
		);

	if ( is_month() )
		$date_param = array(
			'month'	=> $month_num,
			'year'	=> $year_num
		);

	if ( is_year() )
		$date_param = array(
			'year'	=> $year_num
		);

	$param['date_query'] = array( $date_param );
endif;

if ( is_search() ) $param['s'] = get_search_query();

// Creates a new WP_Query object with defined parameters 
$slides = new WP_Query( $param );

if ( $slides->post_count > 0 ) :
	$figure_atts = array();
	$figure_atts['class'] = 'cycle-slideshow hidden-xs';
	$figure_atts['data-cycle-fx'] = issimple_get_slider_option( 'slider_fx' );
	$figure_atts['data-cycle-pause-on-hover'] = ( issimple_get_slider_option( 'pause_on_hover' ) ) ? 'true' : '';
	$figure_atts['data-cycle-timeout'] = '4000';
	$figure_atts['data-cycle-pager'] = '#cycle-pager';
	$figure_atts['data-cycle-pager-template'] = '<a href=#><span class="glyphicon glyphicon-minus"></a>';
	$figure_atts['data-cycle-prev'] = '#cycle-prev';
	$figure_atts['data-cycle-next'] = '#cycle-next';
	$figure_atts['data-cycle-slides'] = '> div';
	$figure_attributes = array2atts( $figure_atts );

	?>
	<div id="cycle-slider">
		<figure<?php echo $figure_attributes; ?>><?php
			
			while ( $slides->have_posts() ) : $slides->the_post();
				$post_link  = esc_url( get_permalink() );
				$post_title = esc_attr( get_the_title() );
				
				?>
				<div class="cycle-slide">
					<a class="img-link" href="<?php echo $post_link; ?>" title="<?php echo $post_title; ?>">
						<?php the_post_thumbnail( 'featured-slider-size', array( 'class' => 'featured-img img-responsive', 'alt' => $post_title ) ); ?>
					</a>
					
					<figcaption class="cycle-caption hidden-xs hidden-sm">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-8 col-md-offset-2 col-lg-10 col-lg-offset-1">
									<h4 class="entry-title h2">
										<a href="<?php echo $post_link; ?>" title="<?php echo $post_title; ?>">
											<?php echo $post_title; ?>
										</a>
									</h4>
									<div class="entry-summary">
										<?php issimple_excerpt( 'issimple_length_slider', 'issimple_slider_read_more' ); ?>
									</div>
								</div>
							</div>
						</div>
					</figcaption><!-- .slider-caption -->
				</div><!-- .cycle-slide -->
				<?php
			endwhile;
			?>
			<span class="cycle-navigation">
	            <a href="#" id="cycle-prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
	            <span id="cycle-pager"></span>
	            <a href="#" id="cycle-next"><span class="glyphicon glyphicon-chevron-right"></span></a>
	        </span><!-- #slider-navigation -->
			
		</figure>
	</div><!-- #cycle-slider -->
	<?php
	
endif;

// Restores the $post global to the current post in the main query.
wp_reset_postdata();