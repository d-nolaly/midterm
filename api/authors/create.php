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

// check if author property set
if (isset($data->author)) {
    // set author property
    $author->author = $data->author;

    // create author
    if ($author->create()) {
        // success response
        echo json_encode(
            array('message' => 'Author was successfully created.')
        );
    } else {
        // fail response
        echo json_encode(
            array('message' => 'Author was not Created.')
        );
    }
} else {
    // invalid data response
    echo json_encode(
        array('message' => 'Invalid data.')
    );
}
?>