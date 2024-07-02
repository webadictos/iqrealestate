<?php

/**
 * The template for displaying search forms.
 */
?>
<form class="search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
	<div class="input-group">

		<input type="text" name="s" class="form-control" placeholder="<?php esc_attr_e('Buscar', 'wa-theme'); ?>" value="<?php echo  get_search_query(); ?>" />
		<button class="btn btn-secondary search-form__btn"><?php esc_html_e('Buscar', 'wa-theme'); ?></button>
	</div><!-- /.input-group -->
</form>