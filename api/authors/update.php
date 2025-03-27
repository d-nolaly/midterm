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

// check if 'id' and 'author' are provided
if (isset($data->id) && isset($data->author)) {
    // set the author properties
    $author->id = $data->id;
    $author->author = $data->author;

    // update the author
    if ($author->update()) {
        // success response
        echo json_encode(
            array('message' => 'Author was successfully updated.')
        );
    } else {
        // failure response
        echo json_encode(
            array('message' => 'Author could not be updated. Please check the ID or try again.')
        );
    }
} else {
    // invalid data response
    echo json_encode(
        array('message' => 'Incomplete data. Please provide both author ID and author name.')
    );
}
?>