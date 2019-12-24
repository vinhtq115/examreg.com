<?php


namespace sinhvien\dangkythi\model;

use PDOData;

require_once dirname(__FILE__)."/../../../core/data/PDOData.php";

class Dangkythi extends PDOData {
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
     * Kiểm tra xem có kỳ thi nào đang được kích hoạt không.
     * @return int: 1 nếu có, 0 nếu không.
     */
    public function checkIfAllowedToRegister() {
        $ret = $this->doQuery("SELECT id FROM kythi WHERE active = 1 LIMIT 1");
        return sizeof($ret);
    }

    /**
     * Lấy danh sách ca thi có thể đăng ký được.
     * @return array: Mảng ca thi có thể đăng ký được.
     */
    public function getRegistrableCathi() {
        $sql = "SELECT ct.macathi, ct.mahocphan, mt.tenmonthi, ct.ngaythi, ct.giobatdau, ct.gioketthuc, ptct.maphongthi 
                FROM cathi ct INNER JOIN hocphan hp ON ct.mahocphan = hp.mahocphan 
                INNER JOIN monthi mt ON mt.mamonthi = hp.mamonthi INNER JOIN phongthi_cathi ptct ON ptct.macathi = ct.macathi 
                WHERE ct.makythi = $this->kythihientai AND ct.macathi IN (SELECT ct.macathi FROM cathi ct WHERE ct.mahocphan IN 
                (SELECT svhhp.mahocphan FROM sinhvien_hoc_hocphan svhhp WHERE masinhvien = $this->mssv AND idhocky = $this->kythihientai) 
                AND ct.makythi = $this->kythihientai AND ct.macathi NOT IN (SELECT macathi FROM cathi WHERE mahocphan IN 
                (SELECT ct.mahocphan FROM cathi ct WHERE ct.macathi IN (SELECT ct.macathi FROM cathi ct 
                INNER JOIN sinhvien_cathi_phongthi svctpt ON ct.macathi = svctpt.macathi WHERE ct.makythi = $this->kythihientai 
                AND svctpt.masinhvien = $this->mssv)) AND makythi = $this->kythihientai))";
        $arr1 = $this->doQuery($sql); // Ca thi không trùng học phần đã đăng ký thi
        foreach ($arr1 as $key => $value) {
            $macathi = $value["macathi"];
            $maphongthi = $value["maphongthi"];
            // Nếu mã ca thi chưa xuất hiện trong table sinhvien_cathi_phongthi có nghĩa là empty
            $sql = "SELECT macathi FROM sinhvien_cathi_phongthi WHERE macathi = ? AND maphongthi = ? LIMIT 1";
            $ret = $this->doPreparedQuery($sql, [$macathi, $maphongthi]);
            if (count($ret) == 0) {
                continue;
            }
            // Nếu đã có, kiểm tra xem nó có còn slot hay không
            // Lấy số lượng máy
            $sql = "SELECT soluongmay FROM phongthi WHERE maphongthi = ?";
            $ret = $this->doPreparedQuery($sql, [$maphongthi]);
            $soluongmay = intval($ret[0]["soluongmay"]);
            // Lấy số lượng máy đã bị chiếm
            $sql = "SELECT COUNT(masinhvien) taken FROM sinhvien_cathi_phongthi WHERE macathi = ? AND maphongthi = ?";
            $ret = $this->doPreparedQuery($sql, [$macathi, $maphongthi]);
            $taken = intval($ret[0]["taken"]);
            if ($soluongmay - $taken <= 0) {
                unset($arr1[$key]);
            }
        }

        return $arr1;
    }

    /**
     * Lấy danh sách ca thi đã đăng ký.
     * @return array: Mảng ca thi đã đăng ký.
     */
    public function getRegisteredCathi() {
        return $this->doQuery("SELECT ct.macathi, ct.mahocphan, b.tenmonthi, ct.ngaythi, ct.giobatdau, ct.gioketthuc, a.maphongthi FROM cathi ct INNER JOIN (SELECT svctpt.macathi, svctpt.maphongthi FROM sinhvien_cathi_phongthi svctpt WHERE svctpt.macathi IN (SELECT ct.macathi FROM cathi ct WHERE ct.makythi = '$this->kythihientai') AND svctpt.masinhvien = '$this->mssv') a ON a.macathi = ct.macathi INNER JOIN (SELECT hp.mahocphan, mt.tenmonthi FROM hocphan hp INNER JOIN (SELECT mamonthi, tenmonthi FROM monthi) mt ON mt.mamonthi = hp.mamonthi) b ON b.mahocphan = ct.mahocphan");
    }

