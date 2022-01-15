<?php get_header(); ?>

<?php global $matebook_settings;
$error_content = $matebook_settings['error-content'];
?>

	<div class="page-404-section">

		<div class="page-404-content">
			<?php echo html_entity_decode( $error_content ); ?>
		</div>

		<form class="searchform-line" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="text" name="s" value="<?php echo get_search_query(); ?>"
				   placeholder="<?php esc_attr_e( 'What are you looking for?', 'matebook' ) ?>">
			<button type="submit" class="searchform-btn"><?php esc_html_e( 'Search', 'matebook' ) ?></button>
		</form>

	</div><!--/ .page-404-section-->

<?php get_footer(); ?>