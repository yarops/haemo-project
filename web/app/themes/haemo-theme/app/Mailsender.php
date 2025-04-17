<?php
/**
 * Mailsender class file
 *
 * @category WordPress theme
 * @package haemo
 */

namespace App;

/**
 * Mailsender class
 */
class Mailsender {

	/**
	 * Initialize class
	 */
	public function __construct() {
		add_action( 'wp_ajax_app_sendmail', array( $this, 'app_sendmail' ) );
		add_action( 'wp_ajax_nopriv_app_sendmail', array( $this, 'app_sendmail' ) );
	}

	/**
	 * Send mail
	 *
	 * @return void
	 */
	public function app_sendmail() {

		check_ajax_referer( 'app-nonce', 'nonce' );

		app()->recaptcha->verify_google_recaptcha();

		$email   = sanitize_email( $_POST['email'] );
		$name    = sanitize_text_field( $_POST['name'] );
		$message = sanitize_text_field( $_POST['message'] );

		add_filter(
			'wp_mail_content_type',
			function ( $content_type ) {
				return 'text/html';
			}
		);

		$to      = ( cs_get_setting( 'cs_mail' ) ) ? cs_get_setting( 'cs_mail' ) : get_option( 'admin_email' );
		$subject = 'Contact Email : ' . $email;
		$body    = '<html>
			<body>
				<table>
					<tr>
						<td>Name</td> <td>' . $name . '</td>
					</tr>
					<tr>
						<td>Email</td> <td>' . $email . '</td>
					</tr>
					<tr>
						<td>Message</td> <td>' . $message . '</td>
					</tr>

				</table>
			</body>
		</html>';
		$headers = array( 'Content-Type: text/html; charset=UTF-8' );

		if ( ( $email ) && ( $name ) && ( $message ) ) {
			$success_user = wp_mail( $to, $subject, $body, '', array( '' ) );
			if ( $success_user ) {
				echo '<div class="form__success">Your message has been succesfully sent to admin</div>';
			} else {
				echo '<div class="form__failed">Your message failed to be sent to admin. Please try again</div>';
			}
		}
		$aStr = '';
		if ( ! $email ) {
			$aStr = '<div class="form__failed">You must fill your email first</div>';
		}
		if ( ! $name ) {
			$aStr = $aStr . '<div class="form__failed">You must fill your subject first</div>';
		}
		if ( ! $message ) {
			$aStr = $aStr . '<div class="form__failed">You must fill your message first</div>';
		}
		if ( $aStr ) {
			echo $aStr;
		}
		wp_die();
	}
}
