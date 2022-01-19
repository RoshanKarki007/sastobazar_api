<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); // Handle pre-flight request

include_once '../../models/products.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($product->validate_params($_POST['subCategoryId'])) {
        $product->subCategoryId = $_POST['subCategoryId'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Sub-category is required!'));
        die();
    }

    echo json_encode(array('success' => 1, 'products' => $product->get_product_per_sub_category()));
} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}