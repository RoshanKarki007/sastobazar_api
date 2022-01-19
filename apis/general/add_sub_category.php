<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); // Handle pre-flight request

include_once '../../models/subcategories.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 	if ($sub_category->validate_params($_POST['sub_category'])) {
        $sub_category->sub_category = $_POST['sub_category'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'sub_category is required!'));
        die();
    }
    if ($sub_category->validate_params($_POST['category_id'])) {
        $sub_category->category_id = $_POST['category_id'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Category is required!'));
        die();
    }

    if ($sub_category->check_unique_sub_category()) {
         if ($sub_category->add_sub_category() !=false) {            
         	echo json_encode(array('success' => 1, 'message' => 'sub_category added!'));

        } else {
            http_response_code(500);
            echo json_encode(array('success' => 0, 'message' => 'Internal Server Error'));
        }
    } else {
        http_response_code(401);
        echo json_encode(array('success' => 0, 'message' => 'sub_category already exits!'));
    }

}
else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}