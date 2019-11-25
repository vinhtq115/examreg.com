<?php
namespace account\controller;
require_once ("../model/AccountModel.php");

class LogoutController{
    public function endSession(){
        $endSess = new AccountModel();
        $endSess->logout();
    }
}