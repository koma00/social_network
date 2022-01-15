<?php
global $matebook_settings, $matebook_config;
$args = Matebook_Template_Args::footer();
?>

<!-- - - - - - - - - - - - - - Footer - - - - - - - - - - - - - - - - -->

<?php
$list_footer = array( 'main' );
$css_classes = [
	'site-footer'
];

foreach ( $args as $key => $arg ) {
	if ( in_array( $key, $list_footer ) ) {
		if ( ! empty( $arg ) ) {
			$css_classes[] = 'has-' . $arg;
		}
	}
}

if ( ! class_exists( 'Matebook_Theme_Functionality_Loading' ) ) {
	$css_classes[] = 'no-has-theme-plugin';
}

$wrapper_attributes   = [];
$wrapper_attributes[] = 'id="footer"';
$wrapper_attributes[] = 'class="' . esc_attr( trim( implode( ' ', array_filter( $css_classes ) ) ) ) . '"';
?>

<footer <?php echo implode( ' ', $wrapper_attributes ) ?> >

	<div class="site-footer-inner">

		<?php if ( $args['main'] ) : ?>

			<?php if ( is_active_sidebar( $args['main'] ) ): ?>

				<div class="main-footer <?php echo esc_attr( $args['main_top_css'] ) ?>">
					<div class="container <?php echo esc_attr( $args['main_css'] ) ?>">
						<div class="d-flex <?php echo esc_attr( $args['main_row_css'] ) ?>"><?php
							dynamic_sidebar( $args['main'] ) ?>
						</div>
					</div>
				</div>

			<?php endif;

		endif; ?>

	</div>

	<?php if ( mad()->get_option( 'footer-show-copyright' ) ): ?>

		<div class="copyright-section">
			<?php echo wp_kses( mad()->get_option( 'footer-copyright' ), 'default' ) ?>
		</div>

	<?php endif; ?>

</footer>

<!-- - - - - - - - - - - - - -/ Footer - - - - - - - - - - - - - - - - -->

</div><!--/ #site-wrapper-->

<?php do_action( 'matebook_get_footer' ); ?>
<?php wp_footer(); ?>

</body>
</html>