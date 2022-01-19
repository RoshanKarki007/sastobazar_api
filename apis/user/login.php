<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); 

include_once '../../models/users.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($user->validate_params($_POST['email'])) {
        $user->email = $_POST['email'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Email is required!'));
        die();
    }

    if ($user->validate_params($_POST['password'])) {
        $user->password = $_POST['password'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Password is required!'));
        die();
    }

    $s = $user->login();
    if (gettype($s) === 'array') {
        http_response_code(200);
        echo json_encode(array('success' => 1, 'message' => 'Login Successful!', 'user' => $s));
    } else {
        http_response_code(402);
        echo json_encode(array('success' => 0, 'message' => $s));
    }
} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}