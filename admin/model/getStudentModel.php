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

        public function createStudentAccount($password,$idsinhvien){
            //add the data to the account database
            $sql = "INSERT INTO `account`(`id`, `isAdmin`, `password`, `idsinhvien`) VALUES ('$idsinhvien',0,PASSWORD('$password'),'$idsinhvien')";

            $this->TrySQL($sql);
        }

        public function UpdateStudentInfo($idSV , $hodem , $ten ,$dateOfBirth){
            $sql = "UPDATE `sinhvien` SET `id`='$idSV',`hodem`='$hodem',`ten`='$ten',`ngaysinh`='$dateOfBirth' WHERE `id` = '$idSV';";
            $this->trySQL($sql);
        }

        public function UpdateAccount($password,$idsinhvien){
            $sql = "UPDATE `account` SET `id`= '$idsinhvien',`password`= PASSWORD('$password'),`idsinhvien`= '$idsinhvien' WHERE `account` = '$idsinhvien';";
            $this->trySQL($sql);
        }

        public function updateDisqualifiedStudent($id,$qualification){
            // this function is used to update the dukienthi attribute of the sinhvien table on the db
            $sql = "UPDATE `sinhvien` SET `dudieukienduthi`= '$qualification' WHERE `id` = '$id';";
            $this->TrySQL($sql);
        }

        public function updateCourse($id , $courseid , $maky){
            //this function is used to add courses to the database
            $sql = "INSERT INTO `sinhvien_hoc_hocphan`(`masinhvien`, `mahocphan`, `idhocky`) VALUES ('$id','$courseid','$maky')";
            $this->TrySQL($sql);
        }

        public function getStudentInfo(){ //getdatafunction
           $stmt = $this->db->query("SELECT `id`, `hodem`, `ten`, `ngaysinh`, `dudieukienduthi` FROM `sinhvien` ORDER BY `id` ASC;"); // prepare the query for controller
           return $stmt; // return stmt first then fetch later on controller
        }

        public function getIDOnly($idSV){
            $stmt = $this->db->query("SELECT `id` FROM `sinhvien` WHERE `id` = '$idSV';"); // prepare the query for controller
            return $stmt; // return stmt first then fetch later on controller
        }

        public function getStudentCourseHKInfo(){ // get course and semester to display
            $stmt = $this->db->query("SELECT `masinhvien`, `mahocphan`, `idhocky` FROM `sinhvien_hoc_hocphan` Order By `masinhvien` ASC;"); // prepare the query for controller
            return $stmt; // return stmt first then fetch later on controller
        }

        public function DeleteStudentWID($idSV){ //delete function
            $sql = "DELETE FROM `sinhvien` WHERE `id` = '$idSV'";
            $this->TrySQL($sql);
        }

        public function deleteCourseHK($sinhvien,$hocphan,$hocky){
            $sql = "DELETE FROM `sinhvien_hoc_hocphan` WHERE `masinhvien`='$sinhvien' AND `mahocphan`='$hocphan' AND `idhocky`='$hocky';";
            $this->TrySQL($sql);
        }

        public function getCourseSubject($idhocphan){
            //this get id subject id
            $stmt = $this->db->query("SELECT tenmonthi, tinchi
FROM monthi
INNER JOIN hocphan ON monthi.mamonthi=hocphan.mamonthi WHERE hocphan.mahocphan = '$idhocphan';;");
            //no get the subject name
            return $stmt; // return stmt first then fetch later on controller
        }

        public function getSubjectID($idhocphan){
            $stmt = $this->db->query("SELECT  `mamonthi` FROM `hocphan` WHERE `mahocphan` = '$idhocphan';"); // prepare the query for controller
            return $stmt; // return stmt first then fetch later on controller
        }

        public function getTerm($maky){
            $stmt = $this->db->query("SELECT `id` FROM `kythi` WHERE `id` = '$maky';"); // prepare the query for controller
            return $stmt; // return stmt first then fetch later on controller
        }

        public function getTermInfo($maky){
            $stmt = $this->db->query("SELECT  `ky`, `ngaybatdau`, `ngayketthuc` FROM `kythi` WHERE `id` = '$maky'"); // prepare the query for controller
            return $stmt; // return stmt first then fetch later on controller
        }
}

