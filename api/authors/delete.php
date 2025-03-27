<?php
// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// instantiate DB and connect
$database = new Database();
$db = $database->connect();

// instantiate author object
$author = new Author($db);

// get raw posted data 
$data = json_decode(file_get_contents("php://input"));

// check if 'id' set
if (isset($data->id)) {
    // set author id property
    $author->id = $data->id;

    // delete author
    if ($author->delete()) {
        // success response
        echo json_encode(
            array('message' => 'Author was successfully deleted.')
        );
    } else {
        // fail response
        echo json_encode(
            array('message' => 'Author could not be deleted.')
        );
    }
} else {
    // invalid data response
    echo json_encode(
        array('message' => 'Invalid data.')
    );
}
?>