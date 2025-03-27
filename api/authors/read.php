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

// query all authors
$stmt = $author->read();
$num = $stmt->rowCount();

// check if any authors exist
if ($num > 0) {
    // authors array
    $authors_arr = array();
    
    // fetch all authors
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        
        $author_item = array(
            'id' => $id,
            'author' => $author
        );

        // add author to the array
        array_push($authors_arr, $author_item);
    }

    // success response with all authors
    echo json_encode($authors_arr);
} else {
    // no authors found
    echo json_encode(
        array('message' => 'No authors found.')
    );
}
?>