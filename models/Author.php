<?php
    class Author {
        private $conn;
        private $table = 'authors';

        // properties
        public $id;
        public $author;

        // constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        // create author (POST)
        public function create() {
            $query = 'INSERT INTO' . $this->table . '(author) VALUES (:author)';
            $stmt = $this->conn->prepare($query);

            //sanitize
            $this->author = htmlspecialchars($this->id);

            // bind parameter
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            return $stmt->execute();
        }

        // read all author (GET)
        public function read() {
            $query = 'SELECT id, author FROM ' . $this->table . 'ORDER BY id ASC';
            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            return $stmt;
        }

        // read single author (GET by ID)
        Public function read_single() {
            $query = 'SELECT id, author FROM ' . $this->table . 'WHERE id = :id LIMIT 1';
            $stmt = $this->conn->prepare($query);

            // bind param
            $stmt->bindParam(':id, $this->id, PDO::PARAM_INT');

            $stmt->execute();
            $row = $stmt->fetch(PDO::FECTCH_ASSOC);

            if($row) {
                $this->author = $row['author'];
                return true;
            }
            
            return false;
        }

        // update author (PUT)
        public function update() {
            $query = 'UPDATE ' . $this->table . 'SET author = :author WHERE id = :id';
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->author = htmlspecialchars($this->author);
            $this->id = htmlspecialchars($this->id);

            // bind param
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            return $stmt->execute();
        }

        // delete author (DELETE)
        public function delete() {
            $query = 'DELETE FROM ' . $this->table . 'WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            
            // sanitize
            $this->id = htmlspecialchars($this->id);

            // bind param
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            return $stmt->execute();
        }

    }
?>