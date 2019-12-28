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
     * Set kỳ thi hiện tại.
     * @param $makythi : Mã kỳ thi
     * @return int : 1 nếu OK và 0 nếu thất bại
     */
    public function setActive($makythi) {
        // Kiểm tra xem mã kỳ thi có tồn tại trong CSDL không
        $sql = "SELECT * FROM kythi WHERE id = ?";
        $arr = $this->doPreparedQuery($sql, [$makythi]); // Lấy mảng kỳ thi trùng mã vừa nhập
        if (count($arr) == 0) { // Kỳ thi không tồn tại trong hệ thống
            return 0;
        }
        // Khóa bảng
        $sql = "LOCK TABLES kythi WRITE";
        $this->doSql($sql);
        // Bỏ kỳ thi hiện tại
        $sql = "UPDATE kythi SET active = 0";
        $this->doSql($sql);
        // Set kỳ thi hiện tại
        $sql = "UPDATE kythi SET active = 1 WHERE kythi.id = ?";
        $this->doPreparedQuery($sql, [$makythi]);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return 1;
    }

    /**
     * Bỏ kỳ thi hiện tại.
     * @return int : Số bản ghi được cập nhật
     */
    public function disableActive() {
        // Khóa bảng
        $sql = "LOCK TABLES kythi WRITE";
        $this->doSql($sql);
        // Bỏ kỳ thi hiện tại
        $sql = "UPDATE kythi SET active = 0";
        $c = $this->doSql($sql);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return $c;
    }

    /**
     * Hàm thêm học kỳ.
     * @param $nambatdau: Năm bắt đầu học kỳ.
     * @param $namketthuc: Năm kết thúc học kỳ.
     * @param $hocky: Học kỳ (1, 2, 3, ...)
     * @param $ngaybatdau: Ngày bắt đầu thi.
     * @param $ngayketthuc: Ngày kết thúc thi.
     * @return int Số bản ghi được cập nhật
     */
    public function add($nambatdau, $namketthuc, $hocky, $ngaybatdau, $ngayketthuc) {
        // Khóa bảng
        $sql = "LOCK TABLES kythi WRITE";
        $this->doSql($sql);
        // Kiểm tra xem kỳ thi có tồn tại trong CSDL không
        $sql = "SELECT * FROM kythi WHERE nambatdau = ? AND namketthuc = ? AND ky = ?";
        $arr = $this->doPreparedQuery($sql, [$nambatdau, $namketthuc, $hocky]); // Lấy mảng kỳ thi trùng tham số đầu vào
        if (count($arr) > 0) { // Kỳ thi đã tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Kỳ thi chưa tồn tại trong hệ thống.
        // Thêm môn học vào CSDL
        $sql = "INSERT INTO kythi(ky, nambatdau, namketthuc, ngaybatdau, ngayketthuc) VALUES (?, ?, ?, ?, ?)";
        $this->doPreparedQuery($sql, [$hocky, $nambatdau, $namketthuc, $ngaybatdau, $ngayketthuc]);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return 1;
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
        $sql = "SELECT * FROM kythi WHERE id = ?";
        $arr = $this->doPreparedQuery($sql, [$makythi]); // Lấy mảng kỳ thi trùng mã vừa nhập
        if (count($arr) == 0) { // Kỳ thi không tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Kỳ thi tồn tại trong hệ thống
        // Xóa kỳ thi khỏi CSDL
        $sql = "DELETE FROM kythi WHERE kythi.id = ?";
        $this->doPreparedQuery($sql, [$makythi]);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return 1;
    }

    /**
     * Hàm sửa kỳ thi.
     * @param $id: Mã kỳ thi cần sửa.
     * @param $ky: Số chỉ kỳ thi mới.
     * @param $nambatdau: Năm bắt đầu mới.
     * @param $namketthuc: Năm kết thúc mới.
     * @param $ngaybatdau: Ngày bắt đầu thi mới.
     * @param $ngayketthuc: Ngày kết thúc thi mới.
     * @return int: Số bản ghi được cập nhật.
     */
    public function edit($id, $ky, $nambatdau, $namketthuc, $ngaybatdau, $ngayketthuc) {
        // Khóa bảng
        $sql = "LOCK TABLES kythi WRITE";
        $this->doSql($sql);
        // Kiểm tra xem mã kỳ thi có tồn tại trong CSDL không
        $sql = "SELECT * FROM kythi WHERE id = ?";
        $arr = $this->doPreparedQuery($sql, [$id]); // Lấy mảng kỳ thi trùng mã vừa nhập
        if (count($arr) == 0) { // Mã kỳ thi không tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Kiểm tra xem mã thông tin kỳ thi mới có tồn tại trong CSDL không
        $sql = "SELECT * FROM kythi WHERE nambatdau = ? AND namketthuc = ? AND ky = ?";
        $arr = $this->doPreparedQuery($sql, [$nambatdau, $namketthuc, $ky]); // Lấy mảng kỳ thi trùng mã vừa nhập
        if (count($arr) > 0) { // Kỳ thi mới tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Sửa thông tin
        $sql = "UPDATE kythi SET ky = ?, nambatdau = ?, namketthuc = ?, ngaybatdau = ?, ngayketthuc = ? WHERE kythi.id = ?";
        $this->doPreparedQuery($sql, [$ky, $nambatdau, $namketthuc, $ngaybatdau, $ngayketthuc, $id]);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return 1;
    }
}