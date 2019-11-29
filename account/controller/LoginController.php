<?php
session_start();
require_once dirname(__FILE__).'/../view/LoginView.php';
require_once dirname(__FILE__).'/../model/AccountModel.php';

//require_once('/../view/LoginView.php');
//require_once ('/../model/AccountModel/php');

class LoginController
{
    public function getLoginInfo(){
        if(isset($_POST['id']) && isset($_POST['pass']) && !empty($_POST['id']) && !empty($_POST['pass'])){
        $id = $_POST['id'];
        $password = $_POST['pass'];
        if ($password != '' && $id != '') {
            $usermodel = new AccountModel();
            $result = json_encode($usermodel->login($id , $password)); // use json to get the element

            if(strlen($result) > 2){ // if empty json return [] which is strlen = 2
                $result = str_replace('[','',$result);
                $result = str_replace(']','',$result);
                $obj = json_decode($result,true);
                $isAdmin = $obj["isAdmin"];
                $ID = $obj["id"];
                $_SESSION["id"] = $ID; // making session
                $_SESSION["isAdmin"] = $isAdmin;// making session

                if($isAdmin == 0){
                    echo '<script language="javascript">';
                    echo 'window.location.pathname="../student/view/StudentView.php";';
                    echo '</script>';
                }else if ($isAdmin == 1){
                    echo '<script language="javascript">';
                    echo 'window.location.pathname="../admin/view/AdminView.php";';
                    echo '</script>';

                }

            }else{
                echo "<script type='text/javascript'>alert('Either the password or the id is wrong');</script>";
                require_once('account/view/LoginView.php');
            }

        }else{
            imap_alerts("Please complete the form");
            require_once dirname(__FILE__).'/../../account/view/LoginView.php';
        }
    }}
}

