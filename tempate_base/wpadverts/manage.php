<div class="adverts-grid">
    <?php if( $loop->have_posts()): ?>
    <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
    <?php global $post ?>
    
    <?php $columns = 1; ?>
    <div class="advert-manage-item <?php echo 'advert-item advert-item-col-'.(int)$columns ?>">

        <?php $image = adverts_get_main_image( get_the_ID() ) ?>
        <div class="advert-img">
            <?php if($image): ?>
				<a href="<?php the_permalink() ?>">
					<img src="<?php echo esc_url($image) ?>" alt="<?php echo esc_attr(get_the_title()) ?>" class="advert-item-grow" />
				</a>
            <?php endif; ?>
        </div>

		<div class="advert-post-content">

			<div class="advert-post-title">
            <span class="adverts-manage-link">

				<h3><a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ) ?>" class="advert-link-wraps"><?php the_title() ?></a></h3>

				<span class="adverts-manage-info">
                    <?php $price = get_post_meta( get_the_ID(), "adverts_price", true ) ?>
					<?php if( $price ): ?>
						<span class="adverts-manage-price"><?php echo adverts_price( $price ) ?></span>
					<?php endif; ?>

					<?php $expires = get_post_meta( $post->ID, "_expiration_date", true ) ?>
					<?php if( $expires ): ?>
						<span class="adverts-manage-date adverts-icon-history"><abbr title="<?php echo esc_attr__( sprintf( __( "Expires %s", "matebook" ), date_i18n( get_option("date_format"), $expires ) ) ) ?>"><?php esc_html_e( apply_filters( 'adverts_sh_manage_date', date_i18n( __( 'Y/m/d', "matebook" ), $expires ), $post ) ) ?></abbr></span>
					<?php endif; ?>
                </span>

	            <?php if($post->post_status == "pending"): ?>
					<span class="adverts-inline-icon adverts-inline-icon-warn adverts-icon-lock" title="<?php esc_attr_e("Inactive — This Ad is in moderation.", "matebook") ?>"></span>
	            <?php endif; ?>

	            <?php if($post->post_status == "expired"): ?>
					<span class="adverts-inline-icon adverts-inline-icon-warn adverts-icon-eye-off" title="<?php esc_attr_e("Inactive — This Ad expired.", "matebook") ?>"></span>
	            <?php endif; ?>

	            <?php do_action("adverts_sh_manage_list_status", $post) ?>

            </span>

			</div>

			<div class="advert-published adverts-manage-actions-wrap">

            <span class="adverts-manage-actions-left">
                <a href="<?php echo esc_url(get_the_permalink()) ?>" title="<?php esc_attr_e("View", "matebook") ?>" class="adverts-manage-action"><span class="adverts-icon-eye"></span><?php echo esc_html__("View", "matebook") ?></a>
                <a href="<?php echo esc_url($baseurl . str_replace("%#%", get_the_ID(), $edit_format)) ?>" title="<?php esc_attr_e("Edit", "matebook") ?>" class="adverts-manage-action"><span class="adverts-icon-pencil-squared"></span><?php echo esc_html__("Edit", "matebook") ?></a>
                <a href="<?php echo esc_url(adverts_ajax_url()) ?>?action=adverts_delete&id=<?php echo get_the_ID() ?>&redirect_to=<?php echo esc_attr( urlencode( $baseurl ) ) ?>&_ajax_nonce=<?php echo wp_create_nonce( sprintf( 'wpadverts-delete-%d', get_the_ID() ) ) ?>" title="<?php esc_attr_e("Delete", "matebook") ?>" class="adverts-manage-action adverts-manage-action-delete" data-id="<?php echo get_the_ID() ?>" data-nonce="<?php echo wp_create_nonce( sprintf( 'wpadverts-delete-%d', get_the_ID() ) ) ?>">
                    <span class="adverts-icon-trash-1"></span><?php echo esc_html__("Delete", "matebook") ?>
                </a>

                <div class="adverts-manage-action adverts-manage-delete-confirm">
                    <span class="adverts-icon-trash-1"></span>
	                <?php echo esc_html__( "Are you sure?", "matebook" ) ?>
					<span class="animate-spin adverts-icon-spinner adverts-manage-action-spinner" style="display:none"></span>
                    <a href="#" class="adverts-manage-action-delete-yes"><?php echo esc_html__( "Yes", "matebook" ) ?></a>
                    <a href="#" class="adverts-manage-action-delete-no"><?php echo esc_html__( "Cancel", "matebook" ) ?></a>
                </div>

	            <?php do_action( "adverts_sh_manage_actions_left", $post->ID, $baseurl ) ?>
            </span>
				<span class="adverts-manage-actions-right">
                <?php do_action( "adverts_sh_manage_actions_right", $post->ID, $baseurl ) ?>

					<a href="#" class="adverts-manage-action adverts-manage-action-more"><span class="adverts-icon-menu"></span><?php echo esc_html__("More", "matebook") ?></a>
            </span>

				<div class="adverts-manage-actions-more">
					<?php do_action( "adverts_sh_manage_actions_more", $post->ID, $baseurl ) ?>
				</div>
			</div>

		</div>

        <?php do_action( "adverts_sh_manage_actions_after", $post->ID, $baseurl ) ?>
        
    </div>
    
    <?php endwhile; ?>
    <?php else: ?>
    <div class="adverts-grid-row adverts-grid-compact">
        <div class="adverts-grid-col adverts-col">
            <em><?php echo esc_html__("You do not have any Ads posted yet.", "matebook") ?></em>
        </div>
    </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</div>

<div class="adverts-pagination">
    <?php echo paginate_links( array(
        'base' => $paginate_base,
	'format' => $paginate_format,
	'current' => max( 1, $paged ),
	'total' => $loop->max_num_pages,
        'prev_next' => false
    ) ); ?>
</div>