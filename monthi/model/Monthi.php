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
     * Lấy toàn bộ danh sách môn thi
     * @return array: Mảng danh sách môn thi
     */
    public function getAll() {
        $ret = $this->doQuery("SELECT * FROM monthi ORDER BY tenmonthi");
        return $ret;
    }

    /**
     * Hàm thêm môn thi.
     * @param $mamonthi: Mã môn thi.
     * @param $tenmonthi: Tên môn thi.
     * @param $tinchi: Số tín chỉ.
     * @return int: Số bản ghi được cập nhật.
     */
    public function add($mamonthi, $tenmonthi, $tinchi) {
        // Khóa bảng
        $sql = "LOCK TABLES monthi WRITE";
        $this->doSql($sql);
        // Thêm môn học vào CSDL
        $sql = "INSERT INTO monthi(mamonthi, tenmonthi, tinchi) VALUES ('$mamonthi', '$tenmonthi', '$tinchi')";
        $c = $this->doSql($sql);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return $c;
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
        // Xóa môn học khỏi CSDL
        $sql = "DELETE FROM monthi WHERE monthi.mamonthi = '$mamonthi'";
        $c = $this->doSql($sql);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return $c;
    }
}