<?php

class Database {
    private static $instance = null;
    private $connection;

    private static $host = 'localhost';
    private static $user = 'root';
    private static $password = '';
    private static $db = 'helpdesk_core_php';

    private function __construct() {
        $this->connection = new mysqli(self::$host, self::$user, self::$password, self::$db);
        
        if ($this->connection->connect_error) {
            die("Database connection failed: " . $this->connection->connect_error);
        }
    }

    public static function getInstance() {  // ✅ Use this method to get the instance
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function query($sql) {
        return $this->connection->query($sql);
    }

    public function prepare($sql) {
        return $this->connection->prepare($sql);
    }

    public function getError() {
        return $this->connection->error;
    }

    // ✅ Add this method to get the last inserted ID
    public function getInsertId() {
        return $this->connection->insert_id;
    }

    public function lastInsertId() {
        return $this->connection->insert_id;  // ✅ Correct property name
    }
    
}
