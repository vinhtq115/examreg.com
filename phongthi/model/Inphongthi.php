<?php


namespace phongthi\model;

use PDOData;

require_once dirname(__FILE__)."/../../core/data/PDOData.php";

class Inphongthi extends PDOData {
    private $cathi; // Mã ca thi
    private $phongthi; // Mã phòng thi

    /**
     * Inphongthi constructor.
     * @param $cathi: Mã ca thi
     * @param $phongthi: Mã phòng thi
     */
    public function __construct($cathi, $phongthi) {
        parent::__construct();

        $this->cathi = $cathi;
        $this->phongthi = $phongthi;
    }

    /**
     * Lấy danh sách sinh viên trong phòng thi của ca thi.
     * @return array
     */
    public function getAll() {
        $sql = "SELECT svctpt.masinhvien, s.hodem, s.ten, s.ngaysinh FROM sinhvien_cathi_phongthi svctpt INNER JOIN sinhvien s ON svctpt.masinhvien = s.id WHERE svctpt.macathi = ? AND svctpt.maphongthi = ? ORDER BY s.ten, s.hodem";
        return $this->doPreparedQuery($sql, [$this->cathi, $this->phongthi]);
    }

    /**
     * Lấy thông tin ca thi.
     * @return array
     */
    public function getCathi() {
        $sql = "SELECT ct.macathi, ct.mahocphan, mt.tenmonthi, ct.ngaythi, ct.giobatdau, ct.gioketthuc FROM cathi ct INNER JOIN hocphan hp ON ct.mahocphan = hp.mahocphan INNER JOIN monthi mt ON mt.mamonthi = hp.mamonthi WHERE ct.macathi = ?";
        return $this->doPreparedQuery($sql, [$this->cathi]);
    }

    /**
     * Lấy thông tin phòng thi.
     * @return array
     */
    public function getPhongthi() {
        $sql = "SELECT * FROM phongthi WHERE maphongthi = ?";
        return $this->doPreparedQuery($sql, [$this->phongthi]);
    }
}