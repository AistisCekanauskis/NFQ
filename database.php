<?php

//namespace home\isp\public_html\moodle;

class Database {
    private $connection;
    private $host = 'localhost';
    private $dbName = 'books';
    private $user = 'root';
    private $password = '';
    private static $instance; //The single instance

    // Single connection at a time
    public static function getInstance() {
        if(!self::$instance) { // If no instance then make one
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Constructor
    private function __construct() {
        $this->connection = new PDO("mysql:host=".$this->host.";dbname=".$this->dbName, $this->user, $this->password);
            //mysqli_connect($this->host, $this->user, $this->password, $this->dbName);

        if (!$this->connection) {
            echo "Connection to database was not established";
            die();
        }
    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone() { }

    // Get connection
    public function getConnection() {
        return $this->connection;
    }
}