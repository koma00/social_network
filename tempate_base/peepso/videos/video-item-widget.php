<div class="ps-widget__videos-item ps-video-wrapper ps-js-video" data-post-id="<?php echo esc_attr($vid_post_id); ?>">
    <div class="ps-video-item <?php if (!$vid_thumbnail) { echo "ps-audio__item"; } ?>">
        <a href="#" onclick="ps_comments.open('<?php echo esc_attr($vid_post_id); ?>', 'video'); return false;">
            <?php if ($vid_thumbnail) { ?>
            	<img alt="<?php echo esc_attr_e('Cover Image', 'matebook') ?>" src="<?php echo esc_url($vid_thumbnail);?>" />
            <?php 
            } else { ?>
            	<img alt="<?php echo esc_attr_e('Cover Image', 'matebook') ?>" src="<?php echo PeepSoVideos::get_cover_art($vid_artist, $vid_album, FALSE); ?>">
            <?php } ?>

			<?php
			$rand = rand(1, 5000);
			?>

			<svg class="mad-video-play" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36"><defs><clipPath id="ya-<?php echo esc_attr($rand) ?>"><path fill="#fff" d="M18-.001c9.94 0 18 8.059 18 18s-8.06 18-18 18c-9.941 0-18-8.059-18-18s8.059-18 18-18z"/></clipPath></defs><g><g><path fill="rgba(255,255,255,.2)" d="M18-.001c9.94 0 18 8.059 18 18s-8.06 18-18 18c-9.941 0-18-8.059-18-18s8.059-18 18-18z"/><path fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="20" stroke-width="2" d="M18-.001c9.94 0 18 8.059 18 18s-8.06 18-18 18c-9.941 0-18-8.059-18-18s8.059-18 18-18z" clip-path="url(&quot;#ya-<?php echo esc_attr($rand) ?>&quot;)"/></g><g><path fill="#fff" d="M14 11l10 7-10 7z"/></g></g></svg>
        </a>
    </div>
</div>
