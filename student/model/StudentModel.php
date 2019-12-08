<?php

require_once dirname(__FILE__)."/../../core/data/PDOData.php";

class StudentModel extends PDOData{
    public function __construct() {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    public function getStudentInfo($idSD){
        $stmt = $this->db->query("SELECT `account`.id, `account`.idsinhvien, `sinhvien`.hodem , `sinhvien`.ten 
                                            FROM `account` INNER JOIN `sinhvien` ON `account`.idsinhvien=`sinhvien`.id Where `account`.id = '$idSD';");
        return $stmt;
    }

    public function CourseOfStudent($idSinhvien){
        $stmt = $this->db->query("SELECT `mahocphan`, `idhocky` FROM `sinhvien_hoc_hocphan` WHERE `masinhvien` = '$idSinhvien';"); // prepare the query for controller
        return $stmt; // return stmt first then fetch later on controller
    }

    public function getSubjectSt($idhocphan){
        $stmt = $this->db->query("SELECT hocphan.mamonthi, monthi.tenmonthi 
        FROM hocphan INNER JOIN monthi ON hocphan.mamonthi=monthi.mamonthi Where hocphan.mahocphan = '$idhocphan';");
        return $stmt;
    }
}