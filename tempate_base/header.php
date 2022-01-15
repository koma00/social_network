<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<!-- Basic Page Needs
	==================================================== -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="profile" href="//gmpg.org/xfn/11">

	<!-- Mobile Specific Metas
	==================================================== -->
	<meta name="viewport" content="initial-scale=1.0, width=device-width">
	<?php wp_head(); ?>

</head>
<?php global $matebook_config; ?>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="site-wrapper" class="wrapper-container">

	<header <?php echo implode(' ', (array) $matebook_config['header_attributes']) ?>>
		<?php get_template_part( 'template-parts/header/header', 'layout' ); ?>
	</header><!--/ #header -->

	<?php do_action('matebook_header_after') ?>