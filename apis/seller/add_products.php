<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); // Handle pre-flight request

include_once '../../models/products.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
	if ($product->validate_params($_POST['sellerId'])) {
        $product->sellerId = $_POST['sellerId'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Seller is required!'));
        die();
    }
    if ($product->validate_params($_POST['subCategoryId'])) {
        $product->subCategoryId = $_POST['subCategoryId'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Sub-Category is required!'));
        die();
    }

    if ($product->validate_params($_POST['name'])) {
        $product->name = $_POST['name'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Product name is required!'));
        die();
    }

    if ($product->validate_params($_POST['price'])) {
        $product->price = $_POST['price'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Product price is required!'));
        die();
    }

    if ($product->validate_params($_POST['quantity'])) {
        $product->quantity = $_POST['quantity'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Product quantity is required!'));
        die();
    }

    if ($product->validate_params($_POST['description'])) {
        $product->description = $_POST['description'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Product description is required!'));
        die();
    }

	    // saving picture of seller
    $product_images_folder = '../../assets/product_images/';

    if (!is_dir($product_images_folder)) {
        mkdir($product_images_folder);
    }

    if (isset($_FILES['image'])) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_info = explode(".", $file_name);
        $extension = end($file_info);

        $new_file_name = $product->sellerId ."_". $product->subCategoryId . "_" . $product->name . "_product" . "." . $extension;

        move_uploaded_file($file_tmp, $product_images_folder . "/" . $new_file_name);

        $product->image = 'product_images/' . $new_file_name;
    }else{

    	echo json_encode(array('success' => 0, 'message' => 'Product image is required!'));
        die();
    }

    if($product->check_unique_product()){
    	if($product->add_products()){
    		echo json_encode(array('success' => 1, 'message' => 'Product successfully added!'));
    	}else{
    		http_response_code(500);
        	echo json_encode(array('success' => 0, 'message' => 'Internal Server Error!'));
    	}
    }else {
        http_response_code(401);
        echo json_encode(array('success' => 0, 'message' => 'Product already exists!'));
    }

}
else
{
	die(header('HTTP/1.1 405 Request Method Not Allowed'));
}