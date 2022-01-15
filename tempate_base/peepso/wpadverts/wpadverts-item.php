<div class="ps-classified__item-wrapper ps-js-classifieds-item ps-js-classifieds-item--{{= data.id }}">
	<div class="ps-classified__item{{ if (data.is_featured) { }} ps-classified__item--featured {{ } }}">
		<div class="ps-classified__item-body">
			{{ if ( data.image ) { }}
			<a class="ps-classified__item-image" href="{{= data.permalink }}">
				<img src="{{= data.image }}" alt="{{= data.image }}">
			</a>
			{{ } }}

			<div class="ps-classified_item-content">
				<h3 class="ps-classified__item-title">
					<a href="{{= data.permalink }}">{{= data.title }}</a>
				</h3>

				{{ if (data.price) { }}
				<div class="ps-classified__item-details">
					<a class="ps-classified__item-price" href="{{= data.permalink }}">{{= data.price }}</a>
				</div>
				{{ } }}

				<div class="ps-classified__item-desc">{{= data.content }}</div>
			</div>

		</div>

		<div class="ps-classified__item-footer ps-text--muted">
			<span><i class="ps-icon-user"></i> {{= data.author }}</span>
			<span><i class="ps-icon-clock"></i> {{= data.date_formated }}</span>
			{{ if ( data.location ) { }}
			<span><i class="ps-icon-map-marker"></i> {{= data.location }}</span>
			{{ } }}
			{{ if ( data.is_owner == true || data.is_admin == true ) { }}
			<span><i class="ps-icon-clock"></i> {{ if (data.is_expired) { }}<?php echo esc_html__('expired', 'matebook'); ?>{{ } else { }}<?php echo esc_html__('expires', 'matebook'); ?>{{ } }}: {{= data.expires }}</span>
			{{ } }}

			<div class="ps-classified__item-actions">
				<div class="ps-classified__actions ps-js-action">

					<div class="ps-classified__actions-inner ps-btn__group">
						<?php
						if( 1 == PeepSo::get_option('wpadverts_chat_enable', 0)) { ?>
							{{ if ( window.ps_messages && ! data.is_owner ) { }}
							<a href="#" class="ps-classified__action ps-tip ps-tip--inline ps-btn ps-btn--sm ps-btn--cp ps-btn--app ps-js-wpadverts-message" aria-label="<?php echo esc_html__('Send Message', 'matebook'); ?>" data-id="{{= data.user_id }}">
								<i class="gcis gci-envelope"></i>
								<img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" style="display:none" />
							</a>
							{{ } }}
						<?php } ?>

						<a href="{{= data.permalink }}" class="ps-classified__action ps-link--more" aria-label="<?php echo esc_html__('More', 'matebook'); ?>">
							<i class="ps-icon-info-circled"></i>
							<span><?php echo esc_html__('More', 'matebook'); ?></span>
						</a>

						{{ if ( data.is_owner || data.is_admin ) { }}
						<?php $baseurl = apply_filters( "adverts_manage_baseurl", get_the_permalink() ); ?>
						<?php if (PeepSoWPAdverts::isVersion140()) :?>
							<a href="<?php echo admin_url( 'admin-ajax.php' ) ?>?action=adverts_delete&id={{= data.id }}&redirect_to=<?php echo urlencode( $baseurl ) ?>&_ajax_nonce={{= data.nonce_delete}}"
							   class="ps-classified__action adverts-manage-action-delete ps-link--delete ps-js-delete"
							   title="<?php echo esc_html__('Delete', 'matebook'); ?>"
							   data-url="<?php echo admin_url('admin-ajax.php'); ?>"
							   data-id="{{= data.id }}"
							   data-nonce="{{= data.nonce_delete}}">
								<i class="ps-icon-trash"></i>
							</a>
						<?php else:?>
							<a href="<?php echo admin_url( 'admin-ajax.php' ) ?>?action=adverts_delete&id={{= data.id }}&redirect_to=<?php echo urlencode( $baseurl ) ?>&_ajax_nonce=<?php echo wp_create_nonce('adverts-delete') ?>"
							   class="ps-classified__action adverts-manage-action-delete ps-link--delete ps-js-delete"
							   title="<?php echo esc_html__('Delete', 'matebook'); ?>"
							   data-url="<?php echo admin_url('admin-ajax.php'); ?>"
							   data-id="{{= data.id }}"
							   data-nonce="<?php echo wp_create_nonce('adverts-delete') ?>">
								<i class="ps-icon-trash"></i>
							</a>
						<?php endif; ?>
						<a href="{{= data.edit_url }}" class="ps-classified__action ps-link--edit">
							<i class="ps-icon-pencil"></i>
						</a>
						{{ } }}
					</div>

					{{ if ( data.is_owner || data.is_admin ) { }}
					<div class="ps-classified__delete-box ps-js-delete-confirm" style="display:none">
						<div class="ps-classified__delete-box-inner">
							<div class="ps-classified__delete-box-notice">
								<i class="ps-icon-trash"></i>
								<?php echo esc_html__('Are you sure?', 'matebook'); ?>
							</div>
							<a href="#" class="ps-js-delete-yes">
								<i class="gcis gci-circle-notch gci-spin ps-js-loading" style="display:none"></i>
								<?php echo esc_html__('Yes', 'matebook'); ?>
							</a> &nbsp;
							<a href="#" class="ps-js-delete-no">
								<?php echo esc_html__('Cancel', 'matebook'); ?>
							</a>
						</div>
					</div>
					{{ } }}
				</div>

			</div>
		</div>
	</div>
</div>
