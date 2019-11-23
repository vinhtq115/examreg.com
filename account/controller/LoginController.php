<?php
require_once('account/model/AccountModel.php');

class LoginController
{
    public function getLoginInfo(){
        $id = isset($_POST['id']);
        $password = isset($_POST['pass']);
        if ($password != '' && $id != '') {
            $usermodel = new AccountModel();
            echo "$id"."<br>";
            echo "$password";
            $user = $usermodel->login($id , $password);

            if ($user) {
                echo "chuc mung ban da dang nhap thanh cong ";
            } else {
                require_once('account/view/LoginView.php');
                echo "sai ten dang nhap hoac mat khau ";
            }

        }else{
            echo "$id";
            echo "$password";
            require_once('account/view/LoginView.php');
        }
    }
}