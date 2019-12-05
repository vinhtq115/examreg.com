<?php


namespace hocphan\model;

use PDOData;

require_once dirname(__FILE__)."/../../core/data/PDOData.php";


class Hocphan extends PDOData {
    /**
     * Hocphan constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Hocphan deconstructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Lấy toàn bộ danh sách học phần.
     * @return array: Mảng danh sách học phần.
     */
    public function getAll() {
        $ret = $this->doQuery("SELECT hp.mahocphan, hp.mamonthi, mt.tenmonthi FROM hocphan hp, (SELECT monthi.mamonthi as mamonthi, monthi.tenmonthi as tenmonthi FROM monthi) mt WHERE hp.mamonthi = mt.mamonthi ORDER BY tenmonthi, mahocphan;");
        return $ret;
    }

    /**
     * Lấy toàn bộ danh sách mã học phần.
     * @return array: Mảng danh sách mã học phần.
     */
    public function getAllmahocphan() {
        $ret = $this->doQuery("SELECT mahocphan FROM hocphan");
        return $ret;
    }

    /**
     * Hàm thêm học phần.
     * @param $mahocphan: Mã học phần.
     * @param $mamonthi: Mã môn thi.
     * @return int: Số bản ghi được cập nhật.
     */
    public function add($mahocphan, $mamonthi) {
        // Kiểm tra xem mã môn thi có tồn tại trong CSDL không
        $sql = "SELECT * FROM monthi WHERE mamonthi = '$mamonthi'";
        $arr = $this->doQuery($sql); // Lấy mảng môn thi trùng mã vừa nhập
        if (count($arr) == 0) { // Môn học không tồn tại trong hệ thống
            return 0;
        }
        // Môn học đã tồn tại trong hệ thống.
        // Khóa bảng
        $sql = "LOCK TABLES hocphan WRITE";
        $this->doSql($sql);
        // Thêm học phần vào CSDL
        $sql = "INSERT INTO `hocphan` (`mahocphan`, `mamonthi`) VALUES ('$mahocphan', '$mamonthi')";
        $c = $this->doSql($sql);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return $c;
    }

    /**
     * Hàm xóa học phần.
     * @param $mahocphan: Mã học phần.
     * @return int: Số bản ghi được cập nhật.
     */
    public function delete($mahocphan) {
        // Khóa bảng
        $sql = "LOCK TABLES hocphan WRITE";
        $this->doSql($sql);
        // Kiểm tra xem mã học phần có tồn tại trong CSDL không
        $sql = "SELECT * FROM hocphan WHERE mahocphan = '$mahocphan'";
        $arr = $this->doQuery($sql); // Lấy mảng học phần trùng mã vừa nhập
        if (count($arr) == 0) { // Học phần không tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Học phần tồn tại trong hệ thống
        // Xóa học phần khỏi CSDL
        $sql = "DELETE FROM hocphan WHERE hocphan.mahocphan = '$mahocphan'";
        $c = $this->doSql($sql);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return $c;
    }
}