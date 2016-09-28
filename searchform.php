<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="search-form__label">
		<span class="search-form__label-text"><?php echo _x( 'Search for:', THEME_TEXT_DOMAIN ); ?></span>
		<input type="text" class="search-form__field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', THEME_TEXT_DOMAIN ); ?>" value="<?php echo get_search_query(); ?>" name="s">
	</label>
	<button type="submit" class="search-form__submit"><?php echo _x( 'Search', THEME_TEXT_DOMAIN ); ?></button>
</form>
