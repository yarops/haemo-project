<?php
/**
 * Google recaptcha class
 *
 * @category WordPress theme
 * @package haemo
 */

namespace App;

use function App\Utils\get_setting;

class Recaptcha {

	/**
	 * Initialize class
	 */
	public function __construct() {
		add_filter( 'comment_form_defaults', array( $this, 'add_google_recaptcha' ) );

		if ( ! is_user_logged_in() ) {
			add_action( 'pre_comment_on_post', array( $this, 'verify_google_recaptcha' ) );
		}
	}

	/**
	 * Google reCAPTCHA: Add widget before the submit button
	 *
	 * @param array $args Arguments.
	 *
	 * @return [type] Modified arguments.
	 */
	public function add_google_recaptcha( $args ) {
		$args['submit_field'] = $args['submit_field'] . '
			<input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
			';
		return $args;
	}

	/**
	 * Recaptcha response field for custom form template
	 * call if $args['submit field'] already use
	 *
	 * @return string Field html.
	 */
	public function recaptcha_response_field() {
		return '<input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">';
	}

	/**
	 * Google reCAPTCHA: verify response and validate comment submission
	 *
	 * @param string $captcha Recaptcha input value.
	 *
	 * @return [type]
	 */
	private function is_valid_captcha_response( $captcha ) {
		$captcha_postdata = http_build_query(
			array(
				'secret'   => get_setting( 'cs_recaptcha_secret' ),
				'response' => $captcha,
				'remoteip' => $_SERVER['REMOTE_ADDR'],
			)
		);
		$captcha_opts     = array(
			'http' => array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $captcha_postdata,
			),
		);
		$captcha_context  = stream_context_create( $captcha_opts );
		$captcha_response = json_decode( file_get_contents( 'https://www.google.com/recaptcha/api/siteverify', false, $captcha_context ), true );
		if ( $captcha_response['success'] && $captcha_response['score'] > 0.5 ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Check google recaptcha on post comment
	 *
	 * @return void
	 */
	public function verify_google_recaptcha() {
		$recaptcha = $_POST['g-recaptcha-response'];
		if ( empty( $recaptcha ) ) {
			wp_die( __( "<p><strong>Error:</strong> Sorry, spam detected!</p><p><a href='javascript:history.back()'>« Back</a></p>" ) );
		} elseif ( ! $this->is_valid_captcha_response( $recaptcha ) ) {
			wp_die( __( '<b>Sorry, spam detected!</b>' ) );
		}
	}
}
