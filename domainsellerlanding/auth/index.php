<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

/**
 * Opauth example
 * 
 * This is an example on how to instantiate Opauth
 * For this example, Opauth config is loaded from a separate file: opauth.conf.php
 * 
 */

/**
 * Define paths
 */
define('CONF_FILE', dirname(__FILE__).'/'.'opauth.conf.php');
define('OPAUTH_LIB_DIR', dirname(__FILE__).'/');

/**
* Load config
*/
require OPAUTH_LIB_DIR.'../config.php'; // Include main config
if (!file_exists(CONF_FILE)){
	trigger_error('Config file missing at '.CONF_FILE, E_USER_ERROR);
	exit();
}
require CONF_FILE;

/**
 * Instantiate Opauth with the loaded config
 */
require OPAUTH_LIB_DIR.'Opauth.php';
$Opauth = new Opauth( $opauth_config );
?>
<html>
<head>
	<title>Domain Seller Editor</title>
	<!-- Load fonts -->
    
    <link rel="stylesheet" href="../assets/css/font-awesome.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    
	<style>
		body {
			font: 24px/1.7;
			font-weight: 300;
			text-align: center;
			color: #333;
			padding: 3em;
			/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#e8e8e8+0,f4f4f4+100 */
			background: #f5f5f5;
			}
		a {
			color: #4E4E4E;
		}
		h1 {
			font-size: 48px;
			font-weight: 800;
		    color: #4E4E4E;
		    line-height: 1.8;
		}
		h1 span {
			color: #c7254e;
		}
		ul {
			list-style: none;
			margin: 1.5em 0;
			padding: 0;
		}
		li {
			display: inline-block;
		}
		li a {
			text-decoration: none;
			display: block;
			font-size: 24px;
			background: white;
			border-radius: 5px;
			border: solid 1px #ccc;
			padding: 18px 26px;
			margin: 0 5px;
			box-shadow: 0 .1em .1em rgba(0,0,0, .1);
		}
        a:hover, a:focus {
            background: #e5e5e5 none repeat scroll 0 0;
            text-decoration: none;
        }
		i {
			margin-right: 10px;
		}
		.fa-google {
			color: #F44336;
		}
		.fa-windows {
			color: #0c60cd;
		}
		.fa-linkedin {
			color: #1065a7;
		}
		p {
			font-size: 16px;
		}
	</style>

</head>
<body>
	<h1>Domain Seller <span>Editor</span></h1>
	<p>Please log in with one of the options below.</p>
	<ul>
		<li><a href="./google"><i class="fa fa-google"></i> Google</a></li>
		<li><a href="./live"><i class="fa fa-windows"></i> Microsoft</a></li>
		<li><a href="./linkedin"><i class="fa fa-linkedin"></i> LinkedIn</a></li>
	</ul>
	<p><small><strong>Note:</strong> Make sure the account you log in with uses the same email you entered<br> for the <code>editor_login_email</code> setting in config.php.</small></p>
</body>
</html>