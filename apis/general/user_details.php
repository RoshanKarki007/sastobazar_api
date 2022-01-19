<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); // Handle pre-flight request

include_once '../../models/users.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($user->validate_params($_POST['id'])) {
    $user->id=$_POST['id'];}
    else{
        echo json_encode(array('success' => 1, 'message' => 'User id required')); 
        die();
    }
    $s = $user->getUserDetails();
    if(gettype($s) === 'array'){
        http_response_code(200);
        echo json_encode(array('success' => 1, 'message' => 'User Details Loaded!', 'user' => $s));
    }else{
        http_response_code(402);
        echo json_encode(array('success' => 0, 'message' => 'User id not found'));
    }
  } else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}