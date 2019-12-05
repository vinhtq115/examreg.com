<?php


namespace monthi\model;

use PDOData;

require_once dirname(__FILE__)."/../../core/data/PDOData.php";


class Monthi extends PDOData {
    /**
     * Monthi constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Monthi deconstructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Lấy toàn bộ danh sách môn thi.
     * @return array: Mảng danh sách môn thi.
     */
    public function getAll() {
        $ret = $this->doQuery("SELECT * FROM monthi ORDER BY tenmonthi");
        return $ret;
    }

    /**
     * Lấy toàn bộ danh sách mã môn thi.
     * @return array: Mảng danh sách mã môn thi.
     */
    public function getAllmamonthi() {
        $ret = $this->doQuery("SELECT mamonthi FROM monthi");
        return $ret;
    }

    /**
     * Hàm thêm môn thi.
     * @param $mamonthi: Mã môn thi.
     * @param $tenmonthi: Tên môn thi.
     * @param $tinchi: Số tín chỉ.
     * @return int: 0 nếu lỗi và 1 nếu thành công
     */
    public function add($mamonthi, $tenmonthi, $tinchi) {
        // Khóa bảng
        $sql = "LOCK TABLES monthi WRITE";
        $this->doSql($sql);
        // Kiểm tra xem mã môn thi có tồn tại trong CSDL không
        $sql = "SELECT * FROM monthi WHERE mamonthi = '$mamonthi'";
        $arr = $this->doQuery($sql); // Lấy mảng môn thi trùng mã vừa nhập
        if (count($arr) > 0) { // Môn học đã tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Môn học chưa tồn tại trong hệ thống.
        // Thêm môn học vào CSDL
        $sql = "INSERT INTO monthi(mamonthi, tenmonthi, tinchi) VALUES (?, ?, ?)";
        $this->doPreparedQuery($sql, [$mamonthi, $tenmonthi, $tinchi]);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return 1;
    }

    /**
     * Hàm xóa môn thi.
     * @param $mamonthi: Mã môn thi.
     * @return int: Số bản ghi được cập nhật.
     */
    public function delete($mamonthi) {
        // Khóa bảng
        $sql = "LOCK TABLES monthi WRITE";
        $this->doSql($sql);
        // Kiểm tra xem mã môn thi có tồn tại trong CSDL không
        $sql = "SELECT * FROM monthi WHERE mamonthi = '$mamonthi'";
        $arr = $this->doQuery($sql); // Lấy mảng môn thi trùng mã vừa nhập
        if (count($arr) == 0) { // Môn học không tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Môn học tồn tại trong hệ thống
        // Xóa môn học khỏi CSDL
        $sql = "DELETE FROM monthi WHERE monthi.mamonthi = '$mamonthi'";
        $c = $this->doSql($sql);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return $c;
    }

    /**
     * Hàm sửa môn thi.
     * @param $old_mamonthi: Mã môn thi cũ
     * @param $mamonthi: Mã môn thi mới.
     * @param $tenmonthi: Tên môn thi mới.
     * @param $tinchi: Số tín chỉ mới.
     * @return int: 0 nếu lỗi và 1 nếu thành công.
     */
    public function edit($old_mamonthi, $mamonthi, $tenmonthi, $tinchi) {
        // Khóa bảng
        $sql = "LOCK TABLES monthi WRITE";
        $this->doSql($sql);
        // Kiểm tra xem mã môn thi cũ có tồn tại trong CSDL không
        $sql = "SELECT * FROM monthi WHERE mamonthi = '$old_mamonthi'";
        $arr = $this->doQuery($sql); // Lấy mảng môn thi trùng mã vừa nhập
        if (count($arr) == 0) { // Mã môn học cũ không tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }

        // Mã môn học cũ tồn tại trong hệ thống.
        if ($old_mamonthi != $mamonthi) { // Trường hợp sửa mã môn thi
            // Kiểm tra xem mã môn thi mới đã tồn tại trong CSDL chưa
            $sql = "SELECT * FROM monthi WHERE mamonthi = '$mamonthi'";
            $arr = $this->doQuery($sql); // Lấy mảng môn thi trùng mã vừa nhập
            if (count($arr) > 0) { // Môn học đã tồn tại trong hệ thống
                // Mở khóa bảng
                $sql = "UNLOCK TABLES";
                $this->doSql($sql);
                return 0;
            }
        }

        // Sửa tên và số tín chỉ
        $sql = "UPDATE monthi SET mamonthi = ?, tenmonthi = ?, tinchi = ? WHERE monthi.mamonthi = ?";
        $this->doPreparedQuery($sql, [$mamonthi, $tenmonthi, $tinchi, $old_mamonthi]);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return 1;
    }
}