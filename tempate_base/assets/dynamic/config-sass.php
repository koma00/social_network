<?php
$settings = \Matebook\Ext\Redux_Framework\Functions::check_theme_options() ?>

// Primary Color
$primary_color: <?php echo esc_attr($settings['primary-color']) ?>;
$secondary_color: <?php echo esc_attr($settings['secondary-color']) ?>;

// Selection Color
$selection_color: <?php echo esc_attr($settings['selection-color']) ?>;

// Typography
$body_font_family: <?php echo esc_attr($settings['body-font']['font-family']) ?>;
$body_font_weight: <?php echo esc_attr($settings['body-font']['font-weight']) ?>;
$body_font_size: <?php echo esc_attr($settings['body-font']['font-size']) ?>;
$body_line_height: <?php echo esc_attr($settings['body-font']['line-height']) ?>;
$body_color: <?php echo esc_attr($settings['body-font']['color']) ?>;

// Headings
$h1_font_family: <?php echo esc_attr($settings['h1-font']['font-family']) ?>;
$h1_font_weight: <?php echo esc_attr($settings['h1-font']['font-weight']) ?>;
$h1_font_size: <?php echo esc_attr($settings['h1-font']['font-size']) ?>;
$h1_line_height: <?php echo esc_attr($settings['h1-font']['line-height']) ?>;
$h1_color: <?php echo esc_attr($settings['h1-font']['color']) ?>;

$h2_font_family: <?php echo esc_attr($settings['h2-font']['font-family']) ?>;
$h2_font_weight: <?php echo esc_attr($settings['h2-font']['font-weight']) ?>;
$h2_font_size: <?php echo esc_attr($settings['h2-font']['font-size']) ?>;
$h2_line_height: <?php echo esc_attr($settings['h2-font']['line-height']) ?>;
$h2_color: <?php echo esc_attr($settings['h2-font']['color']) ?>;

$h3_font_family: <?php echo esc_attr($settings['h3-font']['font-family']) ?>;
$h3_font_weight: <?php echo esc_attr($settings['h3-font']['font-weight']) ?>;
$h3_font_size: <?php echo esc_attr($settings['h3-font']['font-size']) ?>;
$h3_line_height: <?php echo esc_attr($settings['h3-font']['line-height']) ?>;
$h3_color: <?php echo esc_attr($settings['h3-font']['color']) ?>;

$h4_font_family: <?php echo esc_attr($settings['h4-font']['font-family']) ?>;
$h4_font_weight: <?php echo esc_attr($settings['h4-font']['font-weight']) ?>;
$h4_font_size: <?php echo esc_attr($settings['h4-font']['font-size']) ?>;
$h4_line_height: <?php echo esc_attr($settings['h4-font']['line-height']) ?>;
$h4_color: <?php echo esc_attr($settings['h4-font']['color']) ?>;

$h5_font_family: <?php echo esc_attr($settings['h5-font']['font-family']) ?>;
$h5_font_weight: <?php echo esc_attr($settings['h5-font']['font-weight']) ?>;
$h5_font_size: <?php echo esc_attr($settings['h5-font']['font-size']) ?>;
$h5_line_height: <?php echo esc_attr($settings['h5-font']['line-height']) ?>;
$h5_color: <?php echo esc_attr($settings['h5-font']['color']) ?>;

$h6_font_family: <?php echo esc_attr($settings['h6-font']['font-family']) ?>;
$h6_font_weight: <?php echo esc_attr($settings['h6-font']['font-weight']) ?>;
$h6_font_size: <?php echo esc_attr($settings['h6-font']['font-size']) ?>;
$h6_line_height: <?php echo esc_attr($settings['h6-font']['line-height']) ?>;
$h6_color: <?php echo esc_attr($settings['h6-font']['color']) ?>;

// Body
$body_bg_color: <?php echo esc_attr($settings['body-bg']['background-color']) ?>;
$body_bg_repeat: <?php echo esc_attr($settings['body-bg']['background-repeat']) ?>;
$body_bg_size: <?php echo esc_attr($settings['body-bg']['background-size']) ?>;
$body_bg_attachment: <?php echo esc_attr($settings['body-bg']['background-attachment']) ?>;
$body_bg_position: <?php echo esc_attr($settings['body-bg']['background-position']) ?>;
<?php
$body_bg_image = esc_attr($settings['body-bg']['background-image']);
?>
$body_bg_image: <?php echo esc_attr($body_bg_image) != 'none' ? 'url('.esc_url($body_bg_image).')' : $body_bg_image ?>;

// Menu
$menu_font_family: <?php echo esc_attr($settings['menu-font']['font-family']) ?>;
$menu_font_weight: <?php echo esc_attr($settings['menu-font']['font-weight']) ?>;
$menu_font_size: <?php echo esc_attr($settings['menu-font']['font-size']) ?>;
$menu_text_transform: <?php echo esc_attr($settings['menu-text-transform']) ?>;
$main_menu_top_level_link_color: <?php echo esc_attr($settings['primary-toplevel-link-color']['regular']) ?>;

// Sub Menu
$sub_menu_bg_color: <?php echo esc_attr($settings['sub-menu-bg-color']) ?>;
$sub_menu_font_family: <?php echo esc_attr($settings['sub-menu-font']['font-family']) ?>;
$sub_menu_weight: <?php echo esc_attr($settings['sub-menu-font']['font-weight']) ?>;
$sub_menu_size: <?php echo esc_attr($settings['sub-menu-font']['font-size']) ?>;
$sub_menu_link_color: <?php echo esc_attr($settings['sub-menu-text-color']['regular']) ?>;
$sub_menu_hover_color: <?php echo esc_attr($settings['sub-menu-text-color']['hover']) ?>;
$sub_menu_active_color: <?php echo esc_attr($settings['sub-menu-text-color']['active']) ?>;
$sub_menu_bg_active_color: <?php echo esc_attr($settings['sub-menu-bg-active-color']) ?>;
$mobile_menu_color: <?php echo esc_attr($settings['mobile-menu-color']) ?>;
$mobile_menu_active_color: <?php echo esc_attr($settings['mobile-menu-active-color']) ?>;

// Header

$header_bg_color: <?php echo esc_attr($settings['header-bg-color']) ?>;

// Footer
$footer_bg_color: <?php echo esc_attr($settings['footer-bg']['background-color']) ?>;
$footer_bg_repeat: <?php echo esc_attr($settings['footer-bg']['background-repeat']) ?>;
$footer_bg_size: <?php echo esc_attr($settings['footer-bg']['background-size']) ?>;
$footer_bg_attachment: <?php echo esc_attr($settings['footer-bg']['background-attachment']) ?>;
$footer_bg_position: <?php echo esc_attr($settings['footer-bg']['background-position']) ?>;
<?php
$footer_bg_image = esc_attr($settings['footer-bg']['background-image']);
?>
$footer_bg_image: <?php echo esc_attr($footer_bg_image) != 'none' ? 'url('.esc_url($footer_bg_image).')' : $footer_bg_image ?>;

$footer_heading_color: <?php echo esc_attr($settings['footer-heading-color']) ?>;

