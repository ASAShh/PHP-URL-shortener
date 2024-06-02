<?php
class Database {
    private $host;
    private $dbname;
    private $user;
    private $pass;
    private $conn;

    function __construct(string $host, string $dbname, string $user, string $pass) {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->pass = $pass;
        $this->conn = null;
    }

    public function connect() {
        $conn_str = "mysql:host=". $this->host .";dbname=". $this->dbname;

        try {
            $this->conn = new PDO($conn_str, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            $this->conn = null;
        }

        return $this->conn;
    }

    public function isConnected() {
        return $this->conn !== null;
    }
}
?>
