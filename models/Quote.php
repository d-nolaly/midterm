<?php
class Quote {
    private $conn;
    private $table = 'quotes';

    // properties
    public $id;
    public $quote;
    public $author_id;
    public $category_id;

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // create quote (POST)
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (quote, author_id, category_id) 
                  VALUES (:quote, :author_id, :category_id)';
        $stmt = $this->conn->prepare($query);

        // bind param
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id, PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // read all quotes (GET)
    public function read() {
        $query = 'SELECT q.id, q.quote, a.author AS author_name, c.category AS category_name 
                  FROM ' . $this->table . ' q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id
                  ORDER BY q.id DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // read single quote (GET by ID)
    public function read_single() {
        $query = 'SELECT q.id, q.quote, a.author AS author_name, c.category AS category_name 
                  FROM ' . $this->table . ' q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id
                  WHERE q.id = :id LIMIT 1';
        $stmt = $this->conn->prepare($query);

        // bind param
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->quote = $row['quote'];
            $this->author_id = $row['author_name'];  // return author's name
            $this->category_id = $row['category_name'];  // return category name
            return true;
        }
        return false;
    }

    // update quote (PUT)
    public function update() {
        $query = 'UPDATE ' . $this->table . ' 
                  SET quote = :quote, author_id = :author_id, category_id = :category_id 
                  WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        // bind param
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id, PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // delete quote (DELETE)
    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        // bind param
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
?>