<?php


namespace quanlyphongthi\model;

use PDOData;

require_once dirname(__FILE__)."/../../core/data/PDOData.php";


class Phongthi extends PDOData {
    /**
     * Phongthi constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Phongthi deconstructor.
     */
    public function __destruct() {
        parent::__destruct();
    }

    /**
     * Lấy toàn bộ danh sách phòng thi.
     * @return array: Mảng danh sách phòng thi.
     */
    public function getAll() {
        $ret = $this->doQuery("SELECT * FROM phongthi ORDER BY maphongthi");
        return $ret;
    }

    /**
     * Lấy toàn bộ danh sách mã phòng thi.
     * @return array: Mảng danh sách mã phòng thi.
     */
    public function getAllmaphongthi() {
        $ret = $this->doQuery("SELECT maphongthi FROM phongthi");
        return $ret;
    }

    /**
     * Hàm thêm phòng thi
     * @param $maphongthi: Mã phòng thi
     * @param $diadiem: Địa điểm phòng thi
     * @param $soluongmay: Số lượng máy
     * @return int: 0 nếu lỗi và 1 nếu thành công
     */
    public function add($maphongthi, $diadiem, $soluongmay) {
        // Khóa bảng
        $sql = "LOCK TABLES phongthi WRITE";
        $this->doSql($sql);
        // Kiểm tra xem mã phòng thi có tồn tại trong CSDL không
        $sql = "SELECT * FROM phongthi WHERE maphongthi = ?";
        $arr = $this->doPreparedQuery($sql, [$maphongthi]); // Lấy mảng phòng thi trùng mã vừa nhập
        if (count($arr) > 0) { // Mã phòng thi đã tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Mã phòng học chưa tồn tại trong hệ thống
        // Thêm phòng thi vào CSDL
        $sql = "INSERT INTO phongthi(maphongthi, diadiem, soluongmay) VALUES (?, ?, ?)";
        $this->doPreparedQuery($sql, [$maphongthi, $diadiem, $soluongmay]);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return 1;
    }

    /**
     * Hàm xóa phòng thi.
     * @param $maphongthi: Mã phòng thi.
     * @return int: Số bản ghi được cập nhật.
     */
    public function delete($maphongthi) {
        // Khóa bảng
        $sql = "LOCK TABLES phongthi WRITE";
        $this->doSql($sql);
        // Kiểm tra xem mã phòng thi có tồn tại trong CSDL không
        $sql = "SELECT * FROM phongthi WHERE maphongthi = ?";
        $arr = $this->doPreparedQuery($sql, [$maphongthi]); // Lấy mảng phòng thi trùng mã vừa nhập
        if (count($arr) == 0) { // Mã phòng thi đã tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Mã phòng học đã tồn tại trong hệ thống
        // Xóa phòng học khỏi CSDL
        $sql = "DELETE FROM phongthi WHERE phongthi.maphongthi = ?";
        $this->doPreparedQuery($sql, [$maphongthi]);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return 1;
    }

    /**
     * Hàm sửa phòng thi.
     * @param $old_maphongthi: Mã phòng thi cần sửa.
     * @param $maphongthi: Mã phòng thi mới.
     * @param $diadiem: Địa điểm.
     * @param $soluongmay: Số lượng máy.
     * @return int: 0 nếu lỗi và 1 nếu thành công.
     */
    public function edit($old_maphongthi, $maphongthi, $diadiem, $soluongmay) {
        // Khóa bảng
        $sql = "LOCK TABLES phongthi WRITE";
        $this->doSql($sql);
        // Kiểm tra xem mã phòng thi cũ có tồn tại trong CSDL không
        $sql = "SELECT * FROM phongthi WHERE maphongthi = ?";
        $arr = $this->doPreparedQuery($sql, [$old_maphongthi]); // Lấy mảng phòng thi trùng mã vừa nhập
        if (count($arr) == 0) { // Mã phòng thi cũ không tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Mã phòng thi cũ tồn tại trong hệ thống.
        if ($old_maphongthi != $maphongthi) { // Trường hợp sửa mã phòng thi
            // Kiểm tra xem mã phòng thi mới đã tồn tại trong CSDL chưa
            $sql = "SELECT * FROM phongthi WHERE maphongthi = ?";
            $arr = $this->doPreparedQuery($sql, [$maphongthi]); // Lấy mảng phòng thi trùng mã vừa nhập
            if (count($arr) > 0) { // Phòng thi đã tồn tại trong hệ thống
                // Mở khóa bảng
                $sql = "UNLOCK TABLES";
                $this->doSql($sql);
                return 0;
            }
        }

        // Sửa thông tin phòng thi
        $sql = "UPDATE phongthi SET maphongthi = ?, diadiem = ?, soluongmay = ? WHERE phongthi.maphongthi = ?";
        $this->doPreparedQuery($sql, [$maphongthi, $diadiem, $soluongmay, $old_maphongthi]);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return 1;
    }
}