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

    public function getStudentInfo($idSD){//this get the student info
        $stmt = $this->db->query("SELECT `account`.id, `account`.idsinhvien, `sinhvien`.hodem , `sinhvien`.ten 
                                            FROM `account` INNER JOIN `sinhvien` ON `account`.idsinhvien=`sinhvien`.id Where `account`.id = '$idSD';");
        return $stmt;
    }

    public function CourseOfStudent($idSinhvien){//this get the course student enrol
        $stmt = $this->db->query("SELECT `mahocphan`, `idhocky` FROM `sinhvien_hoc_hocphan` WHERE `masinhvien` = '$idSinhvien';"); // prepare the query for controller
        return $stmt; // return stmt first then fetch later on controller
    }

    public function getSubjectSt($idhocphan){//this get the subject of the course
        $stmt = $this->db->query("SELECT hocphan.mamonthi, monthi.tenmonthi 
        FROM hocphan INNER JOIN monthi ON hocphan.mamonthi=monthi.mamonthi Where hocphan.mahocphan = '$idhocphan';");
        return $stmt;
    }

    public function getSemester($idsem){ // this return semester info
        $stmt = $this->db->query("SELECT `ky`, `nambatdau`, `namketthuc` FROM `kythi` WHERE `id` = '$idsem';;");
        return $stmt;
    }

    public function getQualification($idSV){
        $stmt = $this->db->query("SELECT  `dudieukienduthi` FROM `sinhvien` WHERE `id` = '$idSV';");
        return $stmt;
    }
}