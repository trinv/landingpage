<?php 

/**
 * Domain Seller Editor
 * Customize your install visually!
 *
 * @author Prosparky <http://prosparky.com>
 */ 

// -------------------------------------------------------------------
// 1. Log in with OAuth 
// -------------------------------------------------------------------

session_start();

// If authentication data isn't stored, redirect to auth page
if( $config['editor_login_email'] == '' || $config['editor_login_email'] == 'email@somedomain.com' ) {
	echo '<p><strong>Error:</strong> you must enter your email using the <code style="background:#FFFFCA">editor_login_email</code> setting found in the config.php file. For more details, please refer to the documentation.</p>'; 
	exit;
} elseif( ! isset($_SESSION['opauth']) ) {
	header("Location:./auth/");
	exit;
} else {
	// validate authenticated email matches email set in config.php
	if( $_SESSION['opauth']['auth']['info']['email'] != $config['editor_login_email'] ) {
		// Does not match
		echo '<p><strong>Error:</strong> the account you logged in with has a different email than the <code style="background:#FFFFCA">editor_login_email</code> setting found in the config.php file. Please change that setting to the email associated with your account.</p><p><a href="./auth/">Take me back to the login screen</a></p>'; 
		exit;
	}
}

// -------------------------------------------------------------------
// 2. Process saved changes
// -------------------------------------------------------------------
// Changes will be sent using an AJAX request from the editor.js file

if( 
	isset($_GET['editor']) 
	&& isset($_GET['ajax'])
) {

	$error = '';
	$success = false;
	$field_data = array();

	$fields_not_required = array(
        'header_text' => '',
        'header_subtext' => '',
		'domains' => '',
        'price' => '',
        'price_description' => '',
		'enable_domain_portfolio' => '',
		'enable_recaptcha' => '',
		'recaptcha_public_key' => '',
		'recaptcha_private_key' => '',
		'image' => '',
		'tint' => '',
        'text_color' => '',
        'theme_color' => '',
		'texture' => '',
        'enable_social' => '',
        'footer_text' => '',
		'twitter_handle' => '',
        'facebook_handle' => '',
        'instagram_handle' => '',
        'googleplus_handle' => '',
        'linkedin_handle' => '',
        'youtube_handle' => '',
        'pinterest_handle' => '',
        'enable_adsense' => '',
        'client_handle' => '',
        'slot_handle' => '',
	);

	// Validate, sanitize, and store contact form input

	$result = validateAndSanitize($_POST, $fields_not_required);
	$field_data = $result['field_data'];
	$missing_fields = $result['missing_fields'];

	foreach ($missing_fields as $field) {
		$error .= "<li>" . ucwords($field) . " must be filled out</li>";
	}

	// Save input in config.php file

	if( $error == '' ) {
		
		// Read config template
		if( $config_template = file_get_contents('includes/config-template.php') ) {

			// Go through each config setting
			// If new value for setting was entered, use it
			// example key: 'editor_auth_methods'
			foreach($config as $key => $value) {
				if( isset($field_data[$key]) ) {
					$config[$key] = $field_data[$key];
				}
				// Set specific string for boolean values
				if($config[$key] === TRUE) {
					$config[$key] = 'true';
				}
				if($config[$key] === FALSE) {
					$config[$key] = 'false';
				}
				// Replace placeholder values in template with config data
				if( ! is_array($value) ) {
					// regular value
					$config_template = replaceConfigPlaceholder($key, $config[$key], $config_template);
				} else {
					// array (level 2) ex. 'Google'
					foreach ($value as $key2 => $value2) {
						// array (level 3) ex. 'client_id'
						foreach( $value2 as $key3 => $value3) {
							$config_template = replaceConfigPlaceholder($key2.'_'.$key3, $config[$key][$key2][$key3], $config_template);
						}
					}
				}
			}

			// Replace domain portfolio list
			if( isset($field_data['domains']) ) {
				// Preserve nicename from config.php domains array to $field_data['domains']
				// if the domain name from $domains matches up with the domain in $field_data['domains']
				// 1. Create copy of $field_data['domains'] with just index and domain so it's easily matchable
				//    which results in:
				//    array (
				//      [0] => 'domain.com',
				//		[1] => 'domaintwo.com',
				//      ...
				//    )
				//$domain_data_flat = array();
				//foreach ($field_data['domains'] as $fd_key => $fd_value) {
				//	$domain_data_flat[$fd_key] = $fd_value['domain'];
				//}
				// Convert values to lowercase to prevent index mismatch
				$field_data['domains'] = array_change_key_case($field_data['domains'], CASE_LOWER);
				foreach ($domains as $domain => $arr) {
					if( isset($field_data['domains'][$domain]) ) {
						// Match found, add to $field_data['domains'] array
						// if nicename exists
						if( isset($arr['nicename']) ) {
							$field_data['domains'][$domain]['nicename'] = $arr['nicename'];
						}
					}
				}
				$domains = $field_data['domains'];
			} else {
				$domains = $domains;
			}
			// Build domains array string
			$domains_str = '';
			foreach ($domains as $domain => $arr) {
				if( trim($domain) != '' ) {
					/*
						Array format:

						'domainone.com' => array(
							'nicename' => 'DomainOne.com', //optional
							'price' => '$100',
                            'price_description' => 'test price description',
							'description' => 'test description',
						),
					*/
					// Add nice name if it's set up in the array
					$domains_str_extra = '';
					if( isset($arr['nicename']) ) {
						$domains_str_extra = "\n\t\t'nicename' => '{$arr['nicename']}',";
					}
					$domains_str .= "'$domain' => array({$domains_str_extra}\n\t\t'price' => '{$arr['price']}',\n\t\t'price_description' => '{$arr['price_description']}',\n\t\t'description' => '{$arr['description']}' \n\t), \n\t";
				}
			}

			// Replace placeholder values for domain portfolio and Domain Seller domains
			$config_template = str_replace('*DOMAINS_VALUE*', $domains_str, $config_template);
            
            

			// Remove 'do not edit' notice
			$config_template = str_replace("/* WARNING: DO NOT EDIT THIS FILE DIRECTLY. USE THE WEB-BASED EDITOR FEATURE OR EDIT CONFIG.PHP DIRECTLY */\n", '', $config_template);

			// Write config file
			if( file_put_contents('config.php', $config_template) ) {
				$success = true;
			} else {
				$error = '<li>Config template could not be written to. Aborting save.</li>';
			}
		} else {
			$error = '<li>Config template could not be read. Aborting save.</li>';
		}
	}
	
	// Output response in JSON format then exit
	$response = array('error' => $error, 'success' => $success);
	echo json_encode($response); 
	exit;
}

// -------------------------------------------------------------------
// 3. Set up the Editor interface
// -------------------------------------------------------------------

// Find backgrounds and textures
$images = glob("assets/images/*.{jpg,png}", GLOB_BRACE);
$backgrounds = array();
$textures = array();

foreach ($images as $image) {

	// Remove folder path from image
	$image = strtolower(str_replace('assets/images/', '', $image));

	// Is the image a background (starts with "bg-")?
	if( strpos($image, 'bg-') !== false ) {
		// Remove everything but the name
		$image = str_replace( array( 'bg-', '.jpg' ), '', $image);
		// Add to backgrounds array
		$backgrounds[] = $image;
	} 
	// Is the image a texture (starts with "texture")? 
	elseif( strpos($image, 'texture-') !== false ) {
		// Remove everything but the name
		$image = str_replace( array( 'texture-', '.png' ), '', $image);
		// Add to textures array		
		$textures[] = $image;
	}
}