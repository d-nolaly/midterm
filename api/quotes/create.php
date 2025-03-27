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

// check if necessary data is provided
if (isset($data->quote) && isset($data->author_id) && isset($data->category_id)) {
    // set the quote properties
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // create the quote
    if ($quote->create()) {
        echo json_encode(
            array('message' => 'Quote was successfully created.')
        );
    } else {
        echo json_encode(
            array('message' => 'Quote could not be created.')
        );
    }
} else {
    // if data is incomplete, return an error message
    echo json_encode(
        array('message' => 'Invalid data.')
    );
}
?>