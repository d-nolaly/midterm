<?php
// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// include necessary files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// instantiate DB and connect
$database = new Database();
$db = $database->connect();

// instantiate quote object
$quote = new Quote($db);

// get raw posted data 
$data = json_decode(file_get_contents("php://input"));

// check if 'id' is provided
if (isset($data->id)) {
    // set the quote id
    $quote->id = $data->id;

    // attempt to delete quote
    if ($quote->delete()) {
        echo json_encode(
            array('message' => 'Quote was successfully deleted.')
        );
    } else {
        echo json_encode(
            array('message' => 'Quote could not be deleted.')
        );
    }
} else {
    // if 'id' is not provided, return error message
    echo json_encode(
        array('message' => 'No quote ID provided.')
    );
}
?>