<?php
// headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// instantiate DB and connect
$database = new Database();
$db = $database->connect();

// instantiate category object
$category = new Category($db);

// fetch all categories
$stmt = $category->read();
$num = $stmt->rowCount();

// check if any categories exist
if ($num > 0) {
    $categories_arr = array();
    $categories_arr['data'] = array();

    // fetch the data
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            'id' => $id,
            'category' => $category
        );

        // push to 'data'
        array_push($categories_arr['data'], $category_item);
    }

    // success response with all categories
    echo json_encode($categories_arr);
} else {
    // no categories found
    echo json_encode(
        array('message' => 'No categories found.')
    );
}
?>