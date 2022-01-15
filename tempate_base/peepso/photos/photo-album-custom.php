<?php

$PeepSoActivity = PeepSoActivity::get_instance();
$PeepSoPhotos = PeepSoPhotos::get_instance();
$PeepSoUser = PeepSoUser::get_instance();
$empty_desc = empty($the_album->pho_album_desc);

?>
<div class="peepso">
  <?php PeepSoTemplate::exec_template('general', 'navbar'); ?>

  <div class="ps-page ps-page--album ps-page--album-custom">
    <?php PeepSoTemplate::exec_template('profile', 'focus', array('current'=>'photos')); ?>

    <div class="ps-album ps-album--custom <?php if ($can_edit) { ?>ps-album--edit<?php } ?>">
      <div class="ps-album__header">
        <?php if (!$can_edit) { ?>
        <div class="ps-album__title">
          <i class="gcis gci-images"></i><?php echo esc_html($the_album->pho_album_name); ?>
        </div>
        <?php } ?>

        <?php if ($can_delete) { ?>
        <a class="ps-btn ps-btn--sm" href="#" onclick="peepso.photos.show_dialog_delete_album(<?php echo esc_attr($the_album->pho_owner_id) . ',' . $album_id; ?>); return false;"><?php echo esc_html__('Remove album', 'matebook'); ?></a>
        <div data-album-delete-id="<?php echo esc_attr($album_id); ?>" class="delete-content" style="display: none;">
            <?php
                echo esc_html__(
                    'Are you sure you want to delete this album?',
                    'matebook'
                );
            ?>
        </div>
        <?php wp_nonce_field('photo-delete-album', '_delete_album_nonce'); ?>
        <?php } ?>

        <div class="ps-album__actions">
          <a class="ps-btn ps-btn--sm" href="<?php echo esc_url($photos_url); ?>"><i class="gcis gci-angle-left"></i><span><?php echo esc_html__('Back', 'matebook'); ?></span></a>
          <?php
          $can_upload = $can_edit;

          if($the_album->pho_owner_id != get_current_user_id() && $can_edit) {
            $can_upload = false;
          }

          $can_upload = apply_filters('peepso_permissions_photos_upload', $can_upload);

          if ($can_upload) {
          ?>
          <a class="ps-btn ps-btn--sm ps-btn--action" href="#" onclick="peepso.photos.show_dialog_add_photos(<?php echo get_current_user_id() . ',' . $album_id; ?>); return false;"><?php echo esc_html__('Add Photos', 'matebook'); ?></a>
          <?php } ?>
        </div>
      </div>

      <?php if ($can_edit) { ?>
      <div class="ps-album__title ps-js-album-name">
        <span class="ps-js-album-name-text"><?php echo esc_html($the_album->pho_album_name); ?></span>

        <div class="ps-album__title-edit ps-js-album-name-editor" style="display:none">
          <div class="ps-album__edit-input"><input type="text" class="ps-input ps-input--sm" maxlength="50" value="<?php echo esc_attr($the_album->pho_album_name); ?>"></div>
          <div class="ps-album__edit-action"><button type="button" class="ps-btn ps-btn--sm ps-btn--cp ps-js-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></button></div>
          <div class="ps-album__edit-action">
            <button type="button" class="ps-btn ps-btn--sm ps-btn--cp ps-tip ps-tip--inline ps-btn--action ps-js-submit" aria-label="<?php echo esc_html__('Save', 'matebook'); ?>">
              <img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" class="ps-loading ps-js-loading" alt="<?php esc_attr_e('Loading', 'matebook') ?>" style="display:none" />
              <i class="gcis gci-check"></i>
            </button>
          </div>
        </div>
        <a href="#" class="ps-album__edit-toggle ps-tip ps-tip--inline ps-js-album-name-trigger" aria-label="<?php echo esc_html__('Edit title', 'matebook'); ?>" onclick="peepso.album.edit_name(<?php echo esc_attr($the_album->pho_album_id); ?>, <?php echo esc_attr($the_album->pho_owner_id); ?>, this); return false;">
          <i class="gcis gci-edit"></i>
        </a>
      </div>
      <?php } ?>

      <?php if ($can_edit || !$empty_desc || $can_delete) {
          // get selected privacy
          $selected_value = FALSE;
          $selected_icon = FALSE;
          $selected_label = FALSE;

          foreach ($access_settings as $key => $value) {
              if (( $selected_value === FALSE ) || ( $key == $the_album->pho_album_acc )) {
                  $selected_value = $key;
                  $selected_icon = $value['icon'];
                  $selected_label = $value['label'];
              }
          }
      ?>
      <div class="ps-album__desc ps-js-album-desc">
        <div class="ps-album__desc-title">
          <?php echo esc_html__('Album description', 'matebook'); ?>
          <?php if ($can_edit) { ?>
          <a class="ps-album__edit-toggle ps-tip ps-tip--inline" href="#" aria-label="<?php echo esc_html__('Edit description', 'matebook'); ?>" onclick="peepso.album.edit_desc(<?php echo esc_attr($the_album->pho_album_id); ?>, <?php echo esc_attr($the_album->pho_owner_id); ?>, <?php echo esc_attr($the_album->pho_owner_id); ?>, this); return false;">
            <i class="gcis gci-edit"></i>
          </a>
          <?php } ?>

          <?php if ($can_edit) { ?>
          <div class="ps-dropdown ps-dropdown--menu ps-album__desc-privacy ps-js-dropdown ps-js-dropdown--privacy">
            <input type="hidden" value="<?php echo esc_attr($selected_value); ?>">
            <a type="button" class="ps-dropdown__toggle ps-js-dropdown-toggle ps-tip ps-tip--inline" aria-label="<?php echo esc_html__('Description privacy', 'matebook'); ?>">
              <span class="dropdown-value"><i class="<?php echo esc_attr($selected_icon); ?>"></i></span>
            </a>
            <div class="ps-dropdown__menu ps-js-dropdown-menu">
              <?php foreach ($access_settings as $key => $value) { ?>
              <a href="#" data-option-value="<?php echo esc_attr($key); ?>" onclick="peepso.album.change_acc(<?php echo esc_attr($the_album->pho_album_id); ?>, <?php echo esc_attr($the_album->pho_owner_id); ?>, <?php echo esc_attr($key); ?>, this); return false;">
                <i class="<?php echo esc_attr($value['icon']); ?>"></i>
                <span><?php echo esc_html($value['label']) ?></span>
              </a>
              <?php } ?>
            </div>
          </div>
          <?php } else { ?>
          <div class="ps-album__desc-privacy ps-js-dropdown ps-tip ps-tip--inline" aria-label="<?php echo esc_attr($selected_label); ?>">
            <span class="dropdown-value"><i class="<?php echo esc_attr($selected_icon); ?>"></i></span>
          </div>
          <?php } ?>
        </div>
        <div class="ps-album__desc-text ps-js-album-desc-text" style="<?php echo esc_attr($empty_desc) ? 'display:none' : '' ?>"><?php echo stripslashes($the_album->pho_album_desc); ?></div>
        <div class="ps-album__desc-text ps-js-album-desc-placeholder" style="<?php echo esc_attr($empty_desc) ? '' : 'display:none' ?>"><i><?php echo esc_html__('No description', 'matebook'); ?></i></div>
        <?php if ($can_edit) { ?>
        <div class="ps-album__desc-edit ps-js-album-desc-editor" style="display:none">
          <textarea class="ps-input ps-input--textarea"><?php echo stripslashes($the_album->pho_album_desc); ?></textarea>
          <button type="button" class="ps-btn ps-btn--sm ps-js-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></button>
          <button type="button" class="ps-btn ps-btn--sm ps-btn--action ps-js-submit">
            <img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" class="ps-js-loading" alt="<?php esc_attr_e('Loading', 'matebook') ?>" style="margin-right:5px;display:none" />
            <?php echo esc_html__('Save description', 'matebook'); ?>
          </button>
        </div>
        <?php } ?>
      </div>
      <?php } ?>

      <?php
      // adding capability to print extra fields for other plugins
      $PeepSoPhotos->photo_album_show_extra_fields($the_album->pho_post_id, $can_edit);
      ?>

      <div class="ps-album__filters">
        <div class="ps-album__list-view">
          <div class="ps-btn__group">
            <a href="#" class="ps-theme-btn--app ps-btn--cp ps-tip ps-tip--arrow ps-tip--inline ps-js-photos-viewmode" data-mode="small" aria-label="<?php echo esc_html__('Small thumbnails', 'matebook');?>"><i class="gcis gci-th"></i></a>
            <a href="#" class="ps-theme-btn--app ps-btn--cp ps-tip ps-tip--arrow ps-tip--inline ps-js-photos-viewmode" data-mode="large" aria-label="<?php echo esc_html__('Large thumbnails', 'matebook');?>"><i class="gcis gci-th-large"></i></a>
          </div>
        </div>

        <select class="ps-input ps-input--sm ps-input--select ps-js-photos-sortby">
          <option value="desc"><?php echo esc_html__('Newest first', 'matebook');?></option>
          <option value="asc"><?php echo esc_html__('Oldest first', 'matebook');?></option>
        </select>
      </div>

      <div class="mb-20"></div>
      <div class="ps-photos__list ps-js-photos ps-js-photos--<?php echo  apply_filters('peepso_user_profile_id', 0); ?>"></div>
      <div class="ps-js-photos-triggerscroll ps-js-photos-triggerscroll--<?php echo  apply_filters('peepso_user_profile_id', 0); ?>">
        <img class="ps-loading post-ajax-loader ps-js-photos-loading" src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" alt="<?php esc_attr_e('Loading', 'matebook') ?>" style="display:none" />
      </div>
      <div class="mb-20"></div>
    </div>

    <?php if($the_album->pho_post_id && (!$the_album->pho_system_album)) { ?>
    <div class="ps-album__comments">
      <?php $PeepSoActivity->post_actions(); ?>

      <?php do_action('peepso_post_before_comments'); ?>
      <div class="ps-comments">
        <div class="ps-comments__inner cstream-respond wall-cocs" id="wall-cmt-<?php echo esc_attr($act_id); ?>">
            <div class="ps-comments__list comment-container ps-js-comment-container ps-js-comment-container--<?php echo esc_attr($act_id); ?>" data-act-id="<?php echo esc_attr($act_id); ?>">
              <?php if( $PeepSoActivity->has_comments()) { ?>
                <?php $PeepSoActivity->show_recent_comments(); ?>
              <?php } ?>
            </div>

            <?php if (is_user_logged_in() ) { ?>
            <div id="act-new-comment-<?php echo esc_attr($act_id); ?>" class="ps-comments__reply cstream-form stream-form wallform ps-js-newcomment-<?php echo esc_attr($act_id); ?> ps-js-comment-new" data-type="stream-newcomment" data-formblock="true">
                <a class="ps-avatar cstream-avatar cstream-author" href="<?php echo esc_url($PeepSoUser->get_profileurl()); ?>">
                    <img data-author="<?php echo get_current_user_id(); ?>" src="<?php echo esc_url($PeepSoUser->get_avatar()); ?>" alt="<?php esc_attr_e('Loading', 'matebook') ?>" />
                </a>
                <div class="ps-comments__input-wrapper ps-textarea-wrapper cstream-form-input">
                    <textarea
                        data-act-id="<?php echo esc_attr($act_id);?>"
                        class="ps-comments__input ps-textarea cstream-form-text"
                        name="comment"
                        oninput="return activity.on_commentbox_change(this);"
                        placeholder="<?php echo esc_attr__('Write a comment...', 'matebook');?>"></textarea>
                    <?php
                    // call function to add button addons for comments
                    $PeepSoActivity->show_commentsbox_addons();
                    ?>
                </div>
                <div class="ps-comments__reply-send cstream-form-submit" style="display:none;">
                    <div class="ps-loading ps-comment-loading" style="display:none;">
                        <img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" alt="<?php esc_attr_e('Loading', 'matebook') ?>" />
                        <div> </div>
                    </div>
                    <div class="ps-comments__reply-actions ps-comment-actions" style="display:none;">
                        <button onclick="return activity.comment_cancel(<?php echo esc_attr($act_id); ?>);" class="ps-btn ps-button-cancel"><?php echo esc_html__('Clear', 'matebook'); ?></button>
                        <button onclick="return activity.comment_save(<?php echo esc_attr($act_id); ?>, this);" class="ps-btn ps-btn--action ps-button-action" disabled><?php echo esc_html__('Post', 'matebook'); ?></button>
                    </div>
                </div>
            </div>
            <?php } // is_user_loggged_in ?>
        </div>
      </div>
    </div>
    <?php } // have post_id and empty?>
  </div>
</div>
<?php PeepSoTemplate::exec_template('activity','dialogs'); ?>
