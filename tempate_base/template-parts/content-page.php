<?php

$post_class = '';

if ( ! has_post_thumbnail() ) {
	$post_class = 'post--noimage';
}

?>

<div id="post-<?php the_ID(); ?>" <?php post_class($post_class . ' post--page'); ?>>

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<?php
	wp_link_pages( array(
		'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'matebook' ) . '</span>',
		'after'       => '</div>',
		'link_before' => '<span>',
		'link_after'  => '</span>',
		'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'matebook' ) . ' </span>%',
		'separator'   => '<span class="screen-reader-text">, </span>',
	) );
	?>

</div><!-- #post-## -->
