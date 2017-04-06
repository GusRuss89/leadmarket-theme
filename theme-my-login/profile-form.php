<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>

<?php

// Custom fields for leadmarket
$user_id = get_current_user_id();
$client_company = get_user_meta( $user_id, 'client_company', true );
$client_sales_email = get_user_meta( $user_id, 'client_sales_email', true );
$client_billing_email = get_user_meta( $user_id, 'client_billing_email', true );

?>

<div class="tml tml-profile" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php $template->the_action_template_message( 'profile' ); ?>
	<?php $template->the_errors(); ?>
	<form id="your-profile" class="lm-form" action="<?php $template->the_action_url( 'profile', 'login_post' ); ?>" method="post">
		<?php wp_nonce_field( 'update-user_' . $current_user->ID ); ?>

		<?php // Hidden fields ?>
		<div style="display: none;">
			<input type="hidden" name="from" value="profile" />
			<input type="hidden" name="checkuser_id" value="<?php echo $current_user->ID; ?>" />
			<input type="hidden" name="nickname" id="nickname" value="<?php echo esc_attr( $profileuser->nickname ); ?>" />
			<input type="checkbox" name="admin_bar_front" id="admin_bar_front" value="1"<?php checked( _get_admin_bar_pref( 'front', $profileuser->ID ) ); ?> />
			<select name="display_name" id="display_name">
				<?php
					$public_display = array();
					$public_display['display_username']  = $profileuser->user_login;
					foreach ( $public_display as $id => $item ) {
					?>
						<option <?php selected( $profileuser->display_name, $item ); ?>><?php echo $item; ?></option>
					<?php
					}
				?>
			</select>
		</div>

		<?php do_action( 'profile_personal_options', $profileuser ); ?>

		<div class="lm-form--item">
			<h3 style="margin: 0;">Update your details</h3>
		</div>

		<div class="lm-form--item tml-user-login-wrap">
			<label class="lm-form--label" for="user_login"><?php _e( 'Username', 'theme-my-login' ); ?></label>
			<label for="user_login" class="lm-form--description"><?php _e( 'Usernames cannot be changed.', 'theme-my-login' ); ?></label>
			<input type="text" name="user_login" id="user_login" value="<?php echo esc_attr( $profileuser->user_login ); ?>" disabled="disabled" class="lm-form--input lm-form--input__text regular-text" />
		</div>

		<div class="lm-form--item lm-form--item__l-one-half tml-first-name-wrap">
			<label class="lm-form--label" for="first_name"><?php _e( 'First Name', 'theme-my-login' ); ?></label>
			<input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( $profileuser->first_name ); ?>" class="lm-form--input lm-form--input__text regular-text" />
		</div>

		<div class="lm-form--item lm-form--item__l-one-half tml-last-name-wrap">
			<label class="lm-form--label" for="last_name"><?php _e( 'Last Name', 'theme-my-login' ); ?></label>
			<input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( $profileuser->last_name ); ?>" class="lm-form--input lm-form--input__text regular-text" />
		</div>

		<div class="lm-form--item">
			<label class="lm-form--label" for="client_company"><?php _e( 'Company Name', 'theme-my-login' ); ?></label>
			<input type="text" name="client_company" id="client_company" value="<?php echo esc_attr( $client_company ); ?>" class="lm-form--input lm-form--input__text regular-text" />
		</div>

		<div class="lm-form--item tml-user-email-wrap">
			<label class="lm-form--label" for="email"><?php _e( 'Account Email', 'theme-my-login' ); ?><span class="lm-form--asterix">*</span></label>
			<input type="email" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ); ?>" class="lm-form--input lm-form--input__text regular-text" />
			<?php
			$new_email = get_option( $current_user->ID . '_new_email' );
			if ( $new_email && $new_email['newemail'] != $current_user->user_email ) : ?>
			<div class="updated inline">
			<p><?php
				printf(
					__( 'There is a pending change of your e-mail to %1$s. <a href="%2$s">Cancel</a>', 'theme-my-login' ),
					'<code>' . $new_email['newemail'] . '</code>',
					esc_url( self_admin_url( 'profile.php?dismiss=' . $current_user->ID . '_new_email' ) )
			); ?></p>
			</div>
			<?php endif; ?>
		</div>

		<div class="lm-form--item lm-form--item__l-one-half">
			<label class="lm-form--label" for="client_sales_email"><?php _e( 'Sales Email', 'theme-my-login' ); ?></label>
			<label for="client_sales_email" class="lm-form--description">Where should we send new lead notifications? (If different from account email)</label>
			<input type="text" name="client_sales_email" id="client_sales_email" value="<?php echo esc_attr( $client_sales_email ); ?>" class="lm-form--input lm-form--input__text regular-text" />
		</div>

		<div class="lm-form--item lm-form--item__l-one-half">
			<label class="lm-form--label" for="client_billing_email"><?php _e( 'Billing Email', 'theme-my-login' ); ?></label>
			<label for="client_billing_email" class="lm-form--description">Where should we send your monthly invoices? (If different from account email)</label>
			<input type="text" name="client_billing_email" id="client_billing_email" value="<?php echo esc_attr( $client_billing_email ); ?>" class="lm-form--input lm-form--input__text regular-text" />
		</div>

		<?php
		/**
		 * We'll try not to touch the markup for the password form too much
		 * because it has a lot of JS associated with it.
		 */
		?>

		<?php
		$show_password_fields = apply_filters( 'show_password_fields', true, $profileuser );
		if ( $show_password_fields ) :
		?>

		<div class="lm-form--item">
			<h3 style="margin-top: 30px;"><?php _e( 'Update your password (optional)', 'theme-my-login' ); ?></h3>
			<table class="tml-form-table">
			<tr id="password" class="user-pass1-wrap">
				<th><label for="pass1"><?php _e( 'New Password', 'theme-my-login' ); ?></label></th>
				<td>
					<input class="hidden" value=" " /><!-- #24364 workaround -->
					<button type="button" class="button button-secondary wp-generate-pw hide-if-no-js"><?php _e( 'Generate Password', 'theme-my-login' ); ?></button>
					<div class="wp-pwd hide-if-js">
						<span class="password-input-wrapper">
							<input type="password" name="pass1" id="pass1" class="regular-text" value="" autocomplete="off" data-pw="<?php echo esc_attr( wp_generate_password( 24 ) ); ?>" aria-describedby="pass-strength-result" />
						</span>
						<div style="display:none" id="pass-strength-result" aria-live="polite"></div>
						<button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Hide password', 'theme-my-login' ); ?>">
							<span class="dashicons dashicons-hidden"></span>
							<span class="text"><?php _e( 'Hide', 'theme-my-login' ); ?></span>
						</button>
						<button type="button" class="button button-secondary wp-cancel-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Cancel password change', 'theme-my-login' ); ?>">
							<span class="text"><?php _e( 'Cancel', 'theme-my-login' ); ?></span>
						</button>
					</div>
				</td>
			</tr>
			<tr class="user-pass2-wrap hide-if-js">
				<th scope="row"><label for="pass2"><?php _e( 'Repeat New Password', 'theme-my-login' ); ?></label></th>
				<td>
				<input name="pass2" type="password" id="pass2" class="regular-text" value="" autocomplete="off" />
				<p class="description"><?php _e( 'Type your new password again.', 'theme-my-login' ); ?></p>
				</td>
			</tr>
			<tr class="pw-weak">
				<th><?php _e( 'Confirm Password', 'theme-my-login' ); ?></th>
				<td>
					<label>
						<input type="checkbox" name="pw_weak" class="pw-checkbox" />
						<?php _e( 'Confirm use of weak password', 'theme-my-login' ); ?>
					</label>
				</td>
			</tr>
			<?php endif; ?>

			</table>
		</div>

		<?php do_action( 'show_user_profile', $profileuser ); ?>

		<div class="tml-submit-wrap lm-form--item lm-form--footer">
			<input type="hidden" name="action" value="profile" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $current_user->ID ); ?>" />
			<input type="submit" class="btn button-primary" value="<?php esc_attr_e( 'Update Profile', 'theme-my-login' ); ?>" name="submit" id="submit" />
		</div>
	</form>
</div>
