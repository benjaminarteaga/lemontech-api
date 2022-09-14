<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

include_once '../../config/Database.php';
include_once '../../models/User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    echo json_encode([
        'status' => 405,
        'message' => 'Method Not Allowed'
    ]);
    return false;
}

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->id)) {
    echo json_encode([
        'status' => 200,
        'message' => 'ID is required'
    ]);
    return false;
}
$id = $data->id;
unset($data->id);

$columns = '';
foreach($data as $index => $value) {
    ${$index} = ($index === 'password') ? password_hash($value, PASSWORD_DEFAULT) : $value;
    $columns .= "$index='${$index}',";
}
$date = date('Y-m-d H:i:s');
$columns .= "updated_at='$date'";

$db = new Database();
$db = $db->connect();

$user = new User();
$update = $user->update($db, $columns, $id);

if($update) {
    echo json_encode([
        'status' => 200,
        'message' => 'User updated successfully'
    ]);
} else {
    echo json_encode([
        'status' => 200,
        'message' => 'Can\'t update user',
        'error' => $db->error
    ]);
}

$db->close();