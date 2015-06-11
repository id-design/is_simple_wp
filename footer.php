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
					<div class="row">
						
						<div id="copyright" class="col-md-12">
							<p>
								&copy; <?php echo date( 'Y' ) . ' ' . do_shortcode( '[home-link]' ) . ' - ' . __( 'All rights reserved.', 'issimple' ) . ' ' .
								sprintf(
									__( 'Powered by <a href="%s" rel="nofollow" target="_blank">ID Design</a> on <a href="%s" rel="nofollow" target="_blank">WordPress</a>.', 'issimple' ),
									'https://github.com/id-design/is_simple_wp',
									'http://wordpress.org/' ); ?>
							</p>
						</div><!-- #copyright -->
					</div>
				</div>
			</footer><!-- #footer -->

		<?php wp_footer(); ?>

	</body>
</html>
