<!-- this will become a part of AccountModel  -->
<?php
    require_once('../connection.php');
    class loginModel extends DB{
        public function login($id , $password){
            $conn = $this -> connect();
            $sql = "SELECT `ID`, `pass` FROM `user` WHERE `ID` = '$id' AND `pass` = '$password'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0){

            }else{
                
            }
        }
    }
?>