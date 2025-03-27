<?php
    class Database{
        private $host;
        private $db_name;
        private $username;
        private $password;
        private $conn;
        private $port;

        public function __construct(){
            $this->host = getenv('HOST');
            $this->db_name = getenv('DB_NAME');
            $this->username = getenv('USERNAME');
            $this->password = getenv('PASSWORD');
            $this->port = getenv('PORT');
        }

        public function connect(){
            if($this->conn){
                return $this->conn;
            }else{
               $dsn = "pgsql:host={$this->host};port={$this->port};db_name={$this->dbname};";
                try{
                    $this->conn = new PDO($dsn, $this->username, $this->password);
                    $this->conn->setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
                    return $this->conn;
                }catch(PDOException $e){
                    echo 'Connection Error: ' . $e->getMessage();
                }
            }
        }
    }