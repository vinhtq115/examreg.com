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

        public function addStudentData($id , $hodem , $ten ,$dateOfBirth , $dieuKienThi){
            //add the data to the database
            $sql = "INSERT INTO sinhvien (id, hodem, ten, ngaysinh, dieukienduthi) 
                    VALUES ('$id', '$hodem', '$ten' , '$dateOfBirth' , '$dieuKienThi')";
            $this->trySQL($sql);

        }

}

