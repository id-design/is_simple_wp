<?php
/**
 * WP_Bootstrap_Calendar class.
 *
 * Widget Calendar adapted to Bootstrap.
 *
 * @package WordPress
 * @subpackage IS Simple
 * @category Widget
 * @since IS Simple 1.0
 */
class WP_Bootstrap_Calendar extends WP_Widget_Calendar {

	public function __construct() {
		parent::__construct();
	}

	public function widget( $args, $instance ) {

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		$calendar_wrap_class = 'panel-body';
		echo '<div id="calendar_wrap" class="' . apply_filters( 'wp_bootstrap_calendar_widget_calendar_wrap_class', $calendar_wrap_class ) . '">';
		echo '<div class="table-responsive">';
		get_calendar();
		echo '</div></div>';
		echo $args['after_widget'];
	}
}


function wp_bootstrap_get_calendar( $calendar_output ) {
	$table_class = 'table table-hover';

	return str_replace( '<table', '<table class="' . apply_filters( 'wp_bootstrap_calendar_widget_table_class', $table_class ) . '">', $calendar_output );
}

add_filter( 'get_calendar', 'wp_bootstrap_get_calendar' );

/**
 * Register the WP Bootstrap Calendar Widget.
 *
 * @return void
 */
function wp_bootstrap_calendar_widget() {
	register_widget( 'WP_Bootstrap_Calendar' );
}

add_action( 'widgets_init', 'wp_bootstrap_calendar_widget' );

