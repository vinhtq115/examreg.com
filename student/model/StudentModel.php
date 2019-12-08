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

    public function getCourse($idSinhvien){
        $stmt = $this->db->query("SELECT `masinhvien`, `mahocphan`, `idhocky` FROM `sinhvien_hoc_hocphan` WHERE `masinhvien` = '$idSinhvien'"); // prepare the query for controller
        return $stmt; // return stmt first then fetch later on controller
    }

    public function getSubject(){

    }
}