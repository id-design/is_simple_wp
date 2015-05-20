<?php
/**
 * O template para exibir o formulário de pesquisa
 *
 * @package WordPress
 * @subpackage IS Simple
 * @since IS Simple 1.0
 */
?>

<aside id="search" class="widget inner">
	<form id="search-form" class="search" method="get" action="<?php echo home_url(); ?>" role="search">
		<div class="form-group">
			<label for="s"><span class="screen-reader-text"><?php _e( 'Search', 'issimple' ); ?></span></label>
			<div class="input-group">
				<input class="search-input" type="search" name="s" placeholder="<?php _e( 'Search', 'issimple' ); ?>">
				<span class="input-group-addon-right"><button class="search-submit button" type="submit" role="button">&#xf002;</button></span>
			</div>
		</div>
	</form>
</aside><!-- #search -->
