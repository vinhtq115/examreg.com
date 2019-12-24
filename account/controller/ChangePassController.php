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

        public function returnOption(){
            if($_SESSION["isAdmin"] == 1){
                echo "<a href=\"http://examreg.com/admin/view/AdminView.php\" ><img src = \"/css/img/smallhome.png\">HomePage</a>
    <a href=\"http://examreg.com/monthi/\"><img src = \"/css/img/smallbook.png\">Subjects</a>
    <a href=\"http://examreg.com/hocphan/\"><img src = \"/css/img/smallglass.png\">Courses</a>
    <a href=\"http://examreg.com/kythi/\"><img src = \"/css/img/term.png\">Term</a>
    <a href=\"http://examreg.com/quanlyphongthi/\"><img src = \"/css/img/lamp.png\">Room</a>
    <a href=\"http://examreg.com/admin/getStudentIndex/\"><img src = \"/css/img/smallStudent.png\">Student</a>";
            }else if($_SESSION["isAdmin"] == 0){
                echo "<a  href=\"/sinhvien/home\"><img src = \"/css/img/smallhome.png\">Trang chủ</a>
                      <a  href='/sinhvien/dangkythi'><img src = \"/css/img/register.png\">Đăng ký thi</a>
                      <a  href='/sinhvien/indangkythi'><img src = \"/css/img/printer.png\">In đăng ký thi</a>";
        }
    }
}