<?php
require_once dirname(__FILE__)."/../../account/model/AccountModel.php";
class LogoutController{
    /**
     * Kết thúc session.
     */
    public function endSession(){
        $endSess = new AccountModel();
        $endSess->logout();
    }
}