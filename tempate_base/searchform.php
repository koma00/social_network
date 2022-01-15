<form class="search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input class="search-input" type="text" name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e( 'Search', 'matebook' ) ?>">
	<button class="search-button" type="submit"><i class="material-icons-outlined">search</i>Search</button>
</form>
