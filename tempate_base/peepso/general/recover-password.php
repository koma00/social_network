<?php

$recaptchaEnabled = PeepSo::get_option( 'site_registration_recaptcha_enable', 0 );
$recaptchaClass   = $recaptchaEnabled ? ' ps-js-recaptcha' : '';

?>
<div class="peepso">
			<div id="peepso" class="on-socialize ltr cRegister">
				<h4><?php echo esc_html__( 'Forgot Password', 'matebook' ); ?></h4>

				<div class="ps-register-recover">
					<p>
						<?php echo esc_html__( 'Please enter the email address for your account. A verification code will be sent to you. Once you have received the verification code, you will be able to choose a new password for your account.', 'matebook' ); ?>
					</p>
					<div class="ps-gap"></div>
					<?php
					if ( isset( $error ) ) {
						PeepSoGeneral::get_instance()->show_error( $error );
					}
					?>
					<form id="recoverpasswordform" name="recoverpasswordform"
						  action="<?php PeepSo::get_page( 'recover' ); ?>?submit" method="post" class="ps-form">
						<input type="hidden" name="task" value="-recover-password"/>
						<input type="hidden" name="-form-id"
							   value="<?php echo wp_create_nonce( 'peepso-recover-password-form' ); ?>"/>
						<div class="ps-form__container">
							<label for="email"
								   class="ps-form__label"><?php echo esc_html__( 'Email Address:', 'matebook' ); ?>
								<span class="required-sign">&nbsp;*<span></span></span>
							</label>
							<div class="ps-form__row">
								<div class="ps-form__field">
									<input class="ps-input" type="email" name="email"
										   placeholder="<?php esc_attr_e( 'Email address', 'matebook' ); ?>"/>
								</div>
								<div class="ps-form__field submitel">
										<input type="submit" name="submit-recover"
											   class="ps-theme-btn border21 ps-theme-btn-big ps-theme-btn-primary<?php echo sprintf( '%s', $recaptchaClass ); ?>"
											   value="<?php esc_attr_e( 'Submit', 'matebook' ); ?>"/>
									</div>
							</div>
						</div>
					</form>
					<div class="ps-gap"></div>
					<a class="ps-theme-btn"
					   href="<?php echo site_url(); ?>"><?php echo esc_html__( 'Back to Home', 'matebook' ); ?></a>
				</div>
			</div><!--end peepso-->
</div><!--end row-->
