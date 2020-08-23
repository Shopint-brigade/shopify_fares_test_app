<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Get our helper functions
require_once("inc/functions.php");

// Set variables for our request
$api_key = "25b5105a0ad38ac5b8d6dd05b95df037";
$shared_secret = "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";
$params = $_GET; // Retrieve all request parameters
$hmac = $_GET['hmac']; // Retrieve HMAC request parameter

$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
ksort($params); // Sort params lexographically

$computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);

// Use hmac data to check that the response is from Shopify or not
if (hash_equals($hmac, $computed_hmac)) {

	// Set variables for our request
	$query = array(
		"client_id" => $api_key, // Your API key
		"client_secret" => $shared_secret, // Your app credentials (secret key)
		"code" => $params['code'] // Grab the access key from the URL
	);

	// Generate access token URL
	$access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";

	// Configure curl client and execute request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $access_token_url);
	curl_setopt($ch, CURLOPT_POST, count($query));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
	$result = curl_exec($ch);
	curl_close($ch);

	// Store the access token
	$result = json_decode($result, true);
	$access_token = $result['access_token'];
 	$link_address = 'https://'. $params['shop'] .'/admin/apps/ooak-connect';

	echo " You have successfully installed the app ";
	echo "<a href='".$link_address."'> Main Page </a>";
	$store =  $params['shop']; 

	// add token 
	$arr = file_get_contents("s_json"); 
	$arr = json_decode($arr, TRUE);
	$arr[] = [$store => $access_token];
	$json = json_encode($arr);
	file_put_contents("s_json", $json);


} else {
	// Someone is trying to be shady!
	die('This request is NOT from Shopify!');
}
