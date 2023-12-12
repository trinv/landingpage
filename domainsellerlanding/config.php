<?php

/**
 * Configuration options
 * Simply edit the contents (between quotation marks) of the items below to what you'd like.
 *
 * @author Prosparky <http://prosparky.com>
 */

$config = array(
	// -------------------------------------------------------------------
    // Header
    'header_text' => 'is now available for sale. Hurry and make an offer ',
    'header_subtext' => 'Or Please Call +44 000 000 000',
	// -------------------------------------------------------------------
	// Show the domain portfolio?
	'enable_domain_portfolio' => true,
	// -------------------------------------------------------------------
	// Footer contact info
	// -------------------------------------------------------------------
    'enable_social' => true,
    // Footer Text
	'footer_text' => 'Let&#39;s get connected',
	// Twitter handle - Just your username
	'twitter_handle' => 'youridhere',
    // Facebook handle - just your page ID
	'facebook_handle' => 'youridhere',
    // Instagram handle - just your username
	'instagram_handle' => 'youridhere',
    // Googleplus handle - just your page number
	'googleplus_handle' => 'youridhere',
    // Linkedin handle - just your username
	'linkedin_handle' => 'youridhere',
    // Youtube handle - just your username
	'youtube_handle' => 'youridhere',
    // Pinterest handle - just your username
	'pinterest_handle' => 'youridhere',
	// -------------------------------------------------------------------
	// Email/SMTP settings
	// -------------------------------------------------------------------
	'recipient_name' => '',
	'recipient_email' => '',
	'recipient_email_password' => '',
	'smtp_server' => '',
	// -------------------------------------------------------------------
	// reCAPTCHA spam protection
	// -------------------------------------------------------------------
	'enable_recaptcha' => false,
	// Obtain keys from https://www.google.com/recaptcha
	'recaptcha_public_key' => '',
	'recaptcha_private_key' => '',
	// -------------------------------------------------------------------
	// Background options
	// -------------------------------------------------------------------
	// Image options include mountains, city-lights, and tabletop
	'image' => 'minimal',
	// Tint colour to apply on top of the image -- use hexadecimal format
    // Body text color -- use hexadecimal format
    'theme_color' => '#5ce09e',
    // Theme color -- use hexadecimal format
    'text_color' => '#fbf8f3',
	// #FFFFFF would add a white tint. Try out http://www.colorpicker.com/
	'tint' => '#15071e',
	// Texture options include circles, diamonds, feathers, and rough
	'texture' => 'metal',
    // -------------------------------------------------------------------
	// Google Adsense
	// -------------------------------------------------------------------
    'enable_adsense' => false,
    // Client handle
	'client_handle' => '',
    // Slot handle
	'slot_handle' => '',
	// -------------------------------------------------------------------
	// Editor settings
	// -------------------------------------------------------------------
	'editor_login_email' => '',
	'editor_auth_methods' => array(
		'Google' => array(
			'client_id' => '',
			'client_secret' => ''
		),

		'Live' => array(
			'client_id' => '',
			'client_secret' => '',
			'scope' => 'wl.emails'
		),
		
		'LinkedIn' => array(
			'api_key' => '',
			'secret_key' => '',
			'scope' => 'r_emailaddress'
		),				
	),
);

// -------------------------------------------------------------------
// Domains
// -------------------------------------------------------------------
// A list of the domains you want to use with domain broker.
// This list is also used for the domain portfolio feature if
// the 'enable_domain_portfolio' setting is set to true
//
// Format (repeat for each domain): 
//
// 'domain name here' => array(
//	   'nicename' => 'ReplacesDomainNameText' // optional
// 	   'price' => 'price here',
// 	   'price_description' => 'price description here',
// 	   'description' => 'description here',
// ),
//
// Notes:
// * If you don't want a price or description, erase the contents
//   inside the quote marks
// * If the price is blank, the tag will not show
// * Enter domain names *without* the "http://" in front
$domains = array(
	'yourdomain.com' => array(
		'price' => '£500',
		'price_description' => 'Current Minimum Bid',
		'description' => 'Premium Domain' 
	), 
	'yourdomain2.com' => array(
		'price' => '£500',
		'price_description' => 'Current Minimum Bid',
		'description' => 'Premium Domain' 
	), 
	'yourdomain3.com' => array(
		'price' => '£500',
		'price_description' => 'Current Minimum Bid',
		'description' => 'Premium Domain' 
	), 	
);