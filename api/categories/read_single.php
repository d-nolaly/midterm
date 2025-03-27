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

// check if 'id' is provided
if (isset($data->id)) {
    // set the category id
    $category->id = $data->id;

    // fetch the category
    if ($category->read_single()) {
        // success response
        echo json_encode(
            array(
                'id' => $category->id,
                'category' => $category->category
            )
        );
    } else {
        // failure response
        echo json_encode(
            array('message' => 'Category not found.')
        );
    }
} else {
    // invalid data response
    echo json_encode(
        array('message' => 'Invalid data.')
    );
}
?>