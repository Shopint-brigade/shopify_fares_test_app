<?php
require_once("inc/functions.php");
$shop = $_GET['shop'];

	$stores = file_get_contents("s_json"); 
	$stores = json_decode($stores, TRUE);
	$i = 0;
	foreach ($stores as $store) {
		if ( array_key_exists($shop, $store)){
			$i++;
			echo 'Welcome  ' . $_GET['shop'] .'<br/>'; 
			echo 'Here is a list of your products : ';
			
			$requests = $_GET;
			$hmac = $_GET['hmac'];
			$serializeArray = serialize($requests);
			$requests = array_diff_key($requests, array('hmac' => ''));
			ksort($requests);

			$productList = shopify_call($store[$shop], $shop, "/admin/api/2020-07/products.json", array(), 'GET');
			$products = json_decode($productList['response'], ture);
			foreach ($products['products'] as $product) {
				echo '<br/> Product name : ' . $product['title'];

			}

		}
	}
	if ($i == 0){
		// Set variables for our request
			$api_key = "25b5105a0ad38ac5b8d6dd05b95df037";
			$scopes = "read_orders,write_products";
			$redirect_uri = "https://ooak-connect.ru/generate_token.php";

			// Build install/approval URL to redirect to
			$install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

			// Redirect
			header("Location: " . $install_url);
			die();
	}


