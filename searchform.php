<?php
/**
 * O template para exibir o formulário de pesquisa
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */
?>

<form id="search-form" class="navbar-form navbar-right" method="get" action="<?php echo home_url(); ?>" role="search">
	<label for="s" class="screen-reader-text"><?php _e( 'Search', 'issimple' ); ?></label>
	<div class="input-group">
		<input class="form-control" type="search" name="s" placeholder="<?php _e( 'Search', 'issimple' ); ?>">
		<span class="input-group-btn">
			<button class="btn btn-default" type="submit" role="button"><span class="screen-reader-text"><?php _e( 'Search', 'issimple' ); ?></span> <i class="fa fa-search"></i></button>
		</span>
	</div>
</form><!-- #search-form -->