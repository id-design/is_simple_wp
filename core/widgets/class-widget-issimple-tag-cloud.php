<?php
/**
 * ISSimple_Tag_Cloud class.
 *
 * Tag Cloud adapted to IS Simple.
 *
 * @package WordPress
 * @subpackage IS Simple
 * @category Widget
 * @since IS Simple 1.0
 */
class ISSimple_Tag_Cloud extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'description' => __( "A cloud of your most used tags.") );
		parent::__construct('tag_cloud', __('Tag Cloud'), $widget_ops);
	}

	public function widget( $args, $instance ) {
		$current_taxonomy = $this->_get_current_taxonomy($instance);
		if ( !empty($instance['title']) ) {
			$title = $instance['title'];
		} else {
			if ( 'post_tag' == $current_taxonomy ) {
				$title = __('Tags');
			} else {
				$tax = get_taxonomy($current_taxonomy);
				$title = $tax->labels->name;
			}
		}

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		echo '<div class="tagcloud panel-body">';

		/**
		 * Filter the taxonomy used in the Tag Cloud widget.
		 *
		 * @since 2.8.0
		 * @since 3.0.0 Added taxonomy drop-down.
		 *
		 * @see wp_tag_cloud()
		 *
		 * @param array $current_taxonomy The taxonomy to use in the tag cloud. Default 'tags'.
		 */
		$this->issimple_wp_tag_cloud( apply_filters( 'widget_tag_cloud_args', array(
			'taxonomy' => $current_taxonomy, 'badge' => 1
		) ) );

		echo "</div>\n";
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['taxonomy'] = stripslashes($new_instance['taxonomy']);
		return $instance;
	}

	public function form( $instance ) {
		$current_taxonomy = $this->_get_current_taxonomy($instance);
?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>
	<p><label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e('Taxonomy:') ?></label>
	<select class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
	<?php foreach ( get_taxonomies() as $taxonomy ) :
				$tax = get_taxonomy($taxonomy);
				if ( !$tax->show_tagcloud || empty($tax->labels->name) )
					continue;
	?>
		<option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $current_taxonomy) ?>><?php echo $tax->labels->name; ?></option>
	<?php endforeach; ?>
	</select></p><?php
	}

	public function _get_current_taxonomy($instance) {
		if ( !empty($instance['taxonomy']) && taxonomy_exists($instance['taxonomy']) )
			return $instance['taxonomy'];

		return 'post_tag';
	}
	
	public function issimple_wp_tag_cloud( $args = '' ) {
		$defaults = array(
			'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 'number' => 45, 'badge' => 0,
			'format' => 'flat', 'separator' => "\n", 'orderby' => 'name', 'order' => 'ASC',
			'exclude' => '', 'include' => '', 'link' => 'view', 'taxonomy' => 'post_tag', 'post_type' => '', 'echo' => true
		);
		$args = wp_parse_args( $args, $defaults );
	
		$tags = get_terms( $args['taxonomy'], array_merge( $args, array( 'orderby' => 'count', 'order' => 'DESC' ) ) ); // Always query top tags
	
		if ( empty( $tags ) || is_wp_error( $tags ) )
			return;
	
		foreach ( $tags as $key => $tag ) {
			if ( 'edit' == $args['link'] )
				$link = get_edit_term_link( $tag->term_id, $tag->taxonomy, $args['post_type'] );
			else
				$link = get_term_link( intval($tag->term_id), $tag->taxonomy );
			if ( is_wp_error( $link ) )
				return false;
	
			$tags[ $key ]->link = $link;
			$tags[ $key ]->id = $tag->term_id;
		}
	
		$return = $this->issimple_wp_generate_tag_cloud( $tags, $args ); // Here's where those top tags get sorted according to $args
	
		/**
		 * Filter the tag cloud output.
		 *
		 * @since 2.3.0
		 *
		 * @param string $return HTML output of the tag cloud.
		 * @param array  $args   An array of tag cloud arguments.
		 */
		$return = apply_filters( 'issimple_wp_tag_cloud', $return, $args );
	
		if ( 'array' == $args['format'] || empty($args['echo']) )
			return $return;
	
		echo $return;
	}
	
	public function issimple_wp_generate_tag_cloud( $tags, $args = '' ) {
		$defaults = array(
			'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 'number' => 0, 'badge' => 0,
			'format' => 'flat', 'separator' => "\n", 'orderby' => 'name', 'order' => 'ASC',
			'topic_count_text' => null, 'topic_count_text_callback' => null,
			'topic_count_scale_callback' => 'default_topic_count_scale', 'filter' => 1,
		);
	
		$args = wp_parse_args( $args, $defaults );
	
		$return = ( 'array' === $args['format'] ) ? array() : '';
	
		if ( empty( $tags ) ) {
			return $return;
		}
	
		// Juggle topic count tooltips:
		if ( isset( $args['topic_count_text'] ) ) {
			// First look for nooped plural support via topic_count_text.
			$translate_nooped_plural = $args['topic_count_text'];
		} elseif ( ! empty( $args['topic_count_text_callback'] ) ) {
			// Look for the alternative callback style. Ignore the previous default.
			if ( $args['topic_count_text_callback'] === 'default_topic_count_text' ) {
				$translate_nooped_plural = _n_noop( '%s topic', '%s topics' );
			} else {
				$translate_nooped_plural = false;
			}
		} elseif ( isset( $args['single_text'] ) && isset( $args['multiple_text'] ) ) {
			// If no callback exists, look for the old-style single_text and multiple_text arguments.
			$translate_nooped_plural = _n_noop( $args['single_text'], $args['multiple_text'] );
		} else {
			// This is the default for when no callback, plural, or argument is passed in.
			$translate_nooped_plural = _n_noop( '%s topic', '%s topics' );
		}
	
		/**
		 * Filter how the items in a tag cloud are sorted.
		 *
		 * @since 2.8.0
		 *
		 * @param array $tags Ordered array of terms.
		 * @param array $args An array of tag cloud arguments.
		 */
		$tags_sorted = apply_filters( 'tag_cloud_sort', $tags, $args );
		if ( empty( $tags_sorted ) ) {
			return $return;
		}
	
		if ( $tags_sorted !== $tags ) {
			$tags = $tags_sorted;
			unset( $tags_sorted );
		} else {
			if ( 'RAND' === $args['order'] ) {
				shuffle( $tags );
			} else {
				// SQL cannot save you; this is a second (potentially different) sort on a subset of data.
				if ( 'name' === $args['orderby'] ) {
					uasort( $tags, '_wp_object_name_sort_cb' );
				} else {
					uasort( $tags, '_wp_object_count_sort_cb' );
				}
	
				if ( 'DESC' === $args['order'] ) {
					$tags = array_reverse( $tags, true );
				}
			}
		}
	
		if ( $args['number'] > 0 )
			$tags = array_slice( $tags, 0, $args['number'] );
	
		$counts = array();
		$real_counts = array(); // For the alt tag
		foreach ( (array) $tags as $key => $tag ) {
			$real_counts[ $key ] = $tag->count;
			$counts[ $key ] = call_user_func( $args['topic_count_scale_callback'], $tag->count );
		}
	
		$min_count = min( $counts );
		$spread = max( $counts ) - $min_count;
		if ( $spread <= 0 )
			$spread = 1;
		$font_spread = $args['largest'] - $args['smallest'];
		if ( $font_spread < 0 )
			$font_spread = 1;
		$font_step = $font_spread / $spread;
	
		$a = array();
	
		foreach ( $tags as $key => $tag ) {
			$count = $counts[ $key ];
			$real_count = $real_counts[ $key ];
			$tag_link = '#' != $tag->link ? esc_url( $tag->link ) : '#';
			$tag_id = isset($tags[ $key ]->id) ? $tags[ $key ]->id : $key;
			$tag_name = $tags[ $key ]->name;
	
			if ( $translate_nooped_plural ) {
				$title_attribute = sprintf( translate_nooped_plural( $translate_nooped_plural, $real_count ), number_format_i18n( $real_count ) );
			} else {
				$title_attribute = call_user_func( $args['topic_count_text_callback'], $real_count, $tag, $args );
			}
			
			if ( $args['badge'] ) {
				$a[] = "<a href='$tag_link' class='tag-link-$tag_id label label-default label-has-badge' title='" . esc_attr( $title_attribute ) . "'>$tag_name <span class='badge'>"
					. number_format_i18n( $real_count ) . "</span></a>";
			} else {
				$a[] = "<a href='$tag_link' class='tag-link-$tag_id' title='" . esc_attr( $title_attribute ) . "' style='font-size: " .
					str_replace( ',', '.', ( $args['smallest'] + ( ( $count - $min_count ) * $font_step ) ) )
					. $args['unit'] . ";'>$tag_name</a>";
			}
		}
	
		switch ( $args['format'] ) {
			case 'array' :
				$return =& $a;
				break;
			case 'list' :
				$return = "<ul class='wp-tag-cloud'>\n\t<li>";
				$return .= join( "</li>\n\t<li>", $a );
				$return .= "</li>\n</ul>\n";
				break;
			default :
				$return = join( $args['separator'], $a );
				break;
		}
	
		if ( $args['filter'] ) {
			/**
			 * Filter the generated output of a tag cloud.
			 *
			 * The filter is only evaluated if a true value is passed
			 * to the $filter argument in wp_generate_tag_cloud().
			 *
			 * @since 2.3.0
			 *
			 * @see wp_generate_tag_cloud()
			 *
			 * @param array|string $return String containing the generated HTML tag cloud output
			 *                             or an array of tag links if the 'format' argument
			 *                             equals 'array'.
			 * @param array        $tags   An array of terms used in the tag cloud.
			 * @param array        $args   An array of wp_generate_tag_cloud() arguments.
			 */
			return apply_filters( 'wp_generate_tag_cloud', $return, $tags, $args );
		}
	
		else
			return $return;
	}
}


/**
 * Register the IS Simple Tag Cloud Widget.
 *
 * @return void
 */
function issimple_tag_cloud_widget() {
	register_widget( 'ISSimple_Tag_Cloud' );
}

add_action( 'widgets_init', 'issimple_tag_cloud_widget' );

