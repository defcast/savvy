<?php
/**
 * Template for displaying search forms in Theme
 **/ ?>
<div class="row">
	<div class="col-sm-12">
		<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form" method="get" role="search">
			<label>
				<span class="screen-reader-text"><?php esc_html_e('Search for:','copywriter'); ?></span>
				<input type="search" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="<?php esc_attr_e('Search','copywriter'); ?>" class="search-field form-control">
			</label>
		</form>	
	</div>
</div>		