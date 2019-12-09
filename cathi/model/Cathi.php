<?php


namespace cathi\model;

use PDOData;

require_once dirname(__FILE__)."/../../core/data/PDOData.php";


class Cathi extends PDOData {
    private $kythi; // Chứa mã kỳ thi

    /**
     * Cathi constructor.
     * @param $kythi: Mã kỳ thi
     */
    public function __construct($kythi) {
        parent::__construct();

        $this->kythi = $kythi;
    }

    /**
     * Cathi deconstructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Lấy toàn bộ danh sách ca thi.
     * @return array: Mảng danh sách ca thi (mã ca thi, mã học phần, tên môn thi, ngày thi, giờ bắt đầu, giờ kết thúc).
     */
    public function getAll() {
        $ret = $this->doQuery("SELECT ct.macathi, ct.mahocphan, a.tenmonthi, ct.ngaythi, ct.giobatdau, ct.gioketthuc FROM cathi ct INNER JOIN (SELECT hp.mahocphan, mt.tenmonthi FROM hocphan hp, (SELECT mamonthi, tenmonthi FROM monthi) mt WHERE hp.mamonthi = mt.mamonthi) a ON a.mahocphan = ct.mahocphan WHERE ct.makythi = '$this->kythi' ORDER BY ct.ngaythi, ct.giobatdau, ct.gioketthuc, a.tenmonthi");
        return $ret;
    }

    /**
     * Lấy năm bắt đầu và năm kết thúc, kỳ (1, 2, ...) của kỳ thi hiện tại.
     * @return array: Chứa năm bắt đầu và năm kết thúc, kỳ (1, 2, ...).
     */
    public function getYear() {
        $ret = $this->doQuery("SELECT nambatdau, namketthuc, ky FROM kythi WHERE id = '$this->kythi'");
        return $ret;
    }

    /**
     * Hàm thêm ca thi.
     * @param $mahocphan: Mã học phần
     * @param $ngaythi: Ngày thi (định dạng: YYYY-MM-DD)
     * @param $giobatdau: Giờ bắt đầu thi (định dạng: HH:MM:SS)
     * @param $gioketthuc: Giờ kết thúc thi (định dạng: HH:MM:SS)
     * @return int: Số bản ghi được cập nhật
     */
    public function add($mahocphan, $ngaythi, $giobatdau, $gioketthuc) {
        // Khóa bảng
        $sql = "LOCK TABLES cathi WRITE";
        $this->doSql($sql);
        // Kiểm tra xem ca thi có tồn tại trong CSDL không
        $sql = "SELECT * FROM cathi WHERE mahocphan = '$mahocphan' AND ngaythi = '$ngaythi' AND giobatdau = '$giobatdau' AND gioketthuc = '$gioketthuc' AND makythi = '$this->kythi'";
        $arr = $this->doQuery($sql); // Lấy mảng ca thi trùng thông tin vừa nhập
        if (count($arr) > 0) { // Ca thi tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Thêm ca thi vào CSDL
        $sql = "INSERT INTO cathi (mahocphan, makythi, ngaythi, giobatdau, gioketthuc) VALUES ('$mahocphan', '$this->kythi', '$ngaythi', '$giobatdau', '$gioketthuc')";
        $c = $this->doSql($sql);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return $c;
    }

    /**
     * Hàm xóa ca thi.
     * @param $macathi: Mã ca thi.
     * @return int: Số bản ghi được cập nhật.
     */
    public function delete($macathi) {
        // Khóa bảng
        $sql = "LOCK TABLES cathi WRITE";
        $this->doSql($sql);
        // Kiểm tra xem mã ca thi có tồn tại trong CSDL không
        $sql = "SELECT * FROM cathi WHERE macathi = '$macathi' AND makythi = '$this->kythi'";
        $arr = $this->doQuery($sql); // Lấy mảng ca thi trùng mã vừa nhập
        if (count($arr) == 0) { // Ca thi không tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Ca thi tồn tại trong hệ thống
        // Xóa ca thi khỏi CSDL
        $sql = "DELETE FROM cathi WHERE cathi.macathi = '$macathi' AND cathi.makythi = '$this->kythi'";
        $c = $this->doSql($sql);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return $c;
    }

    /**
     * Hàm sửa ca thi.
     * @param $macathi : Mã ca thi.
     * @param $mahocphan : Mã học phần
     * @param $ngaythi : Ngày thi (định dạng: YYYY-MM-DD)
     * @param $giobatdau : Giờ bắt đầu thi (định dạng: HH:MM:SS)
     * @param $gioketthuc : Giờ kết thúc thi (định dạng: HH:MM:SS)
     * @return int: Số bản ghi được cập nhật.
     */
    public function edit($macathi, $mahocphan, $ngaythi, $giobatdau, $gioketthuc) {
        // Khóa bảng
        $sql = "LOCK TABLES cathi WRITE";
        $this->doSql($sql);
        // Kiểm tra xem mã ca thi có tồn tại trong CSDL không
        $sql = "SELECT * FROM cathi WHERE macathi = '$macathi' AND makythi = '$this->kythi'";
        $arr = $this->doQuery($sql); // Lấy mảng ca thi trùng mã vừa nhập
        if (count($arr) == 0) { // Ca thi không tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Ca thi tồn tại trong hệ thống
        // Kiểm tra xem thông tin ca thi mới có tồn tại trong CSDL không
        $sql = "SELECT * FROM cathi WHERE mahocphan = '$mahocphan' AND ngaythi = '$ngaythi' AND giobatdau = '$giobatdau' AND gioketthuc = '$gioketthuc' AND makythi = '$this->kythi'";
        $arr = $this->doQuery($sql); // Lấy mảng ca thi trùng thông tin mới
        if (count($arr) > 0) { // Ca thi mới tồn tại trong hệ thống
            // Mở khóa bảng
            $sql = "UNLOCK TABLES";
            $this->doSql($sql);
            return 0;
        }
        // Sửa thông tin
        $sql = "UPDATE cathi SET mahocphan = '$mahocphan', ngaythi = '$ngaythi', giobatdau = '$giobatdau', gioketthuc = '$gioketthuc' WHERE cathi.macathi = '$macathi' AND cathi.makythi = '$this->kythi'";
        $c = $this->doSql($sql);
        // Mở khóa bảng
        $sql = "UNLOCK TABLES";
        $this->doSql($sql);

        return $c;
    }
}