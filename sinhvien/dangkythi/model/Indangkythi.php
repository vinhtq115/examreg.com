<?php


namespace sinhvien\dangkythi\model;

use PDOData;

require_once dirname(__FILE__)."/../../../core/data/PDOData.php";

class Indangkythi extends PDOData {
    private $kythihientai; // Kỳ thi hiện tại
    private $mssv; // Mã số sinh viên

    /**
     * Dangkythi constructor.
     */
    public function __construct($mssv) {
        parent::__construct();

        // Lấy kỳ thi hiện tại
        $this->getCurrentSemester();
        // Set mã sinh viên
        $this->mssv = $mssv;
    }

    /**
     * Lấy kỳ thi hiện tại
     */
    public function getCurrentSemester() {
        $ret = $this->doQuery("SELECT id FROM kythi WHERE active = 1 LIMIT 1");
        $temp = json_decode(json_encode(json_decode(json_encode($ret), false)[0]), true);
        $this->kythihientai = $temp["id"];
    }

    /**
     * Lấy danh sách ca thi đã đăng ký.
     * @return array: Mảng ca thi đã đăng ký.
     */
    public function getRegisteredCathi() {
        return $this->doQuery("SELECT ct.macathi, ct.mahocphan, b.tenmonthi, ct.ngaythi, ct.giobatdau, ct.gioketthuc, a.maphongthi FROM cathi ct INNER JOIN (SELECT svctpt.macathi, svctpt.maphongthi FROM sinhvien_cathi_phongthi svctpt WHERE svctpt.macathi IN (SELECT ct.macathi FROM cathi ct WHERE ct.makythi = '$this->kythihientai') AND svctpt.masinhvien = '$this->mssv') a ON a.macathi = ct.macathi INNER JOIN (SELECT hp.mahocphan, mt.tenmonthi FROM hocphan hp INNER JOIN (SELECT mamonthi, tenmonthi FROM monthi) mt ON mt.mamonthi = hp.mamonthi) b ON b.mahocphan = ct.mahocphan ORDER BY ct.ngaythi, ct.giobatdau");
    }

    /**
     * Lấy thông tin sinh viên.
     * @return array: Mảng chứa thông tin sinh viên.
     */
    public function getStudentInfo() {
        return $this->doQuery("SELECT id, hodem, ten, ngaysinh FROM sinhvien WHERE id = $this->mssv");
    }

    /**
     * Lấy thông tin kỳ hiện tại.
     * @return array: Mảng chứa kỳ hiện tại.
     */
    public function getSemesterInfo() {
        return $this->doQuery("SELECT ky, nambatdau, namketthuc FROM kythi WHERE id = $this->kythihientai");
    }
}