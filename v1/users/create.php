<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

include_once '../../config/Database.php';
include_once '../../models/User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 405,
        'message' => 'Method Not Allowed'
    ]);
    return false;
}

$data = json_decode(file_get_contents("php://input"));

$columns = '';
$values = '';
foreach($data as $index => $value) {
    ${$index} = ($index === 'password') ? password_hash($value, PASSWORD_DEFAULT) : $value;
    $columns .= "$index,";
    $values .= "'${$index}',";
}
$columns .= 'created_at';
$date = date('Y-m-d H:i:s');
$values .= "'$date'";

$db = new Database();
$db = $db->connect();

$user = new User();
$create = $user->create($db, $columns, $values);

if($create) {
    echo json_encode([
        'status' => 200,
        'message' => 'User created successfully'
    ]);
} else {
    echo json_encode([
        'status' => 200,
        'message' => 'Can\'t create user',
        'error' => $db->error
    ]);
}

$db->close();