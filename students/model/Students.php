<?php
namespace students\model;

use PDOData;

require_once dirname(__FILE__)."/../../core/data/PDOData.php";

class Students extends PDOData {
    /**
     * Students constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Students destructor.
     */
    public function __destruct() {
        parent::__destruct();
    }

    /**
     * Thêm sinh viên vào CSDL.
     * @param $id: Mã số sinh viên
     * @param $hodem: Họ đệm
     * @param $ten: Tên
     * @param $dateOfBirth: Ngày sinh
     */
    public function addStudentData($id , $hodem , $ten ,$dateOfBirth){
        //add the data to the student database
        $sql = "INSERT INTO sinhvien (id, hodem, ten, ngaysinh) VALUES (?, ?, ?, ?)";
        $this->doPreparedQuery($sql, [$id, $hodem, $ten, $dateOfBirth]);
    }

    /**
     * Tạo tài khoản sinh viên.
     * @param $password: Mật khẩu
     * @param $idsinhvien: Mã sinh viên
     */
    public function createStudentAccount($password,$idsinhvien){
        //add the data to the account database
        $sql = "INSERT INTO account (id, isAdmin, password, idsinhvien) VALUES (?, 0, PASSWORD(?), ?)";
        $this->doPreparedQuery($sql, [$idsinhvien, $password, $idsinhvien]);
    }

    /**
     * Cập nhật thông tin sinh viên
     * @param $idSV: Mã sinh viên
     * @param $hodem: Họ đệm
     * @param $ten: Tên
     * @param $dateOfBirth: Ngày sinh
     */
    public function updateStudentInfo($idSV , $hodem , $ten ,$dateOfBirth) {
        $sql = "UPDATE sinhvien SET id = ?, hodem = ?, ten = ?, ngaysinh = ? WHERE id = ?";
        $this->doPreparedQuery($sql, [$idSV, $hodem, $ten, $dateOfBirth]);
    }

    /**
     * Cập nhật tài khoản sinh viên.
     * @param $password: Mật khẩu
     * @param $idsinhvien: Mã sinh viên
     */
    public function updateAccount($password,$idsinhvien) {
        $sql = "UPDATE account SET id= ?, password = PASSWORD(?), idsinhvien = ? 
        WHERE account.idsinhvien = ?";
        $this->doPreparedQuery($sql, [$idsinhvien, $password, $idsinhvien, $idsinhvien]);
    }

    /**
     * Cập nhật đủ điều kiện dự thi.
     * @param $id: Mã sinh viên
     * @param $qualification: Trạng thái đủ điều kiện dự thi. 1 là đủ điều kiện dự thi, 0 là không đủ điều kiện dự thi.
     */
    public function updateDisqualifiedStudent($id,$qualification) {
        // this function is used to update the dukienthi attribute of the sinhvien table on the db
        $sql = "UPDATE sinhvien SET dudieukienduthi = ? WHERE id = ?";
        $this->doPreparedQuery($sql, [$qualification, $id]);
    }

    /**
     * Thêm sinh viên học học phần.
     * @param $id: Mã sinh viên.
     * @param $courseid: Mã học phần.
     * @param $maky: Mã kỳ thi
     */
    public function updateCourse($id , $courseid , $maky) {
        //this function is used to add courses to the database
        $sql = "INSERT INTO sinhvien_hoc_hocphan (masinhvien, mahocphan, idhocky) VALUES (?, ?, ?)";
        $this->doPreparedQuery($sql, [$id, $courseid, $maky]);
    }

    /**
     * Lấy toàn bộ danh sách sinh viên.
     * @return array: Mảng thông tin sinh viên.
     */
    public function getStudentInfo() {
        return $this->doQuery("SELECT id, hodem, ten, ngaysinh, dudieukienduthi FROM sinhvien ORDER BY id");
    }

