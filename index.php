<?php
session_start();
require_once dirname(__FILE__)."/account/controller/LoginController.php";

if($_SESSION["id"] != ""){
    if($_SESSION["isAdmin"] == 1){
        header('Location: http://examreg.com/admin/view/AdminView.php');
    }else if($_SESSION["isAdmin"] == 0){
        header('Location: http://examreg.com/student/view/StudentView.php');
    }
}
else {
    $usercontroller = new LoginController();
    $usercontroller->getLoginInfo();
}


