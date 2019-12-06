<?php
session_start();
if($_SESSION["id"] != ""){
    if($_SESSION["isAdmin"] == 1){
        header('Location: http://examreg.com/admin/view/AdminView.php');
    }else if($_SESSION["isAdmin"] == 0){
        header('Location: http://examreg.com/student/view/StudentView.php');
    }
}

require_once dirname(__FILE__).'/../view/LoginView.php';
require_once dirname(__FILE__).'/../model/AccountModel.php';
//if(isset($_POST['do_login'])){
//    $id =$_POST["id"];
//    $pass = $_POST['pass'];
//    $usermodel = new AccountModel();
//    $result = json_encode($usermodel->login($id , $pass)); // use json to get the element
//    if(strlen($result) > 2){
//        $result = str_replace('[','',$result);
//        $result = str_replace(']','',$result);
//        $obj = json_decode($result,true);
//        $isAdmin = $obj["isAdmin"]; // reinitialize the global variance
//        $ID = $obj["id"];
//        $_SESSION["id"] = $ID; // making session
//        $_SESSION["isAdmin"] = $isAdmin;// making session
//        if($isAdmin == 1){
//            header("Location: http://examreg.com/admin/view/AdminView.php");
//        }else if ($isAdmin == 0){
//            header("Location: http://examreg.com/student/view/StudentView.php");
//        }
//    }
//    echo $isAdmin;
//}


//$id = mysqli_real_escape_string($_POST["id"]); // receive the info ajax sent w/ jquery
//$pass = mysqli_real_escape_string($_POST["password"]);

class LoginController
{

    public function __construct()
    {
        $userview = new LoginView();
        $userview -> getView();
        $this->getLoginInfo();
    }

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
                $isAdmin = $obj["isAdmin"]; // reinnitialize the global variance
                $ID = $obj["id"];
                $_SESSION["id"] = $ID; // making session
                $_SESSION["isAdmin"] = $isAdmin;// making session
                if($isAdmin == 1){
                    header("Location: http://examreg.com/admin/view/AdminView.php");
                }else if ($isAdmin == 0){
                    header("Location: http://examreg.com/student/view/StudentView.php");
                }

            }else{
                echo '<script language="javascript">';
                echo 'window.alert("Either User or Password is wrong");';
                echo '</script>';
            }
        }
    }
    }
}
