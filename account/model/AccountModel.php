<?php

require_once ("core/data/PDOData.php");

class AccountModel extends PDOData {
    private $host = "localhost"; // SQL hostname
    private $dbname = "web"; // Database name
    private $username = "test"; // Username for connecting database
    private $password = "123456"; // Password for connecting database

    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname.";", $this->username, $this->password);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    public function login($id , $password){ // the login function
        $sql = $this->doQuery("SELECT * FROM `account` WHERE `id` = '$id' AND `password` = '$password';");
        return $sql;
    }

    public function logout(){

    }
};
