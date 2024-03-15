<?php

use Automattic\WooCommerce\Client;
require_once __DIR__ . '/vendor/autoload.php';

// WooCommerce API credentials
$consumer_key = 'ck_281b6536bec0e323820da30598068f50bc525952';
$consumer_secret = 'cs_0dd297498eaa5c3e4a8c10d100315b23f1cdf49c';

// WooCommerce REST API URL
$api_url = 'https://cloudio.gr/api/xml-out/products/dEIwajZvU3BIZDU1MUFLYkFrZXVQdz09';

// Create a new instance of the WooCommerce API client
$woocommerce = new Client(
    $api_url,
    $consumer_key,
    $consumer_secret,
    [
        'wp_api' => true,
        'version' => 'wc/v3',
    ]
);

// Fetch products from the API
$products_data = file_get_contents($api_url);
$products = json_decode($products_data, true);

// // Loop through each product and save it to WooCommerce
foreach ($products as $product_data) {
    // Product data
    $data = [
        'name' => $product_data['name'],
        'type' => 'simple',
        'regular_price' => $product_data['retailPrice'],
        'description' => $product_data['description'],
        'short_description' => $product_data['short_description'],
        'categories' => $product_data['categories'],
        'images' => $product_data['images']
    ];

//     // Create the product
    $product = $woocommerce->post('products', $data);

    // Output the response
    print_r($product);
// }
?>
