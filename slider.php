<?php
/**
 * The template for displaying slider
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */

$param = array( 'tag'				=> 'featured',
				'posts_per_page'	=> 5,
				'post_status'		=> 'publish',
				'orderby'			=> 'date',
				'order'				=> 'DESC',
				'meta_key'			=> '_thumbnail_id'
				);

$obj_query = $wp_query->get_queried_object();

if ( is_tag() ) :
	$tag_slug = $obj_query->slug;
	$param[ 'tag_slug__and' ] = $tag_slug;
endif;

if ( is_category() ) :
	$cat_slug = $obj_query->slug;
	$param[ 'category_name' ] = $cat_slug;
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
	
	$param[ 'date_query' ] = array( $date_param );
endif;

$slides = new WP_Query( $param );

if ( $slides->post_count > 0 ) :
	$slider_pause_hover = 'true';
	
	?>
	<section id="cycle-slider">
		<figure class="cycle-slideshow"
				data-cycle-fx="scrollHorz"
				data-cycle-pause-on-hover="<?php echo $slider_pause_hover ?>"
				data-cycle-timeout="4000"
				data-cycle-pager="#slider-pager"
				data-cycle-pager-template="<a href=#> &#9679; </a>"
				data-cycle-prev="#prev"
				data-cycle-next="#next"
				data-cycle-slides="> div"><?php
			
			while ( $slides->have_posts() ) : $slides->the_post();
				$img        = wp_get_attachment_image_src( get_post_thumbnail_id(), 'featured-slider-size' );
				$img_src    = $img[0];
				$post_link  = get_permalink();
				$post_title = get_the_title();
				
				?>
				<div class="cycle-slide">
					<a class="img-link" href="<?php echo $post_link ?>" title="<?php echo $post_title ?>">
						<img src="<?php echo $img_src ?>" />
					</a>
					
					<figcaption class="slider-caption cycle-overlay container-fluid">
						<h4 class="entry-title">
							<a href="<?php echo $post_link ?>" title="<?php echo $post_title ?>">
								<?php echo $post_title ?>
							</a>
						</h4>
						<?php issimple_excerpt( 'issimple_length_slider' ); ?>
					</figcaption><!-- .slider-caption -->
				</div><!-- .cycle-slide -->
				<?php
			endwhile;
			
			?>
			<div id="slider-navigation" class="container-fluid">
	            <a href="#" id="prev">◄</a>
	            <span id="slider-pager"></span>
	            <a href="#" id="next">►</a>
	        </div><!-- #slider-navigation -->
			
		</figure>
	</section><!-- #cycle-slider -->
	<?php
	
endif;

wp_reset_postdata();