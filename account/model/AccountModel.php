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
        $sql = "SELECT * FROM `account` WHERE `id` = ? AND `password` = PASSWORD(?);";
        return $this->doPreparedQuery($sql, [$id, $password]);
//        $sql = $this->doQuery("SELECT * FROM `account` WHERE `id` = '$id' AND `password` = PASSWORD('$id');");
//        return $sql;
    }

    public function logout(){
        session_start();
        unset($_SESSION["id"]);
        unset($_SESSION["isAdmin"]);
        header("Location:http://examreg.com/");
    }

    public function changePass($password,$id){ // this function is used to change the password
        $sql = "UPDATE `account` SET `password`= PASSWORD(?) WHERE `id`= ?";
        $this->doPreparedQuery($sql, [$password, $id]);
    }
};
