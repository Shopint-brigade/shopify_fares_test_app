<?php
require_once("inc/functions.php");
$token = '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' ;
$shop = $_GET['shop'];

if (  $_GET['shop'] == 'test-store11001.myshopify.com' ) // If store exists in the databaes use this
{
	// Set variables for our request
	echo 'Welcome folks from ' . $_GET['shop'] .'<br/>'; 
	echo 'Here is a list of your products : ';
	
	$requests = $_GET;
	$hmac = $_GET['hmac'];
	$serializeArray = serialize($requests);
	$requests = array_diff_key($requests, array('hmac' => ''));
	ksort($requests);

	$productList = shopify_call($token, $shop, "/admin/api/2020-07/products.json", array(), 'GET');
	var_dump($productList);
	$products = json_decode($productList['response'], ture);
	foreach ($products['products'] as $product) {
		echo '<br/> Product name ' . $product['title'];
	}


}else { // if its a new store do this 

// Set variables for our request

$api_key = "91366cacc917c5626d1b3be3fe6c5424";
$scopes = "read_orders,write_products";
$redirect_uri = "https://www.ooak-connect.ru/generate_token.php";


// Build install/approval URL to redirect to
$install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();
	
}
