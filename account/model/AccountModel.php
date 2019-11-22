<?php
require_once("../../core/data/PDOData.php");

class AccountModel extends PDOData{
    public function __contruct() {
    }

    public function login($id , $password){ // the login function
        $conn = $this->__connect();
        $sql = "SELECT `id`, `password`, `author` FROM `account` WHERE `id` = '$id' AND `password` = '$password';";
        $result = mysqli_query($conn, $sql);
        $user = "anything";
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
        } else {
            require_once('account/view/LoginView.php');
        }return $user;
    }

    public function logout(){

    }
};
