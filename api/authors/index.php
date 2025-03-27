<?php
// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// method handling
$method = $_SERVER['REQUEST_METHOD'];

// check method and route to the appropriate PHP file
switch ($method) {
    case 'GET':
        // read request
        if (isset($_GET['id'])) {
            // single author read (GET by ID)
            include_once 'read_single.php';
        } else {
            // read all authors
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