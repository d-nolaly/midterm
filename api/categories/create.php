<?php
// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// instantiate DB and connect
$database = new Database();
$db = $database->connect();

// instantiate category object
$category = new Category($db);

// get raw posted data
$data = json_decode(file_get_contents("php://input"));

// check if 'category' provided
if (isset($data->category)) {
    // set the category property
    $category->category = $data->category;

    // create category
    if ($category->create()) {
        // success response
        echo json_encode(
            array('message' => 'Category was successfully created.')
        );
    } else {
        // failure response
        echo json_encode(
            array('message' => 'Category was not created.')
        );
    }
} else {
    // invalid data response
    echo json_encode(
        array('message' => 'Incomplete data.')
    );
}
?>