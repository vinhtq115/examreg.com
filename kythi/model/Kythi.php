<?php


namespace kythi\model;

use PDOData;

require_once dirname(__FILE__)."/../../core/data/PDOData.php";


class Kythi extends PDOData {
    /**
     * Kythi constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Kythi deconstructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Lấy toàn bộ danh sách kỳ thi.
     * @return array: Mảng danh sách kỳ thi (mã, năm bắt đầu, năm kết thúc, kỳ).
     */
    public function getAll() {
        $ret = $this->doQuery("SELECT * FROM kythi ORDER BY nambatdau, ky");
        return $ret;
    }

    /**
     * Hàm thêm học kỳ.
     * @param $nambatdau: Năm bắt đầu học kỳ.
     * @param $namketthuc: Năm kết thúc học kỳ.
     * @param $hocky: Học kỳ (1, 2, 3, ...)
     * @return int Số bản ghi được cập nhật
     */
    public function add($nambatdau, $namketthuc, $hocky) {
        // Khóa bảng
        $sql = "LOCK TABLES kythi WRITE";
        $this->doSql($sql);
        // Kiểm tra xem kỳ thi có tồn tại trong CSDL không
        $sql = "SELECT * FROM kythi WHERE nambatdau = '$nambatdau' AND namketthuc = '$namketthuc' AND ky = '$hocky'";
        $arr = $this->doQuery($sql); // Lấy mảng kỳ thi trùng tham số đầu vào
        if (count($arr) > 0) { // Kỳ thi đã tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Kỳ thi chưa tồn tại trong hệ thống.
        // Thêm môn học vào CSDL
        $sql = "INSERT INTO kythi(ky, nambatdau, namketthuc) VALUES ('$hocky', '$nambatdau', '$namketthuc')";
        $c = $this->doSql($sql);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return $c;
    }

    /**
     * Hàm xóa kỳ thi.
     * @param $makythi: Mã kỳ thi.
     * @return int: Số bản ghi được cập nhật.
     */
    public function delete($makythi) {
        // Khóa bảng
        $sql = "LOCK TABLES kythi WRITE";
        $this->doSql($sql);
        // Kiểm tra xem mã kỳ thi có tồn tại trong CSDL không
        $sql = "SELECT * FROM kythi WHERE id = '$makythi'";
        $arr = $this->doQuery($sql); // Lấy mảng kỳ thi trùng mã vừa nhập
        if (count($arr) == 0) { // Kỳ thi không tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Kỳ thi tồn tại trong hệ thống
        // Xóa kỳ thi khỏi CSDL
        $sql = "DELETE FROM kythi WHERE kythi.id = '$makythi'";
        $c = $this->doSql($sql);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return $c;
    }

    /**
     * Hàm sửa kỳ thi.
     * @param $id: Mã kỳ thi cần sửa.
     * @param $ky: Số chỉ kỳ thi mới.
     * @param $nambatdau: Năm bắt đầu mới.
     * @param $namketthuc: Năm kết thúc mới.
     * @return int: Số bản ghi được cập nhật.
     */
    public function edit($id, $ky, $nambatdau, $namketthuc) {
        // Khóa bảng
        $sql = "LOCK TABLES kythi WRITE";
        $this->doSql($sql);
        // Kiểm tra xem mã kỳ thi có tồn tại trong CSDL không
        $sql = "SELECT * FROM kythi WHERE id = '$id'";
        $arr = $this->doQuery($sql); // Lấy mảng kỳ thi trùng mã vừa nhập
        if (count($arr) == 0) { // Mã kỳ thi không tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Kiểm tra xem mã thông tin kỳ thi mới có tồn tại trong CSDL không
        $sql = "SELECT * FROM kythi WHERE nambatdau = '$nambatdau' AND namketthuc = '$namketthuc' AND ky = '$ky'";
        $arr = $this->doQuery($sql); // Lấy mảng kỳ thi trùng mã vừa nhập
        if (count($arr) > 0) { // Kỳ thi mới tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Sửa thông tin
        $sql = "UPDATE kythi SET ky = '$ky', nambatdau = '$nambatdau', namketthuc = '$namketthuc' WHERE kythi.id = '$id'";
        $c = $this->doSql($sql);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return $c;
    }
}