<?php
require_once dirname(__FILE__)."/../../core/data/PDOData.php";


class AccountModel extends PDOData{
    public function __construct() {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    public function login($id , $password){ // the login function
        $sql = $this->doQuery("SELECT * FROM `account` WHERE `id` = '$id' AND `password` = PASSWORD('$password');");
        //the Password Function is used to encrypt the $password as the password in database is encrypted
        return $sql;
    }

    public function logout(){
        session_start();
        unset($_SESSION["id"]);
        unset($_SESSION["isAdmin"]);
        header("Location:http://localhost/examreg.com/");
    }
};
