<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
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

if($rows > 0) {
    $user = [];

    while($row = $find->fetch_assoc()) {
        $user = new stdClass();
        $user->id = $row['id'];
        $user->first_name = $row['first_name'];
        $user->last_name = $row['last_name'];
        $user->email = $row['email'];
        $user->created_at = $row['created_at'];
        $user->updated_at = $row['updated_at'];
    }

    echo json_encode([
        'status' => 200,
        'message' => 'Success',
        'user' => $user
    ]);

} else {
    echo json_encode([
        'status' => 200,
        'message' => 'User not found'
    ]);
}

$db->close();