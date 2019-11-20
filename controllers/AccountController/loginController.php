<?php 
    require_once("../model/loginModel.php");
    class loginController{
        public function getUser(){
			$username = isset($_POST['username'])? $_POST['username']: '' ;
			$password = isset($_POST['password'])? $_POST['password']: '' ;
			if ($password != '' && $username != '' ) {
				$usermodel = new loginModel();
				 $user = $usermodel->login($username , $password );

				 if ($user) {
				 	echo "chuc mung ban da dang nhap thanh cong ";
				 } else {
				 	require_once('views/Login.php');
				 	echo "sai ten dang nhap hoac mat khau ";
				 }
				 
			}else{
				echo "ayyy Login";
			}
		}
    }
?>