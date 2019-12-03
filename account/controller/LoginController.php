<?php
//session_start();
$isAdmin = 2; // a global variance set to default = 2
if($_SESSION["id"] != ""){
    if($_SESSION["isAdmin"] == 1){
        header('Location: http://examreg.com/admin/view/AdminView.php');
    }else if($_SESSION["isAdmin"] == 0){
        header('Location: http://examreg.com/student/view/StudentView.php');
    }
}

//require_once dirname(__FILE__).'/../view/LoginView.php';
require_once dirname(__FILE__).'/../model/AccountModel.php';


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
                    header("Location:../student/view/StudentView.php");
                }else if ($isAdmin == 1){
                    header("Location:../admin/view/AdminView.php");
                }
            }
            //if($isAdmin == 1){}
            //echo $isAdmin;

        }
    }
    }
}
$tmp = new LoginController();
$tmp-> getLoginInfo();
