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

// check if 'id' and 'category' are provided
if (isset($data->id) && isset($data->category)) {
    // set the category id and new category name
    $category->id = $data->id;
    $category->category = $data->category;

    // update the category
    if ($category->update()) {
        // success response
        echo json_encode(
            array('message' => 'Category was successfully updated.')
        );
    } else {
        // failure response
        echo json_encode(
            array('message' => 'Category could not be updated. Please check the ID or try again.')
        );
    }
} else {
    // invalid data response
    echo json_encode(
        array('message' => 'Incomplete data. Please provide both category ID and category name.')
    );
}
?>