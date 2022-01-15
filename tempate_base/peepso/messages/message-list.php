<?php
$PeepSoMessages = PeepSoMessages::get_instance();
?>

<div class="ps-page-messages">


	<div class="section-title-holder with-elem">

		<h5><?php echo esc_html__( 'Messages', 'matebook' ); ?></h5>

		<div class="ps-messages__inbox-action ps-messages__inbox-action--new-message">
			<?php do_action('peepso_messages_list_header'); ?>
		</div>

	</div>

	<div class="ps-messages__header">
		<form action="" class="ps-form ps-messages__search ps-js-messages-search-form" role="form" onsubmit="return false;">
			<div class="ps-messages__search-inner">
				<input type="text" class="ps-input ps-input--sm search-query" name="query" aria-describedby="queryStatus"
					   value="<?php echo esc_attr($query); ?>" placeholder="<?php esc_attr_e('Search by content, or user', 'matebook'); ?>" />
				<button type="reset" class="ps-btn ps-btn--sm ps-btn--cp" title="<?php echo esc_attr__('Clear search', 'matebook') ?>">
					<i class="gcis gci-undo"></i>
				</button>
				<button type="submit" class="ps-btn ps-btn--sm ps-btn--cp" title="<?php echo esc_attr__('Search', 'matebook') ?>">
					<i class="gcis gci-search"></i>
				</button>
			</div>
			<div class="ps-messages__search-results ps-js-loading" style="display: none;">
				<img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" alt="<?php echo esc_attr__('Loading', 'matebook') ?>" />
			</div>
		</form>
	</div>

	<?php if ($total <= 0) : ?>
		<div class="ps-messages__info">
			<?php if (class_exists('PeepSoMessagesPlugin')) : ?>
				<p><?php echo esc_html__('No messages found.' ,'matebook'); ?></p>
				<?php do_action('peepso_messages_list_header'); ?>
			<?php else : ?>
				<?php echo esc_html__('No messages found.' ,'matebook'); ?>
			<?php endif; ?>
		</div>
	<?php else : ?>
		<form class="ps-form ps-messages__inbox" action="<?php PeepSo::get_page('messages');?>" method="post">
			<?php wp_nonce_field('messages-bulk-action', '_messages_nonce'); ?>

			<div class="ps-messages__inbox-actions">
				<div class="ps-messages__inbox-action">
					<div class="ps-checkbox">
						<input class="ps-checkbox__input" type="checkbox" id="messages-check" onclick="ps_messages.toggle_checkboxes(this)" value="" />
						<label class="ps-checkbox__label" for="messages-check"></label>
					</div>

					<div class="ps-input__wrapper ps-input__wrapper--inline">
						<?php $PeepSoMessages->display_bulk_actions($type); ?>
						<button type="button" class="ps-btn ps-btn--xs ps-js-bulk-actions"><?php echo esc_html__('Apply', 'matebook')?></button>
					</div>
				</div>

			</div>

			<div class="ps-messages__list ps-js-messages-list">
				<?php
				while ($message = $PeepSoMessages->get_next_message()) {
					$PeepSoMessages->show_message($message);
				}
				?>
			</div>
		</form>

	<?php endif; ?>

</div>

<?php if ( $total >= 0 ) : ?>
	<div class="ps-messages__pagination">
		<div class="ps-messages__pagination-inner">
			<a href="javascript:" class="ps-messages__pagination-item ps-messages__pagination-item--prev ps-js-prev">
				<i class="gcis gci-angle-left"></i>
			</a>
			<span class="ps-messages__pagination-item ps-messages__pagination-item--total">
				<?php $PeepSoMessages->display_totals();?>
			</span>
			<a href="javascript:" class="ps-messages__pagination-item ps-messages__pagination-item--next ps-js-next">
				<i class="gcis gci-angle-right"></i>
			</a>
		</div>
	</div>
<?php endif; ?>
