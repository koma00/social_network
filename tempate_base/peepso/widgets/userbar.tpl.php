<?php

echo ''. $args['before_widget'];

$PeepSoProfile=PeepSoProfile::get_instance();
$PeepSoUser = $PeepSoProfile->user;
$position = $instance['content_position'];

?>

	<div class="mad-widget--userbar ps-widget--userbar--<?php echo esc_attr($position); ?> ps-widget--external">

		<?php
			if($instance['user_id'] > 0) {

			$user  = $instance['user'];
			?>

				<?php if(isset($instance['show_avatar']) && 1 == intval($instance['show_avatar'])) { ?>
				<!-- Avatar -->
				<div class="mad-widget--userbar__avatar">
					<a class="mad-avatar" href="<?php echo esc_url($user->get_profileurl()); ?>">
						<img alt="<?php echo esc_attr($user->get_fullname());?> avatar" title="<?php echo esc_attr($user->get_profileurl());?>" src="<?php echo esc_url($user->get_avatar());?>">
					</a>
				</div>
				<?php } ?>

				<?php if(isset($instance['show_vip']) && 1 == intval($instance['show_vip'])) { ?>
					<div class="mad-widget--userbar__vip"><?php do_action('peepso_action_userbar_user_name_before', $user->get_id()); ?></div>
				<?php } ?>

				<?php if(isset($instance['show_name']) && 1 == intval($instance['show_name'])) { ?>
				<!-- Name, edit profile -->
				<div class="mad-widget--userbar__name">
					<a class="mad-user-name" href="<?php echo esc_url($user->get_profileurl());?>">
						<?php echo esc_html($user->get_firstname()); ?>
					</a>
				</div>
				<?php } ?>

				<?php
				if(isset($instance['show_badges']) && 1 == intval($instance['show_badges'])) {
					do_action('peepso_action_userbar_user_name_after', $user->get_id());
				}
				?>

				<?php
					// Profile Submenu extra links
					$instance['links']['peepso-core-preferences'] = array(
						'href' => $user->get_profileurl() . 'about/preferences/',
						'icon' => 'ps-icon-edit',
						'label' => esc_html__('Preferences', 'matebook'),
					);

					$instance['links']['peepso-core-logout'] = array(
						'href' => PeepSo::get_page('logout'),
						'icon' => 'ps-icon-off',
						'label' => esc_html__('Log Out', 'matebook'),
						'widget'=>TRUE,
					);
				?>

				<?php if(isset($instance['show_usermenu']) && 1 == intval($instance['show_usermenu'])) { ?>
					<div class="ps-dropdown ps-dropdown--right ps-dropdown--userbar ps-js-dropdown">
						<a href="#" class="ps-dropdown__toggle ps-js-dropdown-toggle">
							<span class="dropdown-caret ps-icon-angle-down"></span>
						</a>
					<div class="ps-dropdown__menu ps-js-dropdown-menu">
						<?php
							foreach($instance['links'] as $id => $link)
							{
								if(!isset($link['label']) || !isset($link['href']) || !isset($link['icon'])) {
									var_dump($link);
								}

								$class = isset($link['class']) ? $link['class'] : '' ;

								$href = $user->get_profileurl(). $link['href'];
								if('http' == substr(strtolower($link['href']), 0,4)) {
									$href = $link['href'];
								}

								echo '<a href="' . $href . '" class="' . $class . '"><span class="' . $link['icon'] . '"></span> ' . $link['label'] . '</a>';
							}
						?>
					</div>
				</div>
				<?php } ?>

				<?php
					do_action('peepso_action_userbar_notifications_before', $user->get_id());

					// Notifications
					echo ''. $instance['toolbar'];

					do_action('peepso_action_userbar_notifications_after', $user->get_id());
				?>

				<?php if (isset($instance['show_logout']) && 1 == intval($instance['show_logout'])) { ?>
				<div class="mad-widget--userbar__logout">
					<a href="<?php echo PeepSo::get_page('logout'); ?>" title="<?php echo esc_attr__('Log Out', 'matebook'); ?>" arialabel="<?php echo esc_attr__('Log Out', 'matebook'); ?>"><i class="ps-icon-off"></i></a>
				</div>
				<?php } ?>
			<?php
		} else {
			?>
			<a href="<?php echo PeepSo::get_page('activity'); ?>"><?php echo esc_html__('Log in', 'matebook'); ?></a>
		<?php
		}
		?>

	</div>

<?php
echo ''. $args['after_widget'];
// EOF
