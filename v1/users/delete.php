<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

include_once '../../config/Database.php';
include_once '../../models/User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
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

$db = new Database();
$db = $db->connect();

$user = new User();
$find = $user->find($db, $id);
$rows = $find->num_rows;
if($rows === 0) {
    echo json_encode([
        'status' => 200,
        'message' => 'User not found'
    ]);
    return false;
}

$delete = $user->delete($db, $id);

if($delete) {
    echo json_encode([
        'status' => 200,
        'message' => 'User deleted'
    ]);
} else {
    echo json_encode([
        'status' => 200,
        'message' => 'Can\'t delete user',
        'error' => $db->error
    ]);
}

$db->close();