    /**
     * @param $macathi : Mã ca thi
     * @param $maphongthi : Mã phòng thi
     * @return int :
     * 0 nếu OK.
     * 1 nếu không tồn tại ca thi trong kỳ thi hiện tại.
     * 2 nếu phòng thi không tồn tại.
     * 3 nếu phòng thi không nằm trong ca thi.
     * 4 nếu phòng thi không đủ máy.
     * 5 nếu thí sinh đã đăng ký phòng thi cho ca thi.
     */
    public function register($macathi, $maphongthi) {
        // Kiểm tra xem thí sinh đã đăng ký phòng thi cho ca thi từ trước chưa
        $sql = "SELECT * FROM sinhvien_cathi_phongthi WHERE macathi = ? AND maphongthi = ? AND masinhvien = ?";
        $arr = $this->doPreparedQuery($sql, [$macathi, $maphongthi, $this->mssv]);
        if (count($arr) >= 1) { // Thí sinh đã đăng ký phòng thi cho ca thi từ trước
            return 5;
        }
        //$sql = "SELECT * FROM sinhvien_cathi_phongthi WHERE macathi = '$macathi' AND maphongthi = '$maphongthi' AND masinhvien = '$this->mssv'";
        // Kiểm tra xem mã ca thi có đúng kỳ thi không
        $sql = "SELECT * FROM cathi WHERE macathi = '$macathi' AND makythi = '$this->kythihientai'";
        $arr = $this->doQuery($sql);
        if (count($arr) == 0) { // Không tồn tại ca thi trong kỳ thi hiện tại
            return 1;
        }
        // Kiểm tra xem mã phòng thi có tồn tại không
        $sql = "SELECT * FROM phongthi WHERE maphongthi = '$maphongthi'";
        $arr = $this->doQuery($sql);
        if (count($arr) == 0) { // Không tồn tại ca thi trong kỳ thi hiện tại
            return 2;
        }
        // Kiểm tra xem ca thi có phòng thi đó hay không
        $sql = "SELECT * FROM phongthi_cathi WHERE maphongthi = '$maphongthi' AND macathi = '$macathi'";
        $arr = $this->doQuery($sql);
        if (count($arr) == 0) { // Không tồn tại ca thi trong kỳ thi hiện tại
            return 3;
        }
        // Kiểm tra xem còn đủ máy trong phòng không
        $sql = "SELECT soluongmay FROM phongthi WHERE maphongthi = '$maphongthi'";
        $arr = $this->doQuery($sql);
        $soluongmay = 0; // Số lượng máy của phòng
        foreach ($arr as $key => $value) {
            $soluongmay = $value["soluongmay"];
        }
        $sql = "SELECT a.currentsv FROM (SELECT COUNT(masinhvien) currentsv, macathi, maphongthi FROM sinhvien_cathi_phongthi GROUP BY macathi, maphongthi) a WHERE macathi = '$macathi' AND maphongthi = '$maphongthi'";
        $arr = $this->doQuery($sql);
        $soluongmaydaco = 0; // Số lượng máy đã có thí sinh đăng ký
        foreach ($arr as $key => $value) {
            $soluongmaydaco = $value["currentsv"];
        }
        if ($soluongmay-$soluongmaydaco <= 0) {
            return 4;
        }
        // Đăng ký
        // Khóa bảng
        $sql = "LOCK TABLES sinhvien_cathi_phongthi WRITE";
        $this->doSql($sql);
        // Thêm slot vào CSDL
        $sql = "INSERT INTO sinhvien_cathi_phongthi (masinhvien, macathi, maphongthi) VALUES (?, ?, ?)";
        $this->doPreparedQuery($sql, [$this->mssv, $macathi, $maphongthi]);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return 0;
    }
}