<div class="page-title-holder">

	<div class="container">

		<?php if ( is_archive() ) : ?>
			<h1 class="page-title"><?php matebook_the_archive_title(); ?></h1>
		<?php else : ?>
			<h1 class="page-title"><?php the_title(); ?></h1>
		<?php endif; ?>

	</div><!--/ .container-->

</div><!--/ .breadcrumbs-holder-->