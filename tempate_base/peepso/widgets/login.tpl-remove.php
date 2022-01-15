<?php

echo ''. $args['before_widget'];

$PeepSoProfile=PeepSoProfile::get_instance();
$PeepSoUser = $PeepSoProfile->user;

$disable_registration = intval(PeepSo::get_option('site_registration_disabled', 0));
// PeepSo/peepso#2906 hide "resend activation" until really necessary
$hide_resend_activation = TRUE;

$view_class = $instance['view_option'];

?>

<?php
  if(!$instance['user_id'] > 0)
  {
?>

  <div class="ps-widget--profile__wrapper ps-widget--external">
    <!-- Title of Profile Widget -->
    <?php
    if ( ! empty( $instance['title'] ) ) {
      echo ''. $args['before_title'] . apply_filters( 'widget_title™', $instance['title'] ). $args['after_title'];
    }
    ?>
    <div class="ps-widget--login ps-widget--login-<?php echo esc_attr($view_class); ?>">
      <form class="ps-form ps-form--login ps-form--login-widget" action="" onsubmit="return false;" method="post" name="login" id="form-login-login">
        <div class="ps-form__container">
          <?php if ($view_class == "vertical") { ?>
          <div class="ps-form__row ps-js-username-field">
            <div class="ps-form__field ps-form__field--group">
              <div class="ps-input__prepend">
                <i class="ps-icon-user"></i>
              </div>
              <input class="ps-input ps-full" type="text" name="username" placeholder="<?php esc_attr_e('Username', 'matebook'); ?>" data-mouseev="true"
                 autocomplete="off" data-keyev="true" data-clickev="true" />
            </div>
          </div>

          <div class="ps-form__row ps-js-password-field">
            <div class="ps-form__field ps-form__field--group">
              <input class="ps-input ps-full" type="password" name="password" placeholder="<?php esc_attr_e('Password', 'matebook'); ?>" data-mouseev="true"
                 autocomplete="off" data-keyev="true" data-clickev="true" />
				<div class="ps-input__prepend">
					<i class="ps-icon-lock"></i>
				</div>
            </div>
          </div>

          <?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>
          <?php if( PeepSo::two_factor_plugin_enabled() /* is_plugin_active('two-factor-authentication/two-factor-login.php') */ ) { ?>
          <div class="ps-form__row ps-js-tfa-field" style="display:none">
            <div class="ps-form__field ps-form__field--group">
              <input class="ps-input ps-full" type="text" name="two_factor_code" placeholder="<?php esc_attr_e('TFA code', 'matebook'); ?>" data-mouseev="true"
                 autocomplete="off" data-keyev="true" data-clickev="true" data-ps-extra="1" />
				<div class="ps-input__prepend">
					<i class="ps-icon-clock"></i>
				</div>
            </div>
          </div>
          <?php } ?>

          <div class="ps-form__row">
            <div class="ps-form__field">
              <div class="ps-checkbox">
                <input type="checkbox" value="yes" name="remember" id="remember2" <?php echo PeepSo::get_option('site_frontpage_rememberme_default', 0) ? ' checked':'';?>>
                <label for="remember2"><?php echo esc_html__('Remember Me', 'matebook'); ?></label>
              </div>
            </div>
          </div>

          <?php if(0 === $disable_registration) { ?>
          <div class="ps-form__row">
            <div class="ps-form__field">
              <a class="ps-link ps-link--register" href="<?php echo PeepSo::get_page('register'); ?>"><?php echo esc_html__('Register', 'matebook'); ?></a>
            </div>
          </div>
          <?php } ?>

          <div class="ps-form__row">
            <div class="ps-form__field">
              <a class="ps-link ps-link--recover" href="<?php echo PeepSo::get_page('recover'); ?>"><?php echo esc_html__('Forgot Password', 'matebook'); ?></a>
            </div>
          </div>

          <?php if(0 === $disable_registration) { ?>
          <div class="ps-form__row ps-js-register-activation" style="display: none;">
            <div class="ps-form__field">
              <a class="ps-link ps-link--activation" href="<?php echo PeepSo::get_page('register'); ?>?resend"><?php echo esc_html__('Resend activation code', 'matebook'); ?></a>
            </div>
          </div>
          <?php } ?>

          <div class="ps-form__row">
            <div class="ps-form__field ps-form__field--submit">
              <button type="submit" class="ps-btn ps-btn-login">
                <span><?php echo esc_html__('Login', 'matebook'); ?></span>
                <img style="display:none" alt="<?php echo esc_attr__('Loading...', 'matebook') ?>" src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>">
              </button>
            </div>
          </div>
          <?php } else { ?>
            <div class="ps-form__row ps-form__row--group">
                <div class="ps-form__field ps-form__field--group ps-js-username-field">
                    <div class="ps-input__prepend">
                        <i class="ps-icon-user"></i>
                    </div>
                    <input class="ps-input ps-full" type="text" name="username" placeholder="<?php esc_attr_e('Username', 'matebook'); ?>" data-mouseev="true"
                 autocomplete="off" data-keyev="true" data-clickev="true" />
                </div>

                <div class="ps-form__field ps-form__field--group ps-js-password-field">
                    <div class="ps-input__prepend">
                        <i class="ps-icon-lock"></i>
                    </div>
                    <input class="ps-input ps-full" type="password" name="password" placeholder="<?php esc_attr_e('Password', 'matebook'); ?>" data-mouseev="true" autocomplete="off" data-keyev="true" data-clickev="true" />
                </div>

                <?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>
                <?php if( PeepSo::two_factor_plugin_enabled() /* is_plugin_active('two-factor-authentication/two-factor-login.php') */ ) { ?>
                <div class="ps-form__field ps-form__field--group ps-js-tfa-field" style="display:none">
                    <div class="ps-input__prepend">
                        <i class="ps-icon-clock"></i>
                    </div>
                    <input class="ps-input ps-full" type="text" name="two_factor_code" placeholder="<?php esc_attr_e('TFA code', 'matebook'); ?>" data-mouseev="true" autocomplete="off" data-keyev="true" data-clickev="true" data-ps-extra="1" />
                </div>
                <?php } ?>

                <div class="ps-form__field ps-form__field--submit">
                    <button type="submit" class="ps-btn ps-btn-login">
                        <span><?php echo esc_html__('Login', 'matebook'); ?></span>
                        <img style="display:none" alt="<?php echo esc_attr__('Loading...', 'matebook') ?>" src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>">
                    </button>
                </div>

            </div>

            <div class="ps-form__row ps-form__row--inline">
                <div class="ps-form__field">
                  <div class="ps-checkbox">
                    <input type="checkbox" value="yes" name="remember" id="remember2" <?php echo PeepSo::get_option('site_frontpage_rememberme_default', 0) ? ' checked':'';?>>
                    <label for="remember2"><?php echo esc_html__('Remember Me', 'matebook'); ?></label>
                  </div>
                </div>

                <div class="ps-form__field">

                <?php if (0 === $disable_registration) { ?>
                    <a class="ps-link ps-link--register" href="<?php echo PeepSo::get_page('register'); ?>"><?php echo _x('Register', 'Registration link in login panel', 'matebook'); ?></a>
                <?php } ?>

                <a class="ps-link ps-link--recover" href="<?php echo PeepSo::get_page('recover'); ?>"><?php echo esc_html__('Forgot Password', 'matebook'); ?></a>

                <?php if (0 === $disable_registration) { ?>
                    <a class="ps-link ps-link--activation ps-js-register-activation" href="<?php echo PeepSo::get_page('register'); ?>?resend" style="display: none;"><?php echo esc_html__('Resend activation code', 'matebook'); ?></a>
                <?php } ?>
                </div>
            </div>
          <?php } ?>
        </div>

        <input type="hidden" name="option" value="ps_users">
        <input type="hidden" name="task" value="-user-login">
        <input type="hidden" name="redirect_to" value="<?php echo PeepSo::get_page('redirectlogin'); ?>" />
        <?php
          // Remove ID attribute from nonce field.
          $nonce = wp_nonce_field('ajax-login-nonce', 'security', true, false);
          $nonce = preg_replace( '/\sid="[^"]+"/', '', $nonce );
          echo wp_kses($nonce, 'default');
        ?>

        <?php do_action('peepso_action_render_login_form_after'); ?>
      </form>
      <?php do_action('peepso_after_login_form'); ?>

      <script>
        (function() {
          function initLoginForm( $ ) {
            $('.ps-form--login-widget').off('submit').on('submit', function( e ) {
              e.preventDefault();
              e.stopPropagation();
              peepso.login.submit( e.target );
            });
          }

          // naively check if jQuery exist to prevent error
          var timer = setInterval(function() {
            if ( window.jQuery ) {
              clearInterval( timer );
              initLoginForm( window.jQuery );
            }
          }, 1000 );
        })();
      </script>
    </div>
  </div>
<?php
  }
?>

<?php
echo ''. $args['after_widget'];
// EOF
