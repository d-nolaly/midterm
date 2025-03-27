<?php
// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// method handling
$method = $_SERVER['REQUEST_METHOD'];

if($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// check method and route to the appropriate PHP file
switch ($method) {
    case 'GET':
        // Read request
        if (isset($_GET['id'])) {
            // single quote read (GET by ID)
            include_once 'read_single.php';
        } else {
            // read all quotes
            include_once 'read.php';
        }
        break;

    case 'POST':
        // create request
        include_once 'create.php';
        break;

    case 'PUT':
        // update request
        include_once 'update.php';
        break;

    case 'DELETE':
        // delete request
        include_once 'delete.php';
        break;

    default:
        echo json_encode(array('message' => 'Invalid request method.'));
        break;
}
?>