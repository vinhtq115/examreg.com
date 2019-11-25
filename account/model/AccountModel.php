<?php
//require_once("/core/data/PDOData.php");
require_once("core/data/PDOData.php");
class AccountModel extends PDOData{
    public function __construct() {
        parent::__construct();
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
