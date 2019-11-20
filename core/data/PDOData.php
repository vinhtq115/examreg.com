<?php


namespace core\data\model;
use \PDO;
use PDOException;

class PDOData {
    private $db = null; // Đối tượng PDO
    private $host = "localhost"; // SQL hostname
    private $dbname = "web"; // Database name
    private $username = "test"; // Username for connecting database
    private $password = "123456"; // Password for connecting database

    /**
     * Constructor
     */
    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname.";", $this->username, $this->password);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Deconstructor
     */
    public function __destruct()
    {
        // Close connection
        try {
            $this->db = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

new PDOData();