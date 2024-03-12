<?php

class Database {
    private $db;

    public function __construct($dbName) {
        $this->db = new SQLite3($dbName);

        // Check the connection
        if (!$this->db) {
            die("Connection failed: " . $this->db->lastErrorMsg());
        }
    }

    public function getDB() {
        return $this->db;
    }

    public function closeDB() {
        if ($this->db) {
            $this->db->close();
        }
    }
}

?>
