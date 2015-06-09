<?php
/**
 * The template for displaying search forms
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */
?>

<form id="search-form" method="get" action="<?php echo home_url( '/' ); ?>" role="search">
	<div class="form-group">
		<label for="s" class="control-label sr-only"><?php _e( 'Search', 'issimple' ); ?></label>
		<div class="input-group">
			<input class="form-control" type="search" name="s" placeholder="<?php _e( 'Search', 'issimple' ); ?>">
			<span class="input-group-btn">
				<button class="btn btn-default" type="submit" role="button"><span class="sr-only"><?php _e( 'Search', 'issimple' ); ?></span> <span class="glyphicon glyphicon-search"></span></button>
			</span>
		</div>
	</div>
</form><!-- #search-form -->