<?php
class Category {
    private $conn;
    private $table = 'categories';

    // properties
    public $id;
    public $category;

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // create category (POST)
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (category) VALUES (:category)';
        $stmt = $this->conn->prepare($query);

        // sanitize 
        $this->category = htmlspecialchars($this->category);

        // bind param
        $stmt->bindParam(':category', $this->category);

        return $stmt->execute();
    }

    // read all categories (GET)
    public function read() {
        $query = 'SELECT id, category FROM ' . $this->table . ' ORDER BY id ASC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // read single category (GET by ID)
    public function read_single() {
        $query = 'SELECT id, category FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
        $stmt = $this->conn->prepare($query);

        // bind param
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->category = $row['category'];
            return true;
        }
        return false;
    }

    // update category (PUT)
    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET category = :category WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        // sanitize 
        $this->category = htmlspecialchars($this->category);
        $this->id = htmlspecialchars($this->id);

        // bind param
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // delete category (DELETE)
    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        // sanitize 
        $this->id = htmlspecialchars($this->id);

        // bind param
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
?>