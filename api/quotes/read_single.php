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
    // set quote id
    $quote->id = $data->id;

    // attempt to read the single quote
    if ($quote->read_single()) {
        // if quote found, return quote data
        echo json_encode(
            array(
                'id' => $quote->id,
                'quote' => $quote->quote,
                'author' => $quote->author_id, 
                'category' => $quote->category_id  
            )
        );
    } else {
        // if no quote is found with given id
        echo json_encode(
            array('message' => 'Quote not found.')
        );
    }
} else {
    // if 'id' not provided
    echo json_encode(
        array('message' => 'No quote ID provided.')
    );
}
?>