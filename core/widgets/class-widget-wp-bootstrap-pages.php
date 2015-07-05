<?php
/**
 * WP_Bootstrap_Pages class.
 *
 * Widget Pages adapted to Bootstrap.
 *
 * @package WordPress
 * @subpackage IS Simple
 * @category Widget
 * @since IS Simple 1.0
 */
class WP_Bootstrap_Pages extends WP_Widget_Pages {

	public function __construct() {
		parent::__construct();
	}

	public function widget( $args, $instance ) {

		/**
		 * Filter the widget title.
		 *
		 * @since 2.6.0
		 *
		 * @param string $title    The widget title. Default 'Pages'.
		 * @param array  $instance An array of the widget's settings.
		 * @param mixed  $id_base  The widget ID.
		 */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Pages' ) : $instance['title'], $instance, $this->id_base );

		$sortby = empty( $instance['sortby'] ) ? 'menu_order' : $instance['sortby'];
		$exclude = empty( $instance['exclude'] ) ? '' : $instance['exclude'];

		if ( $sortby == 'menu_order' )
			$sortby = 'menu_order, post_title';

		/**
		 * Filter the arguments for the Pages widget.
		 *
		 * @since 2.8.0
		 *
		 * @see wp_list_pages()
		 *
		 * @param array $args An array of arguments to retrieve the pages list.
		 */
		$out = wp_list_pages( apply_filters( 'widget_pages_args', array(
			'title_li'    => '',
			'echo'        => 0,
			'sort_column' => $sortby,
			'exclude'     => $exclude
		) ) );

		if ( ! empty( $out ) ) {
			echo $args['before_widget'];
			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
		?>
		<ul class="nav">
			<?php echo $out; ?>
		</ul>
		<?php
			echo $args['after_widget'];
		}
	}
}


/**
 * Register the WP Bootstrap Pages Widget.
 *
 * @return void
 */
function wp_bootstrap_pages_widget() {
	register_widget( 'WP_Bootstrap_Pages' );
}

add_action( 'widgets_init', 'wp_bootstrap_pages_widget' );

