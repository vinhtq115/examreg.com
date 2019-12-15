<?php

namespace sinhvien\home\model;

use PDOData;

require_once dirname(__FILE__)."/../../../core/data/PDOData.php";


class Sinhvien extends PDOData {
    private $mssv; // Mã số sinh viên

    /**
     * Sinhvien constructor.
     */
    public function __construct($mssv) {
        parent::__construct();

        $this->mssv = $mssv;
    }

    /**
     * Sinhvien destructor.
     */
    public function __destruct() {
        parent::__destruct();
    }

    /**
     * Lấy thông tin của sinh viên.
     * @return array: Thông tin sinh viên
     */
    public function getInfo() {
        return $this->doQuery("SELECT * FROM sinhvien WHERE id = $this->mssv");
    }

    /**
     * Lấy kỳ thi hiện tại.
     * @return array: Mảng chứa kỳ thi hiện tại
     */
    public function getCurrentSemester() {
        return $this->doQuery("SELECT * FROM kythi WHERE active = 1");
    }
}