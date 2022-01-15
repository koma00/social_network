<?php

namespace Matebook\Ext\Peepso;

if ( ! defined('ABSPATH') ) {
	exit;
}

class Layout {

	use \Matebook\Src\Traits\Instantiatable;

	public function __construct() {
		add_action('peepso_init', [ $this, 'init'] );
	}

	public function init() {
		add_filter('peepso_member_buttons', [$this, 'member_buttons'], 30, 2);
	}

	/**
	 * Add the send message button when a user is viewing the friends list
	 * @param  array $options
	 * @return array
	 */
	public function member_buttons($options, $user_id)
	{
		if (FALSE === apply_filters('peepso_permissions_messages_create', TRUE)) {
			return $options;
		}

		if (class_exists('PeepSoMessagesPlugin')) {

			$current_user = intval(get_current_user_id());

			if ($current_user !== $user_id &&
			    \PeepSo::check_permissions($user_id, \PeepSoMessagesPlugin::PERM_SEND_MESSAGE, $current_user)
			) {
				$options['message'] = array(
					'class' => 'ps-member__action ps-member__action--message',
					'click' => 'ps_messages.new_message(' . $user_id . ', false, this); return false;',
					'icon' => 'gcir gci-envelope',
					'label' => esc_html__('Chat', 'matebook'),
					'loading' => false
				);
			}

		}

		return ($options);
	}

}
