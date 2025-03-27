<?php
// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// include files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// instantiate DB and connect
$database = new Database();
$db = $database->connect();

// instantiate quote object
$quote = new Quote($db);

// get raw posted data 
$data = json_decode(file_get_contents("php://input"));

// check if all required fields are provided
if (isset($data->id) && isset($data->quote) && isset($data->author_id) && isset($data->category_id)) {
    // set quote properties
    $quote->id = $data->id;
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // update quote
    if ($quote->update()) {
        // success response
        echo json_encode(
            array('message' => 'Quote was successfully updated.')
        );
    } else {
        // failure response
        echo json_encode(
            array('message' => 'Quote could not be updated.')
        );
    }
} else {
    // invalid data response
    echo json_encode(
        array('message' => 'Invalid data.')
    );
}
?>