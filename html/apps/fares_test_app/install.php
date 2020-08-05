<?php

// Set variables for our request
$shop = $_GET['shop'];
$api_key = "d752390d00b3cade78f052b51b111034";
$scopes = "read_orders,write_products";
$redirect_uri = "https://331b40912382.ngrok.io/apps/fares_test_app/generate_token.php";


// Build install/approval URL to redirect to
$install_url = "https://" . $shop . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();