<?php
require_once('/Applications/XAMPP/xamppfiles/htdocs/examreg.com/account/view/LoginView.php');
require_once('/Applications/XAMPP/xamppfiles/htdocs/examreg.com/account/model/AccountModel.php');

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
                if($isAdmin == 0){
                    echo '<script language="javascript">';
                    echo 'window.location.href="http://localhost/examreg.com/student/view/StudentView.php";';
                    echo '</script>';
                }else if ($isAdmin ==1){
                    echo '<script language="javascript">';
                    echo 'window.location.href="http://localhost/examreg.com/admin/view/AdminView.php";';
                    echo '</script>';
                }

            }else{
                echo "No such employee exist";
                require_once('account/view/LoginView.php');
            }

        }else{
            echo "No such employee exist";
            require_once('account/view/LoginView.php');
        }
    }}
}

