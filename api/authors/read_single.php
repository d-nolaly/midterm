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

// get the author id from the URL
if (isset($_GET['id'])) {
    // set the author's id
    $author->id = $_GET['id'];

    // get the author details
    if ($author->read_single()) {
        // success response with author data
        echo json_encode(
            array(
                'id' => $author->id,
                'author' => $author->author
            )
        );
    } else {
        // failure response if no author found
        echo json_encode(
            array('message' => 'Author not found.')
        );
    }
} else {
    // invalid data response
    echo json_encode(
        array('message' => 'No author ID provided.')
    );
}
?>