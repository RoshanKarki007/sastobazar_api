<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); // Handle pre-flight request

include_once '../../models/subcategories.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($sub_category->validate_params($_POST['category_id'])) {
        $sub_category->category_id = $_POST['category_id'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Category id is required!'));
        die();
    }

    echo json_encode(array('success' => 1, 'sub_categories' => $sub_category->all_sub_categories()));
} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}