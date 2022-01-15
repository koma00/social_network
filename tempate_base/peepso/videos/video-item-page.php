<div class="ps-video-wrapper <?php if (!$vid_thumbnail) { echo "ps-media__page-list-item--audio"; } ?> ps-js-video" data-post-id="<?php echo esc_attr($vid_post_id); ?>">
    <div class="ps-video-item">
        <a class="video-item" href="#" onclick="ps_comments.open('<?php echo esc_attr($vid_post_id); ?>', 'video'); return false;">
	        <?php if ($vid_thumbnail) { ?>
				<img src="<?php echo esc_url($vid_thumbnail);?>" />
		        <?php
	        } else { ?>
				<img src="<?php echo PeepSoVideos::get_cover_art($vid_artist, $vid_album, FALSE); ?>">
	        <?php } ?>
	        <?php
	        $rand = rand(1, 5000);
	        ?>
			<svg class="mad-video-play" xmlns="http://www.w3.org/2000/svg" width="63" height="63" viewBox="0 0 63 63"><defs><clipPath id="7eska-<?php echo esc_attr($rand) ?>"><path fill="#fff" d="M31.5-.002C48.897-.002 63 14.1 63 31.498s-14.103 31.5-31.5 31.5S0 48.895 0 31.498s14.103-31.5 31.5-31.5z"/></clipPath></defs><g><g><path fill="rgba(255,255,255,.2)" d="M31.5-.002C48.897-.002 63 14.1 63 31.498s-14.103 31.5-31.5 31.5S0 48.895 0 31.498s14.103-31.5 31.5-31.5z"/><path fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="20" stroke-width="2" d="M31.5-.002C48.897-.002 63 14.1 63 31.498s-14.103 31.5-31.5 31.5S0 48.895 0 31.498s14.103-31.5 31.5-31.5z" clip-path="url(&quot;#7eska-<?php echo esc_attr($rand) ?>&quot;)"/></g><g><path fill="#fff" d="M24 19l18 12.5L24 44z"/></g></g></svg>
        </a>
    </div>
</div>
