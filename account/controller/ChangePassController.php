<?php
session_start();

require_once dirname(__FILE__)."/../model/AccountModel.php";
class ChangePassController{
        public function changePass(){
            if(isset($_POST["changePass"])){ // as you can only change pass after Login , old password will be unnecessary
                $newPass = $_POST["newpass"]; // get both PassWord and rePassWord
                $RenewPass = $_POST["renewpass"]; //
                $id = $_SESSION["id"]; // id from session
                if($newPass == $RenewPass){
                    echo $_SESSION["id"];
                    echo $newPass;
                    $model = new AccountModel();
                    $model->changePass($newPass,$id);
                    echo "<script>
                               window.alert(\"Password Changes successfully.\");
                          </script>";
                }else{
                    echo "<script>
                               window.alert(\"The the password and retype don't match. Please try again.\");
                          </script>";
                }
            }
        }
    }