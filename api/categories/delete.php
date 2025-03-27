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

// check if 'id' provided
if (isset($data->id)) {
    // set category id
    $category->id = $data->id;

    // delete category
    if ($category->delete()) {
        // success response
        echo json_encode(
            array('message' => 'Category was successfully deleted.')
        );
    } else {
        // failure response
        echo json_encode(
            array('message' => 'Category was not deleted')
        );
    }
} else {
    // invalid data response
    echo json_encode(
        array('message' => 'Invalid data.')
    );
}
?>