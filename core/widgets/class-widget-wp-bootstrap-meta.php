<?php
/**
 * WP_Bootstrap_Meta class.
 *
 * Widget Meta adapted to bootstrap.
 *
 * @package WordPress
 * @subpackage IS Simple
 * @category Widget
 * @since IS Simple 1.0
 */
class WP_Bootstrap_Meta extends WP_Widget_Meta {

	public function __construct() {
		parent::__construct();
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
}


/**
 * Register the WP Bootstrap Meta Widget.
 *
 * @return void
 */
function wp_bootstrap_meta_widget() {
	register_widget( 'WP_Bootstrap_Meta' );
}

add_action( 'widgets_init', 'wp_bootstrap_meta_widget' );

