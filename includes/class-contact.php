<?php
/**
 * Showcase - an open source portfolio platform for freelancers.
 * 
 * @package 	Showcase.Core
 * @author 		Omar Mokhtar Al-Asad
 * @link 		http://omarqe.com
 * 
 * @copyright	Copyright (C) 2016-2017 Margs Empire. All right reserved.
 * @license 	MIT license; see LICENSE.txt for more detials.
 **/

/**
 * Get the reCAPTCHA HTML input.
 * 
 * @see 	Contact::get_recaptcha()
 * @since 	1.0
 **/
function get_recaptcha( $return = false ){
	global $contact;
	return $contact->get_recaptcha( $return );
}

/**
 * Return the flag whether the reCAPTCHA is enabled or otherwise.
 *
 * @return 	boolean
 * @since 	1.0
 **/
function has_recaptcha(){
	global $contact;
	return $contact->has_recaptcha();
}

/**
 * Validate the reCAPTCHA input.
 * 
 * @see 	Contact::valid_recaptcha()
 * @return 	boolean
 * @since 	1.0
 **/
function valid_recaptcha( $response_code ){
	global $contact;
	return $contact->valid_recaptcha( $response_code );
}

/**
 * Send enquiry.
 * 
 * @see 	Contact::send_enquiry()
 * @return 	boolean
 **/
function send_enquiry( $email, $message, $name = '' ){
	global $contact;
	return $contact->send_enquiry( $email, $message, $name );
}

/**
 * Get the error message.
 * 
 * @return 	string
 * @since 	1.0
 **/
function get_contact_error(){
	global $contact;

	$error_message = $contact->error;

	return !empty($error_message) ? $error_message : "There's an error while sending your enquiry.";
}

class Contact {
	/**
	 * Enable reCAPTCHA or otherwise.
	 * 
	 * @var 	boolean
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $recaptcha_enabled = false;

	/**
	 * The code used in the reCAPTCHA HTML input.
	 * 
	 * @var 	boolean
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $site_key = '';

	/**
	 * The code used to communicate with Google's server.
	 * 
	 * @var 	boolean
	 * @access 	protected
	 * @since 	1.0
	 **/
	protected $secret_key = '';

	/**
	 * PHPMailer object.
	 * 
	 * @var 	object
	 * @access 	public
	 * @since 	1.0
	 **/
	public $mailer;

	/**
	 * Error message.
	 * 
	 * @var 	string
	 * @access 	public
	 * @since 	1.0
	 **/
	public $error;

	/**
	 * Constructor function.
	 * 
	 * @since 	1.0
	 **/
	public function __construct(){
		$settings = get_settings( 'recaptcha' );

		list( $enabled, $site_key, $secret_key ) = get_list(
			['enabled', 'site_key', 'secret_key'],
			$settings
		);

		$this->recaptcha_enabled = (bool)$enabled;
		$this->mailer = new PHPMailer();

		if ( $enabled ){
			$this->site_key = $site_key;
			$this->secret_key = $secret_key;
		}
	}

	/**
	 * Return the flag whether the reCAPTCHA is enabled or otherwise.
	 *
	 * @return 	boolean
	 * @since 	1.0
	 **/
	public function has_recaptcha(){
		return (bool)$this->recaptcha_enabled;
	}

	/**
	 * Verify the reCAPTCHA input server-side.
	 * 
	 * @param 	string 		$response_code 	The value of g-recaptcha-response.
	 * @return 	boolean
	 * @since 	1.0
	 **/
	public function valid_recaptcha( $response_code ){
		if ( ! has_recaptcha() )
			return true;
		if ( empty($response_code) )
			return false;

		$response = curl_post('https://www.google.com/recaptcha/api/siteverify', array(
			'secret' => $this->secret_key,
			'response' => $response_code,
			'remoteip' => $_SERVER['REMOTE_ADDR']
		));

		if ( $response === false )
			return false;

		$response = json_decode( $response, true );
		list( $success, $error_code ) = get_list(['success', 'error-codes'], $response);

		return ($success == true);
	}

	/**
	 * Get the reCAPTCHA input to display in the form. Please note that the reCAPTCHA javascript must be included
	 * in the document first.
	 * 
	 * @param 	boolean 	$return 	Set to true to return the HTML as string instead.
	 * @return 	string
	 * @since 	1.0
	 **/
	public function get_recaptcha( $return = false ){
		$site_key = $this->site_key;
		if ( !has_recaptcha() || empty($site_key) || empty($this->secret_key) )
			return '';

		$snippet = '<div class="g-recaptcha" data-sitekey="%s"></div>';

		if ( $return === true )
			return __( $snippet, $site_key );

		_e( $snippet, $site_key );
	}

	/**
	 * Send the message.
	 * 
	 * @param 	string 		$email 		The sender's email.
	 * @param 	string 		$message 	The message.
	 * @param 	string 		$name 		The sender's full name.
	 * @return 	boolean
	 **/
	public function send_enquiry( $email, $message, $name = '' ){
		$mailer = $this->mailer;
		$settings = get_settings( 'smtp' );
		$contact_info = spyc_load_file( abspath('/contents/user/contact.yaml') );

		$recipient = parse_arg( 'email', $contact_info );

		list( $host, $port, $username, $password, $mail_subject ) = get_list(
			['host', 'port', 'username', 'password', 'mail_subject'],
			$settings
		);

		if ( empty($host) && $this->error = "SMTP host is not set." )
			return false;
		elseif ( empty($email) && $this->error = "Sender's email is empty." )
			return false;
		elseif ( empty($recipient) && $this->error = "The recipient's email is empty. If you're the portfolio owner, please set this in your contact file." )
			return false;
		elseif ( empty($message) && $this->error = "The email message is empty." )
			return false;
		elseif ( strtolower($email) == strtolower($recipient) && $this->error = "Sender's email can't be the same as the recipient's." )
			return false;

		// Initialise PHPMailer settings
		$mailer->isSMTP();
		$mailer->Host = $host;
		$mailer->Port = $port;
		$mailer->SMTPSecure = 'tls';
		$mailer->SMTPAuth = true;

		$mailer->Username = $username;
		$mailer->Password = $password;

		// Set the email
		$mailer->setFrom( $email, $name );
		$mailer->addReplyTo( $email, $name );
		$mailer->addAddress( $recipient ); // The recipient address

		// Set the email body
		$mailer->Subject = $mail_subject;
		$mailer->Body    = $message;

		if ( !$mailer->send() ){
			$this->error = $mailer->ErrorInfo;
			return false;
		}

		return true;
	}
}