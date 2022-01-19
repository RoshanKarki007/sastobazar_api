<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); // Handle pre-flight request

include_once '../../models/categories.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 	if ($category->validate_params($_POST['category'])) {
        $category->category = $_POST['category'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Category is required!'));
        die();
    }
    if ($category->validate_params($_POST['name'])) {
        $category->name = $_POST['name'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Name is required!'));
        die();
    }

    if ($category->check_unique_category()) {
         if ($category->add_category() !=false) {            
         	echo json_encode(array('success' => 1, 'message' => 'Category added!'));

        } else {
            http_response_code(500);
            echo json_encode(array('success' => 0, 'message' => 'Internal Server Error'));
        }
    } else {
        http_response_code(401);
        echo json_encode(array('success' => 0, 'message' => 'Category already exits!'));
    }

}
else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}