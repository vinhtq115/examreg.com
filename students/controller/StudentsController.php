<?php
namespace students\controller;

use students\model\Students;
use students\view\StudentsView;

require_once dirname(__FILE__)."/../model/Students.php";
require_once dirname(__FILE__)."/../view/StudentsView.php";
require_once dirname(__FILE__)."/../../utils/getExcelData.php";

class StudentsController {
    private $model; // Model Students
    private $view; // View Students

    /**
     * StudentsController constructor.
     */
    function __construct() {
        $this->model = new Students();
        $this->view = new StudentsView();
    }

    /**
     * Hiện danh sách sinh viên dưới dạng bảng.
     * @return string
     */
    public function tableSV() {
        return $this->view->tableSinhvienView(json_encode($this->model->getStudentInfo()));
    }

    /**
     * Hiện danh sách sinh viên học học phần dưới dạng bảng.
     * @return string
     */
    public function tableSVHHP() {
        return $this->view->tableSinhvienhocHocphanView(json_encode($this->model->getSVHHP()));
    }

    /**
     * Hàm lấy thông tin sinh viên từ file excel và thêm vào CSDL.
     */
    function getStudentExcel() {
        if (isset($_POST['ImportStudent'])) { // Kiểm tra xem có phải là nhập sinh viên vào không
            $file = $_FILES['file']['tmp_name']; // Lấy file
            $sheetData = getExcelReturnData($file); // Lấy dữ liệu từ file excel

            // Preprocess dữ liệu
            // Kiểm tra xem số cột có phải là 6 không
            $numberOfColumn = sizeof($sheetData[1]); // Số cột của excel
            if ($numberOfColumn != 6) { // Nếu số cột khác 6
                echo $this->createAlert("File không đúng định dạng. Vui lòng thử lại.");
                return;
            }
            // Số cột là 6
            // Kiểm tra hàng đầu, tên các cột
            // Cột 1
            $temp = $sheetData[1]['A']; // Khởi tạo cột
            $temp = preg_replace('/\s+/', '', $temp); // Xóa các ký tự trắng thừa
            if ($temp != "id") { // Nếu tên cột 1 không phải là id
                echo $this->createAlert("File không đúng định dạng. Tên cột 1 phải là id.");
                return;
            }
            // Cột 2
            $temp = $sheetData[1]['B'];
            $temp = preg_replace('/\s+/', '', $temp); // Xóa các ký tự trắng thừa
            if ($temp != "hodem") { // Nếu tên cột 2 không phải là hodem
                echo $this->createAlert("File không đúng định dạng. Tên cột 2 phải là hodem.");
                return;
            }
            // Cột 3
            $temp = $sheetData[1]['C'];
            $temp = preg_replace('/\s+/', '', $temp); // Xóa các ký tự trắng thừa
            if ($temp != "ten") {
                echo $this->createAlert("File không đúng định dạng. Tên cột 3 phải là ten.");
                return;
            }
            // Cột 4
            $temp = $sheetData[1]['D'];
            $temp = preg_replace('/\s+/', '', $temp); // Xóa các ký tự trắng thừa
            if ($temp != "ngaysinh") {
                echo $this->createAlert("File không đúng định dạng. Tên cột 4 phải là ngaysinh.");
                return;
            }
            // Cột 5
            $temp = $sheetData[1]['E'];
            $temp = preg_replace('/\s+/', '', $temp); // Xóa các ký tự trắng thừa
            if ($temp != "account") {
                echo $this->createAlert("File không đúng định dạng. Tên cột 5 phải là account.");
                return;
            }
            // Cột 6
            $temp = $sheetData[1]['F'];
            $temp = preg_replace('/\s+/', '', $temp); // Xóa các ký tự trắng thừa
            if ($temp != "password") {
                echo $this->createAlert("File không đúng định dạng. Tên cột 6 phải là password.");
                return;
            }

            // Thêm dữ liệu vào CSDL.
            // Tạo mảng để báo lỗi trong javascript
            $has_error = 0; // Nếu có lỗi khi thêm vào CSDL thì sẽ bằng 1
            $missing_data = 0; // Nếu có lỗi thiếu dữ liệu thì sẽ bằng 1
            $date_error = 0; // Nếu sai định dạng ngày thì sẽ bằng 1
            $other_data_error = 0; // Nếu có lỗi khác thì sẽ bằng 1

            // Kiểm tra dữ liệu
            for($row = 2 ; $row <= sizeof($sheetData) ; $row ++) { // Chạy vòng lặp qua từng dòng từ dòng thứ 2 trở đi
                // Kiểm tra mssv
                $id = $sheetData[$row]['A'];
                // Xóa các ký tự whitespace
                $id = preg_replace('/\s+/', '', $id);
                if ($id == "null") { // Nếu trống ID
                    $missing_data = 1;
                    $has_error = 1;
                }
                if (!ctype_digit($id)) { // Nếu ID không chứa mỗi số
                    $other_data_error = 1;
                    $has_error = 1;
                }
                if (strlen($id) > 20){ // Nếu ID dài hơn giới hạn của CSDL
                    $other_data_error = 1;
                    $has_error = 1;
                }
                // Kiểm tra họ đệm
                $hodem = $sheetData[$row]['B'];
                if ($hodem == "null") { // Nếu trống họ đệm
                    $missing_data = 1;
                    $has_error = 1;
                }
                if(strlen($hodem) > 50){ // Nếu họ đệm dài hơn giới hạn của CSDL
                    $other_data_error = 1;
                    $has_error = 1;
                }
                // Kiểm tra tên
                $ten = $sheetData[$row]['C'];
                // Xóa các ký tự whitespace
                $ten = preg_replace('/\s+/', '', $ten);
                if ($ten == "null") { // Nếu trống tên
                    $missing_data = 1;
                    $has_error = 1;
                }
                if (strlen($ten) > 50) { // Nếu tên dài hơn giới hạn của CSDL
                    $other_data_error = 1;
                    $has_error = 1;
                }
                // Kiểm tra ngày sinh
                $ngaysinh = $sheetData[$row]['D'];
                // Xóa các ký tự whitespace
                $ngaysinh = preg_replace('/\s+/', '', $ngaysinh);
                if ($ngaysinh == "null") { // Nếu trống ngày sinh
                    $missing_data = 1;
                    $has_error = 1;
                }
                if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$ngaysinh)) { // Nếu không đúng format ngày (YYYY-MM-DD)
                    $date_error = 1;
                    $has_error = 1;
                }
                // Kiểm tra acccount
                $account = $sheetData[$row]['E']; // this is ignored
                // Xóa các ký tự whitespace
                $account = preg_replace('/\s+/', '', $account);
                if ($account == "null") { // Nếu trống account
                    $missing_data = 1;
                    $has_error = 1;
                }
                if (!ctype_digit($account)) { // Nếu account không chứa mỗi số
                    $other_data_error = 1;
                    $has_error = 1;
                }
                if (strlen($account) > 20){ // Nếu account dài hơn giới hạn của CSDL
                    $other_data_error = 1;
                    $has_error = 1;
                }
                // Kiểm tra password
                $pass = $sheetData[$row]['F'];
                if ($pass == "null") { // Néu trống password
                    $missing_data = 1;
                    $has_error = 1;
                }
            }

