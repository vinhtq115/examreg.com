<?php
    // class DB{
    //     private $servername = "localhost";
    //     private $username = "root";
    //     private $password = "";
    //     private $database = "examreg";

    //     public function connect(){
    //         $conn = new mysqli($servername,$username,$password,$database);
    //         if($conn->connect_error){
    //             die("connection failed" . $conn->connect_error);
    //         }
    //         return $conn;
    //     }

    // }
    

    class PDO_DB {
    private $db = null; // Đối tượng PDO
    private $servername = "localhost"; // SQL hostname
    private $database = "examreg"; // Database name
    private $username = "root"; // Username for connecting database
    private $password = ""; // Password for connecting database

    /**
     * Constructor
     */
    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=".$this->username.";dbname=".$this->database.";", $this->username, $this->password);
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
            $this->database = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    }

    new PDOData();

?>