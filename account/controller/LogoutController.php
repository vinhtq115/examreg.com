<?php
//require_once ("../model/AccountModel.php");
require_once ("/Applications/XAMPP/xamppfiles/htdocs/examreg.com/account/model/AccountModel.php");
class LogoutController{
    public function endSession(){
        $endSess = new AccountModel();
        echo "<script>
                    alert(\"Please Login Stop ByPassing our files\");
              </script>";
        $endSess->logout();
    }
}