    /**
     * Dùng để kiểm tra xem sinh viên có tồn tại hay không bằng mã sinh viên.
     * @param $id: Mã sinh viên.
     * @return array: Mảng thông tin sinh viên.
     */
    public function getIDOnly($id){
        $sql = "SELECT id FROM sinhvien WHERE id = ?";
        return $this->doPreparedQuery($sql, [$id]);
    }

    /**
     * Lấy danh sách sinh viên học học phần của từng kỳ.
     * @return array: Mảng sinh viên học học phần của từng kỳ.
     */
    public function getStudentCourseHKInfo(){ // get course and semester to display
        return $this->doQuery("SELECT masinhvien, mahocphan, idhocky FROM sinhvien_hoc_hocphan ORDER BY idhocky, masinhvien, mahocphan");
    }

    /**
     * Lấy danh sách sinh viên học học phần của từng kỳ.
     * @return array: Mảng sinh viên học học phần của từng kỳ.
     */
    public function getSVHHP() {
        return $this->doQuery("SELECT svhhp.masinhvien, CONCAT(sv.hodem, \" \", sv.ten) hoten , svhhp.mahocphan, mt.tenmonthi, CONCAT(\"Kỳ \", kt.ky, \" năm học \", kt.nambatdau, \"-\", kt.namketthuc) hocky FROM sinhvien_hoc_hocphan svhhp INNER JOIN sinhvien sv ON svhhp.masinhvien = sv.id INNER JOIN hocphan hp ON hp.mahocphan = svhhp.mahocphan INNER JOIN monthi mt ON hp.mamonthi = mt.mamonthi INNER JOIN kythi kt ON kt.id = svhhp.idhocky ORDER BY idhocky, masinhvien");
    }

    /**
     * Xóa sinh viên theo mã sinh viên.
     * @param $idSV: Mã số sinh viên.
     */
    public function deleteStudentWID($idSV){ //delete function
        $sql = "DELETE FROM sinhvien WHERE id = ?";
        $this->doPreparedQuery($sql, [$idSV]);
    }

    /**
     * Xóa sinh viên học học phần của học kỳ.
     * @param $sinhvien: Mã sinh viên
     * @param $hocphan: Mã học phần
     * @param $hocky: Học kỳ
     */
    public function deleteCourseHK($sinhvien,$hocphan,$hocky){
        $sql = "DELETE FROM sinhvien_hoc_hocphan WHERE masinhvien = ? AND mahocphan = ? AND idhocky = ?";
        $this->doPreparedQuery($sql, [$sinhvien, $hocphan, $hocky]);
    }

    /**
     * Lấy thông tin học phần.
     * @param $idhocphan: Mã học phần
     * @return array: Thông tin học phần
     */
    public function getCourseSubject($idhocphan){
        //this get id subject id
        $sql = "SELECT tenmonthi, tinchi FROM monthi INNER JOIN hocphan ON monthi.mamonthi=hocphan.mamonthi WHERE hocphan.mahocphan = ?";
        return $this->doPreparedQuery($sql, [$idhocphan]);
    }

    /**
     * Lấy mã môn thi qua mã học phần.
     * @param $idhocphan: Mã học phần.
     * @return array: Mảng mã môn thi.
     */
    public function getSubjectID($idhocphan){
        $sql = "SELECT mamonthi FROM hocphan WHERE mahocphan = ?";
        return $this->doPreparedQuery($sql, [$idhocphan]);
    }

    /**
     * Kiểm tra học kỳ có tồn tại hay không.
     * @param $maky: Mã kỳ thi
     * @return array: Mảng mã kỳ thi.
     */
    public function getTerm($maky){
        $sql = "SELECT id FROM kythi WHERE id = ?";
        return $this->doPreparedQuery($sql, [$maky]);
    }

    /**
     * Lấy thông tin kỳ thi.
     * @param $maky: Mã kỳ thi.
     * @return array: Mảng thông tin kỳ thi.
     */
    public function getTermInfo($maky){
        $sql = "SELECT ky, ngaybatdau, ngayketthuc FROM kythi WHERE id = ?";
        return $this->doPreparedQuery($sql, [$maky]);
    }
}