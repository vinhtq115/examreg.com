<?php
namespace account\controller;
require_once dirname(__FILE__).("/../model/AccountModel.php");

class LogoutController{
    public function endSession(){
        $endSess = new AccountModel();
        $endSess->logout();
    }
}