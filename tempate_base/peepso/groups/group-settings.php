<div class="peepso">
  <div class="ps-page ps-page--group ps-page--group-settings">
    <?php PeepSoTemplate::exec_template('general','navbar'); ?>
    <?php PeepSoTemplate::exec_template('general', 'register-panel'); ?>

    <?php if(get_current_user_id()) { ?>
      <div class="ps-group__edit">
        <?php
        PeepSoTemplate::exec_template('groups', 'group-header', array('group'=>$group, 'group_segment'=>$group_segment));
        $group_users = new PeepSoGroupUsers($group->id);
        $group_user = new PeepSoGroupUser($group->id);
        ?>

        <div class="ps-group__edit-fields">
          <!-- NAME -->
          <div class="ps-group__edit-field ps-group__edit-field--name ps-js-group-name">
            <div class="ps-group__edit-field-row">
              <div class="ps-group__edit-field-header">
                <div class="ps-group__edit-field-title">
                  <span><?php echo esc_html__('Group Name', 'matebook'); ?></span>
                  <span class="ps-group__edit-field-required">*</span>
                </div>

                <?php if ($group_user->can('manage_group')) { ?>
                <div class="ps-group__edit-field-edit">
                  <button class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-btn-edit" onclick="ps_group.edit_name(<?php echo esc_attr($group->id); ?>, this);">
					  <i class="material-icons">edit</i>
					  <?php echo esc_html__('Edit','matebook');?>
                  </button>
                </div>

                <div class="ps-group__edit-field-actions">
                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-btn-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></button>

                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--action ps-js-btn-submit">
                    <img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" class="ps-js-loading" alt="<?php echo esc_attr__( 'Loading', 'matebook' ) ?>" style="display:none" />
                    <?php echo esc_html__('Save', 'matebook'); ?>
                  </button>
                </div>
                <?php } ?>
              </div>

              <div class="ps-group__edit-field-static">
                <div class="ps-group__edit-field-data ps-js-group-name-text">
                  <?php echo esc_html($group->name);?>
                </div>
              </div>

              <?php if ($group_user->can('manage_group')) { ?>
              <div class="ps-group__edit-field-form ps-js-group-name-editor" style="display:none">
                <div class="ps-input__wrapper">
                  <input type="text" class="ps-input ps-input--sm ps-input--count" maxlength="<?php echo PeepSoGroup::$validation['name']['maxlength'];?>" data-maxlength="<?php echo PeepSoGroup::$validation['name']['maxlength'];?>" value="<?php echo esc_attr($group->name); ?>">
                  <div class="ps-form__chars-count"><span class="ps-js-limit"><?php echo PeepSoGroup::$validation['name']['maxlength'];?></span> <?php echo esc_html__('Characters left', 'matebook'); ?></div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div><!-- end: NAME -->

          <!--  SLUG -->
          <?php if ($group_user->can('manage_group') && 2 == PeepSo::get_option('groups_slug_edit', 0)) {

          $slug = urldecode($group->slug);
          ?>
          <div class="ps-group__edit-field ps-group__edit-field--slug ps-js-group-slug">
            <div class="ps-group__edit-field-row">
              <div class="ps-group__edit-field-header">
                <div class="ps-group__edit-field-title">
                  <span><?php echo esc_html__('Group Slug', 'matebook'); ?></span>
                  <span class="ps-group__edit-field-required">*</span>
                </div>

                <div class="ps-group__edit-field-edit">
                  <button class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-group-slug-trigger" onclick="ps_group.edit_slug(<?php echo esc_attr($group->id); ?>, this);">
					  <i class="material-icons">edit</i>
					  <?php echo esc_html__('Edit','matebook');?>
                  </button>
                </div>

                <div class="ps-group__edit-field-actions">
                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></button>

                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--action ps-js-submit">
                    <img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" class="ps-js-loading" alt="<?php echo esc_attr__( 'Loading', 'matebook' ) ?>" style="display:none" />
                    <?php echo esc_html__('Save', 'matebook'); ?>
                  </button>
                </div>
              </div>

              <div class="ps-group__edit-field-static">
                <div class="ps-group__edit-field-data ps-js-group-slug-text">
                  <?php echo PeepSo::get_page('groups')."<strong>$slug</strong>"; ?>
                </div>
              </div>

              <div class="ps-group__edit-field-form ps-js-group-slug-editor" style="display:none">
                <div class="ps-input__wrapper">
                  <input size="30" class="ps-input ps-input--sm" maxlength="<?php echo PeepSoGroup::$validation['name']['maxlength'];?>" data-maxlength="<?php echo PeepSoGroup::$validation['name']['maxlength'];?>" value="<?php echo esc_attr($slug); ?>">
                </div>
                <div class="ps-group__edit-field-desc">
                  <?php
                  echo esc_html__('Letters, numbers and dashes are recommended, eg my-amazing-group-123.','matebook') .'<br/>'.__('This field might be automatically adjusted  after editing.','matebook');
                  ?>
                </div>
              </div>
            </div>
          </div><!-- end: SLUG -->
          <?php } ?>

          <!-- DESCRIPTION -->
          <div class="ps-group__edit-field ps-group__edit-field--desc ps-js-group-desc">
            <div class="ps-group__edit-field-row">
              <div class="ps-group__edit-field-header">
                <div class="ps-group__edit-field-title">
                  <span><?php echo esc_html__('Group Description', 'matebook'); ?></span>
                  <span class="ps-group__edit-field-required">*</span>
                </div>

                <?php if ($group_user->can('manage_group')) { ?>
                <div class="ps-group__edit-field-edit">
                  <button class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-btn-edit" onclick="ps_group.edit_desc(<?php echo esc_attr($group->id); ?>, this);">
					  <i class="material-icons">edit</i>
					  <?php echo esc_html__('Edit','matebook');?>
                  </button>
                </div>

                <div class="ps-group__edit-field-actions">
                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></button>
                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--action ps-js-submit">
                      <img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" class="ps-js-loading" alt="<?php echo esc_attr__( 'Loading', 'matebook' ) ?>" style="display:none" />
                      <?php echo esc_html__('Save', 'matebook'); ?>
                  </button>
                </div>
                <?php } ?>
              </div>

              <div class="ps-group__edit-field-static">
                <?php
                $description = str_replace("\n","<br/>", $group->description);
                $description = html_entity_decode($description);
                if (PeepSo::get_option_new('md_groups_about', 0)) {
                  $description = PeepSo::do_parsedown($description);
                }
                ?>

                <div class="ps-group__edit-field-data">
                  <span class="ps-js-group-desc-text" style="<?php echo empty($group->description) ? 'display:none' : '' ?>"><?php echo stripslashes($description); ?></span>
                  <span class="ps-js-group-desc-placeholder" style="<?php echo empty($group->description) ? '' : 'display:none' ?>"><i><?php echo esc_html__('No description', 'matebook'); ?></i></span>
                </div>
              </div>

              <?php if ($group_user->can('manage_group')) { ?>
              <div class="ps-group__edit-field-form ps-js-group-desc-editor" style="display:none">
                <div class="ps-input__wrapper">
                  <textarea class="ps-input ps-input--sm ps-input--textarea ps-input--count" rows="10" data-maxlength="<?php echo PeepSoGroup::$validation['description']['maxlength'];?>"><?php echo html_entity_decode($group->description); ?></textarea>
                  <div class="ps-form__chars-count"><?php echo PeepSoGroup::$validation['description']['maxlength'];?></span> <?php echo esc_html__('Characters left', 'matebook'); ?></div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div><!-- end: DESCRIPTION -->

          <?php if(PeepSo::get_option('groups_categories_enabled', FALSE)) { ?>
          <!-- CATEGORIES -->
          <div class="ps-group__edit-field ps-group__edit-field--cats ps-js-group-cat">
            <div class="ps-group__edit-field-row">
              <div class="ps-group__edit-field-header">
                <div class="ps-group__edit-field-title">
                  <span><?php
                  $group_categories = PeepSoGroupCategoriesGroups::get_categories_for_group($group->id);

                  echo _n('Category', 'Categories', count($group_categories), 'matebook'); ?></span>
                  <span class="ps-group__edit-field-required">*</span>
                </div>

                <?php if ($group_user->can('manage_group')) { ?>
                <div class="ps-group__edit-field-edit">
                  <button class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-btn-edit" onclick="ps_group.edit_cats(<?php echo esc_attr($group->id); ?>, this);">
					  <i class="material-icons">edit</i>
					  <?php echo esc_html__('Edit','matebook');?>
                  </button>
                </div>

                <div class="ps-group__edit-field-actions">
                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></button>
                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--action ps-js-submit">
                      <img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" class="ps-js-loading" alt="<?php echo esc_attr__( 'Loading', 'matebook' ) ?>" style="display:none" />
                      <?php echo esc_html__('Save', 'matebook'); ?>
                  </button>
                </div>
                <?php } ?>
              </div>

              <div class="ps-group__edit-field-static">
                <div class="ps-group__edit-field-data ps-js-group-cat-text">
                  <?php
                    $group_categories_html = array();
                    foreach ($group_categories as $PeepSoGroupCategory) {
                      echo "<a href=\"{$PeepSoGroupCategory->get_url()}\">{$PeepSoGroupCategory->name}</a>";
                    }
                  ?>
                </div>
              </div>

              <?php if ($group_user->can('manage_group')) { ?>
              <div class="ps-group__edit-field-form ps-js-group-cat-editor" style="display:none">
                <div class="ps-input__wrapper ps-checkbox__grid">
                  <?php

                  $multiple_enabled = PeepSo::get_option('groups_categories_multiple_enabled', FALSE);
                  $input_type = ($multiple_enabled) ? 'checkbox' : 'radio';
                  $PeepSoGroupCategories = new PeepSoGroupCategories(FALSE, TRUE);
                  $categories = $PeepSoGroupCategories->categories;

                  if (count($categories)) {
                      foreach ($categories as $id => $category) {
                          $checked = '';
                          if (isset($group_categories[$id])) {
                              $checked = 'checked="checked"';
                          }
                          echo sprintf('<div class="ps-checkbox"><input class="ps-checkbox__input" %s type="%s" id="category_' . $id . '" name="category_id" value="%d"><label class="ps-checkbox__label" for="category_' . $id . '">%s</label></div>', $checked, $input_type, $id, $category->name);
                      }
                  }

                  ?>
                </div>
              </div>
              <?php } ?>
            </div>
          </div><!-- end: CATEGORIES -->
          <?php } ?>

          <?php if(!$group->is_secret) { ?>
          <!-- JOIN BUTTON -->
          <div class="ps-group__edit-field ps-group__edit-field--join ps-js-group-is_joinable">
            <div class="ps-group__edit-field-row">
              <div class="ps-group__edit-field-header">
                <div class="ps-group__edit-field-title">
                  <span>
                    <?php
                      if($group->is_open) { echo esc_html__('Enable "Join" button', 'matebook'); }
                      if($group->is_closed) { echo esc_html__('Enable "Request To Join" button', 'matebook'); }
                    ?>
                  </span>
                  <div class="ps-group__edit-field-note">
                    <?php echo esc_html__('Has no effect on Site Administrators','matebook'); ?>
                  </div>
                </div>

                <?php if ($group_user->can('manage_group')) { ?>
                <div class="ps-group__edit-field-edit">
                  <button class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-btn-edit" onclick="ps_group.edit_property(this, <?php echo esc_attr($group->id); ?>, 'is_joinable');">
					  <i class="material-icons">edit</i>
					  <?php echo esc_html__('Edit','matebook');?>
                  </button>
                </div>

                <div class="ps-group__edit-field-actions">
                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-btn-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></button>

                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--action ps-js-btn-submit">
                      <img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" class="ps-js-loading" alt="<?php echo esc_attr__( 'Loading', 'matebook' ) ?>" style="display:none" />
                      <?php echo esc_html__('Save', 'matebook'); ?>
                  </button>
                </div>
                <?php } ?>
              </div>

              <div class="ps-group__edit-field-static">
                <div class="ps-group__edit-field-data ps-js-text">
                  <?php echo ''. ($group->is_joinable) ? esc_html__('Yes', 'matebook') : esc_html__('No', 'matebook');?>
                </div>
              </div>

              <?php if ($group_user->can('manage_group')) { ?>
              <div class="ps-group__edit-field-form ps-js-editor" style="display:none">
                <div class="ps-input__wrapper">
                  <select name="is_joinable" class="ps-input ps-input--sm ps-input--select">
                    <option value="1"><?php echo esc_html__('Yes', 'matebook');?></option>
                    <option value="0" <?php if(FALSE == $group->is_joinable) { echo "selected";}?>><?php echo esc_html__('No', 'matebook');?></option>
                  </select>
                </div>
              </div>
              <?php } ?>
            </div>
          </div><!-- end: JOIN BUTTON -->
          <?php } ?>

          <!-- INVITE BUTTON -->
          <div class="ps-group__edit-field ps-group__edit-field--invite ps-js-group-is_invitable">
            <div class="ps-group__edit-field-row">
              <div class="ps-group__edit-field-header">
                <div class="ps-group__edit-field-title">
                  <span>
                    <?php echo esc_html__('Enable "Invite" button', 'matebook'); ?>
                  </span>
                  <div class="ps-group__edit-field-note">
                    <?php echo esc_html__('Has no effect on Owner, Managers and Site Administrators','matebook'); ?>
                  </div>
                </div>

                <?php if ($group_user->can('manage_group')) { ?>
                <div class="ps-group__edit-field-edit">
                  <button class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-btn-edit" onclick="ps_group.edit_property(this, <?php echo esc_attr($group->id); ?>, 'is_invitable');">
					  <i class="material-icons">edit</i>
					  <?php echo esc_html__('Edit','matebook');?>
                  </button>
                </div>

                <div class="ps-group__edit-field-actions">
                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-btn-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></button>

                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--action ps-js-btn-submit">
                      <img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" class="ps-js-loading" alt="<?php echo esc_attr__( 'Loading', 'matebook' ) ?>" style="display:none" />
                      <?php echo esc_html__('Save', 'matebook'); ?>
                  </button>
                </div>
                <?php } ?>
              </div>

              <div class="ps-group__edit-field-static">
                <div class="ps-group__edit-field-data ps-js-text">
                  <?php echo ''. ($group->is_invitable) ? esc_html__('Yes', 'matebook') : esc_html__('No', 'matebook');?>
                </div>
              </div>

              <?php if ($group_user->can('manage_group')) { ?>
              <div class="ps-group__edit-field-form ps-js-editor" style="display:none">
                <div class="ps-input__wrapper">
                  <select name="is_invitable" class="ps-input ps-input--sm ps-input--select">
                    <option value="1"><?php echo esc_html__('Yes', 'matebook');?></option>
                    <option value="0" <?php if(FALSE == $group->is_invitable) { echo "selected";}?>><?php echo esc_html__('No', 'matebook');?></option>
                  </select>
                </div>
              </div>
              <?php } ?>
            </div>
          </div><!-- end: INVITE BUTTON -->

          <!-- DISABLE POSTING -->
          <div class="ps-group__edit-field ps-group__edit-field--readonly ps-js-group-is_readonly">
            <div class="ps-group__edit-field-row">
              <div class="ps-group__edit-field-header">
                <div class="ps-group__edit-field-title">
                  <span>
                    <?php echo esc_html__('Disable new posts', 'matebook'); ?>
                  </span>
                  <div class="ps-group__edit-field-note">
                    <?php echo esc_html__('Has no effect on Owner, Managers and Site Administrators','matebook'); ?>
                  </div>
                </div>

                <?php if ($group_user->can('manage_group')) { ?>
                <div class="ps-group__edit-field-edit">
                  <button class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-btn-edit" onclick="ps_group.edit_property(this, <?php echo esc_attr($group->id); ?>, 'is_readonly');">
					  <i class="material-icons">edit</i>
					  <?php echo esc_html__('Edit','matebook');?>
                  </button>
                </div>

                <div class="ps-group__edit-field-actions">
                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-btn-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></button>

                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--action ps-js-btn-submit">
                      <img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" class="ps-js-loading" alt="<?php echo esc_attr__( 'Loading', 'matebook' ) ?>" style="display:none" />
                      <?php echo esc_html__('Save', 'matebook'); ?>
                  </button>
                </div>
                <?php } ?>
              </div>

              <div class="ps-group__edit-field-static">
                <div class="ps-group__edit-field-data ps-js-text">
                  <?php echo ''. ($group->is_readonly) ? esc_html__('Yes', 'matebook') : esc_html__('No', 'matebook');?>
                </div>
              </div>

              <?php if ($group_user->can('manage_group')) { ?>
              <div class="ps-group__edit-field-form ps-js-editor" style="display:none">
                <div class="ps-input__wrapper">
                  <select name="is_readonly" class="ps-input ps-input--sm ps-input--select">
                      <option value="1"><?php echo esc_html__('Yes', 'matebook');?></option>
                      <option value="0" <?php if(FALSE == $group->is_readonly) { echo "selected";}?>><?php echo esc_html__('No', 'matebook');?></option>
                  </select>
                </div>
              </div>
              <?php } ?>
            </div>
          </div><!-- end: DISABLE POSTING -->

          <!-- DISABLE COMMENTS / REACTINS / LIKE -->
          <div class="ps-group__edit-field ps-group__edit-field--interactable ps-js-group-is_interactable">
            <div class="ps-group__edit-field-row">
              <div class="ps-group__edit-field-header">
                <div class="ps-group__edit-field-title">
                  <span>
                    <?php echo esc_html__('Disable likes/comments', 'matebook'); ?>
                  </span>
                  <div class="ps-group__edit-field-note">
                    <?php echo esc_html__('Has no effect on Owner, Managers and Site Administrators','matebook'); ?>
                  </div>
                </div>

                <?php if ($group_user->can('manage_group')) { ?>
                <div class="ps-group__edit-field-edit">
                  <button class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-btn-edit" onclick="ps_group.edit_property(this, <?php echo esc_attr($group->id); ?>, 'is_interactable');">
					  <i class="material-icons">edit</i>
					  <?php echo esc_html__('Edit','matebook');?>
                  </button>
                </div>

                <div class="ps-group__edit-field-actions">
                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-btn-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></button>

                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--action ps-js-btn-submit">
                    <img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" class="ps-js-loading" alt="<?php echo esc_attr__( 'Loading', 'matebook' ) ?>" style="display:none" />
                    <?php echo esc_html__('Save', 'matebook'); ?>
                  </button>
                </div>
                <?php } ?>
              </div>

              <div class="ps-group__edit-field-static">
                <div class="ps-group__edit-field-data ps-js-text">
                  <?php echo ''. ($group->is_interactable) ? esc_html__('Yes', 'matebook') : esc_html__('No', 'matebook');?>
                </div>
              </div>

              <?php if ($group_user->can('manage_group')) { ?>
              <div class="ps-group__edit-field-form ps-js-editor" style="display:none">
                <div class="ps-input__wrapper">
                  <select name="is_interactable" class="ps-input ps-input--sm ps-input--select">
                      <option value="1"><?php echo esc_html__('Yes', 'matebook');?></option>
                      <option value="0" <?php if(FALSE == $group->is_interactable) { echo "selected";}?>><?php echo esc_html__('No', 'matebook');?></option>
                  </select>
                </div>
              </div>
              <?php } ?>
            </div>
          </div><!-- end: DISABLE COMMENTS / REACTINS / LIKE -->

          <!-- DISABLE NEW MEMBER NOTIFICATIONS -->
          <div class="ps-group__edit-field ps-group__edit-field--muted ps-js-group-is_join_muted">
            <div class="ps-group__edit-field-row">
              <div class="ps-group__edit-field-header">
                <div class="ps-group__edit-field-title">
                  <span>
                    <?php echo esc_html__('Disable new member notifications', 'matebook'); ?>
                  </span>
                  <div class="ps-group__edit-field-note">
                    <?php echo esc_html__('Group owners will not receive notifications about new members','matebook'); ?>
                  </div>
                </div>

                <?php if ($group_user->can('manage_group')) { ?>
                <div class="ps-group__edit-field-edit">
                  <button class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-btn-edit" onclick="ps_group.edit_property(this, <?php echo esc_attr($group->id); ?>, 'is_join_muted');">
					  <i class="material-icons">edit</i>
					  <?php echo esc_html__('Edit','matebook');?>
                  </button>
                </div>

                <div class="ps-group__edit-field-actions">
                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--app ps-js-btn-cancel"><?php echo esc_html__('Cancel', 'matebook'); ?></button>

                  <button type="button" class="ps-theme-btn ps-theme-btn-small ps-btn--action ps-js-btn-submit">
                      <img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" class="ps-js-loading" alt="<?php echo esc_attr__( 'Loading', 'matebook' ) ?>" style="display:none" />
                      <?php echo esc_html__('Save', 'matebook'); ?>
                  </button>
                </div>
                <?php } ?>
              </div>

              <div class="ps-group__edit-field-static">
                <div class="ps-group__edit-field-data ps-js-text">
                  <?php echo ''. ($group->is_join_muted) ? esc_html__('Yes', 'matebook') : esc_html__('No', 'matebook');?>
                </div>
              </div>

              <?php if ($group_user->can('manage_group')) { ?>
              <div class="ps-group__edit-field-form ps-js-editor" style="display:none">
                <div class="ps-input__wrapper">
                  <select name="is_join_muted" class="ps-input ps-input--sm ps-input--select">
                      <option value="1"><?php echo esc_html__('Yes', 'matebook');?></option>
                      <option value="0" <?php if(FALSE == $group->is_join_muted) { echo "selected";}?>><?php echo esc_html__('No', 'matebook');?></option>
                  </select>
                </div>
              </div>
              <?php } ?>
            </div>
          </div><!-- end: DISABLE NEW MEMBER NOTIFICATIONS -->
        </div>
      </div>
    <?php } ?>
  </div>
</div>
<?php

if(get_current_user_id()) {
    PeepSoTemplate::exec_template('activity' ,'dialogs');
}
