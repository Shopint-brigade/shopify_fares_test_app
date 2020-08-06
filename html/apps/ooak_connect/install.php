<?php

// Set variables for our request
$shop = $_GET['shop'];
$api_key = "25b5105a0ad38ac5b8d6dd05b95df037";
$scopes = "read_orders,write_products";
$redirect_uri = "https://9d51e1e3f737.ngrok.io/apps/ooak_connect/generate_token.php";


// Build install/approval URL to redirect to
$install_url = "https://" . $shop . ".myshopify.com/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();