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

// get all quotes
$stmt = $quote->read();
$num = $stmt->rowCount(); // get the number of rows returned

// check if there are any quotes
if ($num > 0) {
    // quotes array
    $quotes_arr = array();
    $quotes_arr['quotes'] = array();

    // fetch quotes
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);  // extract the row

        // create a quote item
        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'author' => $author_name, // from  join with authors
            'category' => $category_name  // from join with categories
        );

        // push the quote item to the quotes array
        array_push($quotes_arr['quotes'], $quote_item);
    }

    // return the quotes in JSON format
    echo json_encode($quotes_arr);
} else {
    // if no quotes found
    echo json_encode(
        array('message' => 'No quotes found.')
    );
}
?>