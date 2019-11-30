<?php
    session_start();
require_once dirname(__FILE__)."../model/AccountModel.php";
class ChangePassController{
        public function change(){
            if(isset($_POST["newPass"])){
                $newPass = mysqli_real_escape_string($_POST["newPass"]);
                $RenewPass = mysqli_real_escape_string($_POST["RenewPass"]);
                $id = mysqli_real_escape_string($_SESSION["id"]);
                if($newPass == $RenewPass){
                    $model = new AccountModel();
                    $model->changePass($newPass,$id);

                    // now must get the password back
                    $new = json_encode($model->retPass($id)); // get the new pass

                    $new = str_replace('[','',$new); // the json return have []
                    $new = str_replace(']','',$new);
                    $obj = json_decode($new,true);
                    $ID = $obj["id"];
                    echo $ID;
                }else{
                    // this will need ajax and stuff so left it here for now
                    //basically it will ask you resubmit your password
                }
            }else{

            }
        }
    }