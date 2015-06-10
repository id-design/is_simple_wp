<?php
/**
 * ISSimple_Calendar class.
 *
 * Calendar adapted to IS Simple.
 *
 * @package WordPress
 * @subpackage IS Simple
 * @category Widget
 * @since IS Simple 1.0
 */
class ISSimple_Calendar extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_calendar', 'description' => __( 'A calendar of your site&#8217;s Posts.') );
		parent::__construct('calendar', __('Calendar'), $widget_ops);
	}

	public function widget( $args, $instance ) {

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		echo '<div id="calendar_wrap" class="panel-body"><div class="table-responsive">';
		get_calendar();
		echo '</div></div>';
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = strip_tags($instance['title']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
<?php
	}
}


function issimple_get_calendar( $calendar_output ) {
	return str_replace( '<table id="wp-calendar">', '<table id="wp-calendar" class="table table-hover table-responsive">', $calendar_output );
}

add_filter( 'get_calendar', 'issimple_get_calendar' );

/**
 * Register the IS Simple Calendar Widget.
 *
 * @return void
 */
function issimple_calendar_widget() {
	register_widget( 'ISSimple_Calendar' );
}

add_action( 'widgets_init', 'issimple_calendar_widget' );

