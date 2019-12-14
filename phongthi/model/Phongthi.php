<?php


namespace phongthi\model;

use PDOData;

require_once dirname(__FILE__)."/../../core/data/PDOData.php";


class Phongthi extends PDOData {
    private $cathi; // Chứa mã ca thi

    /**
     * Phongthi constructor.
     * @param $cathi: Mã ca thi
     */
    public function __construct($cathi) {
        parent::__construct();

        $this->cathi = $cathi;
    }

    /**
     * Phongthi destructor.
     */
    public function __destruct() {
        parent::__destruct();
    }

    /**
     * Lấy toàn bộ danh sách phòng thi của ca thi.
     * @return array: Mảng danh sách phòng thi, số lượng máy
     */
    public function getAll() {
        return $this->doQuery("SELECT ptct.macathi, ptct.maphongthi, pt.diadiem, pt.soluongmay FROM phongthi_cathi ptct, (SELECT maphongthi, diadiem, soluongmay FROM phongthi) pt WHERE pt.maphongthi = ptct.maphongthi AND ptct.macathi = $this->cathi");
    }

    /**
     * Hàm thêm phòng thi.
     * @param $maphongthi: Mã phòng thi
     * @return int: 0 nếu lỗi hoặc 1 nếu thành công
     */
    public function add($maphongthi) {
        // Khóa bảng
        $sql = "LOCK TABLES phongthi_cathi WRITE, phongthi WRITE";
        $this->doSql($sql);
        // Kiểm tra xem mã phòng thi có tồn tại trong CSDL không
        $sql = "SELECT * FROM phongthi WHERE maphongthi = ?";
        $arr = $this->doPreparedQuery($sql, [$maphongthi]);
        if (count($arr) == 0) { // Phòng thi tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }

        // Phòng thi tồn tại trong hệ thống
        // Kiểm tra xem mã phòng thi đã tồn tại trong ca thi chưa
        $sql = "SELECT * FROM phongthi_cathi WHERE maphongthi = ?";
        $arr = $this->doPreparedQuery($sql, [$maphongthi]);
        if (count($arr) > 0) { // Phòng thi đã có sẵn trong ca thi
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }

        // Thêm phòng thi vào ca thi
        $sql = "INSERT INTO phongthi_cathi (macathi, maphongthi) VALUES (?, ?)";
        $this->doPreparedQuery($sql, [$this->cathi, $maphongthi]);

        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return 1;
    }

    /**
     * Hàm xóa phòng thi.
     * @param $maphongthi: Mã phòng thi.
     * @return int: Số bản ghi được cập nhật
     */
    public function delete($maphongthi) {
        // Khóa bảng
        $sql = "LOCK TABLES phongthi_cathi WRITE";
        $this->doSql($sql);
        // Kiểm tra xem ca thi có chứa phòng thi chưa
        $sql = "SELECT * FROM phongthi_cathi WHERE maphongthi = ?";
        $arr = $this->doPreparedQuery($sql, [$maphongthi]);
        if (count($arr) == 0) { // Phòng thi chưa có sẵn trong ca thi
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }

        // Xóa phòng thi khỏi ca thi
        $sql = "DELETE FROM phongthi_cathi WHERE macathi = ? AND maphongthi = ?";
        $this->doPreparedQuery($sql, [$this->cathi, $maphongthi]);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return 1;
    }
}