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

$db = new Database();
$db = $db->connect();

$user = new User();
$getAll = $user->getAll($db);

// $query = $db->query('SELECT * FROM users');
$rows = $getAll->num_rows;

if($rows > 0) {
    $users = [];

    while($row = $getAll->fetch_assoc()) {
        array_push($users, [
            'id' => $row['id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'email' => $row['email'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
        ]);
    }

    echo json_encode([
        'status' => 200,
        'message' => 'Success',
        'users' => $users
    ]);

} else {
    echo json_encode([
        'status' => 200,
        'message' => 'Users not found'
    ]);
}

$db->close();