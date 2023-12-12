<?php

/**
 * Process Form
 * Sanitize and store form input, then email it 
 *
 * @author Prosparky <http://prosparky.com>
 */

// Run processing if the form was submitted and
// the admin Editor is not active

if( 
	$_SERVER['REQUEST_METHOD'] == 'POST'
	&& isset($_GET['editor']) === false
) {

	require 'includes/phpMailer/PHPMailerAutoload.php';

	$error = '';
	$error_code = '';
	$success = false;
	$success_message = '<p>Thank You! Your offer has now been sent.</p>';
	$missing_fields = array();
	$field_data = array();
	$honeypot_field = 'url';

	//Check if honeypot field is filled out
	//if it is, stop here are give a generic error
	if( isset($_POST[$honeypot_field]) && $_POST[$honeypot_field] != '' ) {
		$error = '<li>There was an error processing the form. Please refresh the page and try again.</li>';
	}

	if( $config['enable_recaptcha'] === true ) {

		//Verify reCAPTCHA response

		if( 
			isset($_POST['g-recaptcha-response']) 
			&& $_POST['g-recaptcha-response'] != ''
		) {

			// Set the URL to post to and fields to send
			$url = 'https://www.google.com/recaptcha/api/siteverify';
			$recaptcha_response = filter_var( $_POST['g-recaptcha-response'], FILTER_SANITIZE_STRING );
			$recaptcha_fields = array(
				'secret' => $config['recaptcha_private_key'],
				'response' => $recaptcha_response,
				'remoteip' => $_SERVER['REMOTE_ADDR']
			);

			// Convert fields to URL string
			$fields_string = '';
			foreach( $recaptcha_fields as $key => $value ) { 
				$fields_string .= $key.'='.$value.'&'; 
			}
			rtrim($fields_string, '&');

			// Open connection
			$ch = curl_init();

			// Set the return, url, number of post vars, post data
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_POST, count($recaptcha_fields) );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields_string );

			// Execute post and decode result
			$result = json_decode(curl_exec($ch), true);

			// Close connection
			curl_close($ch);

			if( $result['success'] === false ) {
				$error = '<li>The reCAPTCHA wasn\'t right, please try again.</li>';
			}
			
		} else {
			$error = '<li>reCAPTCHA must be filled out.</li>';
		}

	}
    
    
	if( $error == '' ) {

		// Define accepted fields, and their human-friendly names

		$fields = array(
			'offer' => 'Offer',
			'name' 	=> 'Full Name',
            'phone' => 'Phone',
			'email' => 'Email',
		);
        
            
		// Validate, sanitize, and store contact form input

		$result = validateAndSanitize($fields);
		$field_data = $result['field_data'];
		$missing_fields = $result['missing_fields'];

	} 
    

	foreach ($missing_fields as $field) {
		$error .= "<li>{$fields[$field]} must be filled out</li>";
	}
    

	if( $error == '' && empty($missing_fields) ) {
		$mail = new PHPMailer;

		// If SMTP server and email password are filled out, use SMTP
		if( 
			$config['smtp_server'] != ''
			&& $config['recipient_email_password'] != ''
		 ) {
		 	// Verbose debugging messages
			//$mail->SMTPDebug = 3;  
			// Set mailer to use SMTP
			$mail->isSMTP();                                      
			// Specify main SMTP server
			$mail->Host = $config['smtp_server'];  
			// Enable SMTP authentication
			$mail->SMTPAuth = true;                               
			// SMTP username
			$mail->Username = $config['recipient_email'];
			// SMTP password                 
			$mail->Password = $config['recipient_email_password'];
			// Enable TLS encryption, `ssl` also accepted                    
			$mail->SMTPSecure = 'tls';                            
			// TCP port to connect to
			$mail->Port = 587;                                    
		}                             

		$mail->From = $config['recipient_email'];
		$mail->FromName = $config['recipient_name'];
		// Add a recipient
		$mail->addAddress($config['recipient_email'], $config['recipient_name']);    
		$mail->addReplyTo($field_data['email'], $field_data['name']);

		// Set email format to HTML
		$mail->isHTML(true);

		$mail->Subject = "Domain offer for {$_SERVER['HTTP_HOST']}";
		$mail->Body    = "
            Great News! <br>
            <br>
			{$field_data['name']} has submitted an offer for {$_SERVER['HTTP_HOST']}
            <br>
            <br>
			Offer: {$field_data['offer']} {$_POST['currency']}<br>
			<br>
            E-mail: {$field_data['email']}
            <br>
            Phone Number: {$field_data['phone']}<br>
            <br>
			-- <br>
			Sent by Domain Seller via {$_SERVER['HTTP_HOST']}
		";
		$mail->AltBody = strip_tags($mail->Body);

		if(!$mail->send()) {
			$error_code = 'SMTP';
		    $error = 'Sorry, this offer could not be sent. Please try again. <!-- Mailer Error: ' . $mail->ErrorInfo . ' -->';
		} else {
		    $success = $success_message;
		}
	}

	// If it's an AJAX request, stop execution here
	if( isset($_GET['ajax']) ) {
		$response = array('error' => $error, 'error_code' => $error_code, 'success' => $success);
		echo json_encode($response); 
		exit;
	}
}