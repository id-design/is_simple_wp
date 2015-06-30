<?php
/**
 * The template for displaying the footer
 *
 * Contains the "footer" section and all content after.
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */
?>

					</div><!-- .row -->
				</div><!-- .container-fluid -->
			</div><!-- #main -->
			
			<footer id="footer" role="contentinfo">
				<div class="container-fluid">
					<div id="footer-widget-area" class="row">
						<div id="footer-widget-area-1" class="col-sm-4 col-md-4 widget-area">
							<?php
								if ( is_active_sidebar( 'footer-widget-area-1' ) ) :
									dynamic_sidebar( 'footer-widget-area-1' );
								else :
									the_widget( 'ISSimple_Calendar', array(), array(
										'before_widget'	=> '<aside class="widget panel panel-default widget_tag_cloud">',
										'before_title'	=> '<div class="panel-heading"><h3 class="widget-title panel-title">',
										'after_title'	=> '</h3></div>',
										'after_widget'	=> '</aside>'
									) );
								endif;
							?>
						</div><!-- #footer-widget-area-1 -->
						<div id="footer-widget-area-2" class="col-sm-4 col-md-4 widget-area">
							<?php
								if ( is_active_sidebar( 'footer-widget-area-2' ) ) :
									dynamic_sidebar( 'footer-widget-area-2' );
								else :
									the_widget( 'ISSimple_Pages', array(), array(
										'before_widget'	=> '<aside class="widget panel panel-default widget_tag_cloud">',
										'before_title'	=> '<div class="panel-heading"><h3 class="widget-title panel-title">',
										'after_title'	=> '</h3></div>',
										'after_widget'	=> '</aside>'
									) );
								endif;
							?>
						</div><!-- #footer-widget-area-2 -->
						<div id="footer-widget-area-3" class="col-sm-4 col-md-4 widget-area">
							<?php
								if ( is_active_sidebar( 'footer-widget-area-3' ) ) :
									dynamic_sidebar( 'footer-widget-area-3' );
								else :
									the_widget( 'ISSimple_Meta', array(), array(
										'before_widget'	=> '<aside class="widget panel panel-default widget_tag_cloud">',
										'before_title'	=> '<div class="panel-heading"><h3 class="widget-title panel-title">',
										'after_title'	=> '</h3></div>',
										'after_widget'	=> '</aside>'
									) );
								endif;
							?>
						</div><!-- #footer-widget-area-3 -->
					</div><!-- #footer-widget-area -->
					<div id="copyright" class="row">
						<div class="col-md-12">
							<p>
								<?php global $issimple_options;
									echo $issimple_options['issimple_options_footer_text'];
								?>
							</p>
						</div>
					</div><!-- #copyright -->
				</div>
			</footer><!-- #footer -->

		<?php wp_footer(); ?>

	</body>
</html>
