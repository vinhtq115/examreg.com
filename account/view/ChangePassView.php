<?php
require_once dirname(__FILE__).'/../controller/AccountModel.php';
    //You must login before changing password

class ChangePassView{
    public function activate(){
    if ($_SESSION["isAdmin"] == 1 || $_SESSION["isAdmin"] == 0)
    {
        $change = new ChangePassController();
        $change->change();
    }

    else{
        header("Location:http://examreg.com/account/view/LogoutView.php");
        //Use logout to kill all session just to make sure
    }}

    public function returnRes(){

    }
}