            // Thêm thông tin vào CSDL nếu không có lỗi
            if($has_error == 0){
                for($row = 2 ; $row <= sizeof($sheetData) ; $row ++) { // Chạy vòng lặp qua từng dòng từ dòng thứ 2 trở đi
                    $id = $sheetData[$row]['A'];
                    $hodem = $sheetData[$row]['B'];
                    $ten = $sheetData[$row]['C'];
                    $ngaysinh = $sheetData[$row]['D'];
                    $account = $sheetData[$row]['E'];
                    $pass = $sheetData[$row]['F'];
                    $id = preg_replace('/\s+/', '', $id); // Xóa các ký tự trắng thừa
                    $ten = preg_replace('/\s+/', '', $ten); // Xóa các ký tự trắng thừa
                    $ngaysinh = preg_replace('/\s+/', '', $ngaysinh); // Xóa các ký tự trắng thừa
                    $account = preg_replace('/\s+/', '', $account); // Xóa các ký tự trắng thừa
                    $stmt = $this->model->getIDOnly($id);
                    if (count($stmt) > 0) { // Nếu mssv đã tồn tại
                        $this->model->updateStudentInfo($id, $hodem, $ten, $ngaysinh); // Cập nhật thông tin của sinh viên
                        $this->model->UpdateAccount($pass, $id); // Cập nhật password
                    } else{ // Nếu mssv chưa tồn tại
                        $this->model->addStudentData($id, $hodem, $ten, $ngaysinh); // Thêm thông tin sinh viên mới
                        $this->model->createStudentAccount($pass, $id); // Tạo tài khoản cho sinh viên
                    }
                }
                echo $this->createAlert("Tải lên thành công.");
            }
            else { // Nếu lỗi thì sẽ cảnh báo theo từng trường hợp
                $execute = 0;
                if($date_error == 1){
                    $execute = 1;
                }
                if($missing_data == 1){
                    $execute = 2;
                }
                if($other_data_error == 1){
                    $execute = 3;
                }
                if($date_error == 1 && $missing_data == 1){
                    $execute = 12;
                }
                if($date_error == 1 && $other_data_error == 1){
                    $execute = 13;
                }
                if($missing_data == 1 && $other_data_error == 1){
                    $execute = 23;
                }
                if($missing_data == 1 && $other_data_error == 1 && $date_error == 1){
                    $execute = 123;
                }
                switch ($execute) {
                    case 1:
                        echo $this->createAlert("The file appears to have wrong date format in some data");
                        break;
                    case 2:
                        echo $this->createAlert("The file appears to have empty/null data");
                        break;
                    case 3:
                        echo $this->createAlert("The file appears to have other error");
                        break;
                    case 12:
                        echo $this->createAlert("The file appears to have empty/null data and wrong date format in some data");
                        break;
                    case 13:
                        echo $this->createAlert("The file appears to have wrong data format and wrong data format in some data");
                        break;
                    case 23:
                        echo $this->createAlert("The file appears to have empty/null data and wrong data format in some data");
                        break;
                    case 123:
                        echo $this->createAlert("The file appears to have empty/null data , wrong data format and wrong date format in some data");
                        break;
                }
            }
        }
    }

    /**
     * Cập nhật trạng thái đủ điều kiện dự thi của sinh viên
     */
    function updateDisqualified() {
        if (isset($_POST['UpdateDis'])) {
            $file = $_FILES['file']['tmp_name']; // Lấy file
            $sheetData = getExcelReturnData($file); // Lấy dữ liệu từ file excel
            // Tiền xử lý
            $has_error = 0 ;
            $missing_data = 0;
            $wrong_format = 0;
            $numberOfColumn = sizeof($sheetData[1]); // Số cột của file
            if($numberOfColumn != 2){ // Nếu số cột không phải là 2
                echo $this->createAlert("File không đúng định dạng. Vui lòng thử lại.");
                return;
            }
            // Kiểm tra hàng đầu cột 1
            $temp = $sheetData[1]['A'];
            // Xóa ký tự trắng
            $temp = preg_replace('/\s+/', '', $temp);
            if($temp != "id"){ // Nếu không phải là id
                echo $this->createAlert("File không đúng định dạng. Cột đầu phải là id");
                return;
            }
            // Kiểm tra cột 2
            $temp = $sheetData[1]['B'];
            // Xóa ký tự trắng
            $temp = preg_replace('/\s+/', '', $temp);
            if($temp != "qualification"){
                echo $this->createAlert("File không đúng định dạng. Cột 2 phải là qualification");
                return;
            }

            // Kiểm tra dữ liệu
            for($row = 2 ; $row <= sizeof($sheetData) ; $row ++){ // Chạy vòng lặp qua từng dòng từ dòng thứ 2 trở đi
                // Kiểm tra mssv
                $idsinhvien = $sheetData[$row]['A'];
                // Xóa ký tự trắng
                $idsinhvien = preg_replace('/\s+/', '', $idsinhvien);
                if($idsinhvien == "null"){ // Nếu trống
                    $has_error = 1;
                    $missing_data = 1;
                }
                if(strlen($idsinhvien) > 20){ // Nếu quá dài
                    $has_error = 1;
                    $wrong_format = 1;
                }
                if(!ctype_digit($idsinhvien)){ // Nếu chứa các ký tự khác số
                    $wrong_format= 1;
                    $has_error = 1;
                }
                // Kiểm tra đủ điều kiện dự thi
                $qualification = $sheetData[$row]['B'];
                // Xóa ký tự trắng
                $qualification = preg_replace('/\s+/', '', $qualification);
                if($qualification == "null"){ // Nếu trống
                    $has_error = 1;
                    $missing_data = 1;
                }
                if(strlen($qualification) > 20){ // Nếu quá dài
                    $has_error = 1;
                    $wrong_format = 1;
                }
                if($qualification == "1" || $qualification == "0" || $qualification == 1 ||$qualification == 0){
                    // Nếu đúng định dạng thì tiếp tục
                    continue;
                } else { // Nếu sai định dạng
                    $has_error = 1;
                    $wrong_format = 1;
                }
            }
            // Nếu có lỗi
            if($has_error == 1){
                $execute = 0; //what to do
                if($missing_data == 1){
                    $execute = 1;
                }
                if($wrong_format == 1){
                    $execute = 2;
                }
                if($missing_data == 1 && $wrong_format == 1){
                    $execute = 12;
                }
                switch ($execute) {
                    case 1:
                        echo $this->createAlert("File có dữ liệu trống.");
                        break;
                    case 2:
                        echo $this->createAlert("File có dữ liệu sai định dạng.");
                        break;
                    case 12:
                        echo $this->createAlert("File có dữ liệu trống và dữ liệu sai định dạng.");
                        break;
                }
            } else { // Nếu không có lỗi
                for($row = 2 ; $row <= sizeof($sheetData) ; $row ++){ // Chạy vòng lặp qua từng dòng từ dòng thứ 2 trở đi
                    $idsinhvien = $sheetData[$row]['A'];
                    $qualification = $sheetData[$row]['B'];
                    $this->model->updateDisqualifiedStudent($idsinhvien,$qualification);
                }
                echo $this->createAlert("Cập nhật thành công.");
            }
        }
    }

    /**
     * Cập nhật sinh viên học học phần ở học kỳ nào
     */
    function updateCourseSem() {
        if(isset($_POST["UpdateCourses"])){ // Nếu là cập nhật sinh viên học học phần ở học kỳ
            $file = $_FILES['file']['tmp_name']; // Lấy file
            $sheetData = getExcelReturnData($file); // Lấy dữ liệu từ file

            // Preprocess dữ liệu
            $numberOfColumn = sizeof($sheetData[1]); // Số cột của file
            if ($numberOfColumn != 3){ // Nếu số cột khác 3
                echo $this->createAlert("File không đúng định dạng. Vui lòng thử lại.");
                return;
            }
            // Kiểm tra hàng đầu, tên các cột
            // Cột 1
            $temp = $sheetData[1]['A'];
            // Xóa các ký tự trắng
            $temp = preg_replace('/\s+/', '', $temp);
            if($temp != "idSV"){ // Nếu tên cột không đúng
                echo $this->createAlert("File không đúng định dạng. Tên cột 1 phải là id.");
                return;
            }
            // Cột 2
            $temp = $sheetData[1]['B'];
            // Xóa các ký tự trắng thừa
            $temp = preg_replace('/\s+/', '', $temp);
            if($temp != "courseID"){ // Nếu tên cột không đúng
                echo $this->createAlert("File không đúng định dạng. Tên cột 2 phải là courseID.");
                return ;
            }
            // Cột 3
            $temp = $sheetData[1]['C'];
            // Xóa các ký tự trắng thừa
            $temp = preg_replace('/\s+/', '', $temp);
            if($temp != "termID"){ // Nếu tên cột không đúng
                echo $this->createAlert("File không đúng định dạng. Tên cột 3 phải là termID.");
                return;
            }

            // Thêm dữ liệu vào CSDL.
            // Tạo mảng để báo lỗi trong javascript
            $has_error = 0; // Nếu có lỗi khi thêm vào CSDL thì sẽ bằng 1
            $wrong_format = 0; // Nếu sai định dạng thì sẽ bằng 1
            $missing_data = 0; // Nếu có lỗi thiếu dữ liệu thì sẽ bằng 1
            // Kiểm tra dữ liệu
            for($row = 2 ; $row <= sizeof($sheetData) ; $row ++){ // Chạy vòng lặp qua từng dòng từ dòng thứ 2 trở đi
                $id = $sheetData[$row]['A'];
                $courseID = $sheetData[$row]['B'];
                $kythi = $sheetData[$row]['C'];
                // Xóa hết ký tự trắng thừa
                $id = preg_replace('/\s+/', '', $id);
                $courseID = preg_replace('/\s+/', '', $courseID);
                $kythi = preg_replace('/\s+/', '', $kythi);

                if(!ctype_digit($id)) { // ID chứa ký tự khác số
                    $wrong_format = 1;
                    $has_error = 1;
                }
                if(!ctype_digit($kythi)) { // ID kỳ thi chứa ký tự khác số
                    $wrong_format = 1;
                    $has_error = 1;
                }
                if(strlen($id) > 20) { // ID sinh viên quá dài
                    $wrong_format = 1;
                    $has_error = 1;
                }
                if(strlen($courseID)>20) { // Mã học phần quá dài
                    $wrong_format = 1;
                    $has_error = 1;
                }
                if(strlen($kythi)>11) { // Mã kỳ thi quá dài
                    $wrong_format = 1;
                    $has_error = 1;
                }
                if ($id == "null") { // MSSV rỗng
                    $missing_data = 1;
                    $has_error = 1;
                }
                if($courseID == "null"){ // Mã học phần rỗng
                    $missing_data = 1;
                    $has_error = 1;
                }
                if($kythi == "null"){ // Mã kỳ thi rỗng
                    $missing_data = 1;
                    $has_error = 1;
                }
            }
            if($has_error == 1){ // Nếu có lỗi
                $execute = 0;
                if($missing_data == 1){
                    $execute = 1;
                }
                if($wrong_format == 1){
                    $execute = 2;
                }
                if($missing_data == 1 && $wrong_format == 1){
                    $execute = 12;
                }
                switch ($execute) {
                    case 1:
                        echo $this->createAlert("File có dữ liệu trống.");
                        break;
                    case 2:
                        echo $this->createAlert("File có dữ liệu sai định dạng.");
                        break;
                    case 12:
                        echo $this->createAlert("File có dữ liệu trống và dữ liệu sai định dạng.");
                        break;
                }
            } else { // Nếu không có lỗi
                for($row = 2 ; $row <= sizeof($sheetData) ; $row ++){ // Chạy vòng lặp qua từng dòng từ dòng thứ 2 trở đi
                    $id = $sheetData[$row]['A'];
                    $courseID = $sheetData[$row]['B'];
                    $kythi = $sheetData[$row]['C'];
                    $arr_sinhvien = $this->model->getIDOnly($id); // Kiểm tra xem sinh viên có tồn tại không
                    $arr_hocphan = $this->model->getSubjectID($courseID); // Kiểm tra xem mã học phần có tồn tại không
                    $arr_maky = $this->model->getTerm($kythi);
                    if(count($arr_hocphan)>0 && count($arr_sinhvien)>0 && count($arr_maky)>0) { // Kiểm tra xem các thứ có tồn tại không
                        $this->model->updateCourse($id, $courseID, $kythi);
                    }
                }
                echo $this->createAlert("Cập nhật thành công.");
                return;
            }
        }
    }

    /**
     * Hàm xóa sinh viên.
     */
    function DeleteStudent() {
        if(isset($_POST["DeleteStudent"])){ // Nếu là xóa sinh viên
            $file = $_FILES['file']['tmp_name']; // Lấy file
            $sheetData = getExcelReturnData($file); // Lấy dữ liệu từ excel

            // Preprocess dữ liệu
            $collumnNumber = sizeof($sheetData[1]); // Lấy số cột từ excel
            if($collumnNumber != 1){ // Nếu số cột khác 1
                echo $this->createAlert("File không đúng định dạng. Vui lòng thử lại.");
                return;
            }
            // Kiểm tra hàng đầu, tên các cột
            // Cột 1
            $temp = $sheetData[1]['A'];
            // Xóa các ký tự trắng
            $temp = preg_replace('/\s+/', '', $temp);
            if($temp != "id"){
                echo $this->createAlert("File không đúng định dạng. Tên cột 1 phải là id.");
                return;
            }

            for($row = 2 ; $row <= sizeof($sheetData) ; $row ++){ // Chạy vòng lặp qua từng dòng từ dòng thứ 2 trở đi
                $temp = $sheetData[$row]['A'];
                // Xóa các ký tự trắng
                $temp = preg_replace('/\s+/', '', $temp);
                if(!ctype_digit($temp)){ // ID chứa ký tự khác số
                    echo $this->createAlert("File có dữ liệu sai định dạng.");
                    return;
                }
            }

            for($row = 2 ; $row <= sizeof($sheetData) ; $row ++){ // Chạy vòng lặp qua từng dòng từ dòng thứ 2 trở đi
                $id = $sheetData[$row]['A'];
                $this->model->deleteStudentWID($id);
            }
            echo $this->createAlert("Đã xóa các sinh viên trong danh sách.");
        }
    }

    /**
     * Xóa sinh viên học học phần
     */
    function deleteCourse(){
        if(isset($_POST["DeleteCourse"])){ // Nếu là xóa sinh viên học học phần
            $sinhvien = $_POST["sinhvienID"]; // Mã số sinh viên
            $hocphan = $_POST["courseID"]; // Mã học phần
            $hocky = $_POST["semID"]; // Mã kỳ thi
            $this->model->deleteCourseHK($sinhvien,$hocphan,$hocky);
        }
    }

    /**
     * Tạo cảnh báo.
     * @param $message: Lời cảnh báo.
     * @return string: Javascript.
     */
    private function createAlert($message) {
        return $this->view->alert($message);
    }
}