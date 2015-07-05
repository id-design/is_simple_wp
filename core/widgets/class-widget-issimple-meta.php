<?php
/**
 * ISSimple_Meta class.
 *
 * Meta adapted to IS Simple.
 *
 * @package WordPress
 * @subpackage IS Simple
 * @category Widget
 * @since IS Simple 1.0
 */
class ISSimple_Meta extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_meta', 'description' => __( "Login, RSS, &amp; WordPress.org links.") );
		parent::__construct('meta', __('Meta'), $widget_ops);
	}

	public function widget( $args, $instance ) {

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', empty($instance['title']) ? __( 'Meta' ) : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
?>
			<ul class="nav">
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<li><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
			<li><a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
<?php
			/**
			 * Filter the "Powered by WordPress" text in the Meta widget.
			 *
			 * @since 3.6.0
			 *
			 * @param string $title_text Default title text for the WordPress.org link.
			 */
			echo apply_filters( 'widget_meta_poweredby', sprintf( '<li><a href="%s" title="%s">%s</a></li>',
				esc_url( __( 'https://wordpress.org/' ) ),
				esc_attr__( 'Powered by WordPress, state-of-the-art semantic personal publishing platform.' ),
				_x( 'WordPress.org', 'meta widget link text' )
			) );

			wp_meta();
?>
			</ul>
<?php
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
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
<?php
	}
}


/**
 * Register the IS Simple Meta Widget.
 *
 * @return void
 */
function issimple_meta_widget() {
	register_widget( 'ISSimple_Meta' );
}

add_action( 'widgets_init', 'issimple_meta_widget' );

