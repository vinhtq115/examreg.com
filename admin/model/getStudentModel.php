<?php
require_once dirname(__FILE__)."/../../core/data/PDOData.php";

class getStudentModel extends PDOData{
        public function __construct() {
            parent::__construct();
        }

        public function __destruct()
        {
            parent::__destruct();
        }

        public function addStudentData($id , $hodem , $ten ,$dateOfBirth){
            //add the data to the student database
            $sql = "INSERT INTO sinhvien (id, hodem, ten, ngaysinh) 
                    VALUES ('$id', '$hodem', '$ten' , '$dateOfBirth')";
            $this->trySQL($sql);

        }

        public function createStudentAccount($account , $password,$idsinhvien){
            //add the data to the account database
            $sql = "INSERT INTO `account`(`id`, `isAdmin`, `password`, `idsinhvien`) VALUES ('$account',0,'$password','$idsinhvien')";
            $this->TrySQL($sql);
        }

        public function updateDisqualifiedStudent($id){
            $sql = "UPDATE `sinhvien` SET `dudieukienduthi`= 0 WHERE `id` = '$id';";
            $this->TrySQL($sql);
        }

        public function updateCourse($id , $courseid , $maky){
            $sql = "INSERT INTO `hocphan`(`soluong`, `mahocphan`, `mamonthi`) VALUES ('$id','$courseid','$maky')";
            $this->TrySQL($sql);
        }

    public function getStudentInfo(){ //getdatafunction
       $stmt = $this->db->query("SELECT `id`, `hodem`, `ten`, `ngaysinh`, `dudieukienduthi` FROM `sinhvien`;");
       return $stmt; // return stmt first then fetch later on table
    }
}

