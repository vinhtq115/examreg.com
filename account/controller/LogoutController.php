<?php
//require_once ("../model/AccountModel.php");
require_once ("../account/model/AccountModel.php");
class LogoutController{
    public function endSession(){
        $endSess = new AccountModel();
        $endSess->logout();
    }
}