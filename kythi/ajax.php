<?php
    session_start();
    if($_SESSION["isAdmin"] != 1){ // Kiểm tra xem có phải là admin không. Nếu không phải thì logout ra ngoài
        header("Location:http://examreg.com/");
    }

    header("Content-type:application/json"); // Set kiểu trả về dưới dạng JSON
    require_once dirname(__FILE__)."/controller/KythiController.php";
    require_once dirname(__FILE__)."/../utils/Utils.php";

    /**
     * Hàm kiểm tra ngày xem có đúng định dạng (YYYY-MM-DD) và ngày có hợp lệ không
     * @param $date: Ngày
     * @return bool
     */
    function isDate($date) {
        $format = "Y-m-d";
        if (date($format, strtotime($date)) == date($date)) {
            return true;
        } else {
            return false;
        }
    }

    $kythictrl = new \kythi\controller\KythiController();
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $res = new stdClass(); // Chứa response
        $hash = hash('sha256', $kythictrl->table());
        if (isset($_GET['danhsachkythi']) && $_GET['danhsachkythi'] == 1) { // Chỉ lấy danh sách kỳ thi
            $res->kythi = $kythictrl->datalist();
        } else if (!isset($_GET['hash']) || $_GET['hash'] != $hash) { // Lấy bảng, datalist, hash khi khác hash
            $res->table = $kythictrl->table();
            $res->datalist = $kythictrl->datalist();
            $res->hash = $hash;
        } else if (isset($_GET['hash']) && $_GET['hash'] == $hash) { // Trả về hash khi trùng hash
            $res->hash = $hash;
        }

        echo json_encode($res);
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $res = new stdClass();
        if (isset($_POST["add"]) && $_POST["add"] == 1) { // Nếu là add
            if (!isset($_POST["nambatdau"]) || empty($_POST["nambatdau"])) { // Trống năm bắt đầu
                $res->error_msg = "Năm bắt đầu không được để trống.";
            } elseif (!is_numeric($_POST["nambatdau"]) || !checkInteger($_POST["nambatdau"]) || $_POST["nambatdau"] < 1900 || $_POST["nambatdau"] > 2099) {
                $res->error_msg = "Năm bắt đầu phải là số thuộc đoạn [1900;2099].";
            } elseif (!isset($_POST["namketthuc"]) || empty($_POST["namketthuc"])) { // Trống năm kết thúc
                $res->error_msg = "Năm kết thúc không được để trống.";
            } elseif (!is_numeric($_POST["namketthuc"]) || !checkInteger($_POST["namketthuc"]) || $_POST["namketthuc"] < 1900 || $_POST["namketthuc"] > 2099 || $_POST["nambatdau"] > $_POST["namketthuc"]) {
                $res->error_msg = "Năm kết thúc phải là số thuộc đoạn [1900;2099] và lớn hơn hoặc bằng năm bắt đầu.";
            } elseif (!isset($_POST["ky"]) || empty($_POST["ky"])) { // Trống kỳ
                $res->error_msg = "Kỳ không được để trống.";
            } elseif (!is_numeric($_POST["ky"]) || !checkInteger($_POST["ky"]) || $_POST["ky"] < 1) {
                $res->error_msg = "Kỳ phải là số nguyên dương.";
            } elseif (!isset($_POST["ngaybatdau"]) || empty($_POST["ngaybatdau"])) { // Trống ngày bắt đầu
                $res->error_msg = "Ngày bắt đầu không được để trống.";
            } elseif (strlen($_POST["ngaybatdau"]) != 10 || !isDate($_POST["ngaybatdau"])) {
                $res->error_msg = "Ngày bắt đầu phải là ngày theo định dạng YYYY-MM-DD.";
            } elseif (!isset($_POST["ngayketthuc"]) || empty($_POST["ngayketthuc"])) { // Trống ngày kết thúc
                $res->error_msg = "Ngày kết thúc không được để trống.";
            } elseif (strlen($_POST["ngayketthuc"]) != 10 || !isDate($_POST["ngayketthuc"])) {
                $res->error_msg = "Ngày kết thúc phải là ngày theo định dạng YYYY-MM-DD.";
            } elseif ($_POST["ngaybatdau"] > $_POST["ngayketthuc"]) {
                $res->error_msg = "Ngày bắt đầu không được quá ngày kết thúc.";
            } else {
                $nambatdau = $_POST["nambatdau"];
                $ngaybatdaumin = $nambatdau."-01-01";
                $namketthuc = $_POST["namketthuc"];
                $ngayketthucmax = $namketthuc."-12-31";
                $ky = $_POST["ky"];
                $ngaybatdau = $_POST["ngaybatdau"];
                $ngayketthuc = $_POST["ngayketthuc"];
                // Kiểm tra xem ngày bắt đầu/kết thúc thi có nằm trong năm bắt đầu và năm kết thúc không
                if ($ngaybatdaumin <= $ngaybatdau && $ngaybatdaumin <= $ngayketthuc && $ngaybatdau <= $ngayketthucmax && $ngayketthuc <= $ngayketthucmax) {
                    $count = $kythictrl->add($nambatdau, $namketthuc, $ky, $ngaybatdau, $ngayketthuc); // Đếm số bản ghi được cập nhật
                    if ($count == 1) { // Thành công nếu có 1 bản ghi được thêm.
                        $res->success_msg = "Kỳ thi được thêm thành công.";
                    } else { // Thất bại nếu không có bản ghi nào được thêm.
                        $res->error_msg = "Có lỗi. Kỳ thi có thể đã tồn tại trong hệ thống.";
                    }
                } else {
                    $res->error_msg = "Ngày bắt đầu/kết thúc thi phải nằm trong năm bắt đầu và năm kết thúc.";
                }
            }
        } elseif (isset($_POST["delete"]) && $_POST["delete"] == 1) { // Nếu là delete
            if (!isset($_POST["makythi"]) || empty($_POST["makythi"])) { // Nếu trống mã kỳ thi
                $res->error_msg = "Mã kỳ thi không được để trống.";
            } elseif (!is_numeric($_POST["makythi"]) || !checkInteger($_POST["makythi"]) || $_POST["makythi"] < 1) {
                $res->error_msg = "Mã kỳ thi phải là số nguyên dương.";
            } else {
                $count = $kythictrl->delete($_POST["makythi"]);
                if ($count == 1) { // Thành công nếu có 1 bản ghi được xóa.
                    $res->success_msg = "Kỳ thi đã được xóa.";
                } else { // Thất bại nếu không có bản ghi nào được xóa.
                    $res->error_msg = "Kỳ thi không tồn tại trong hệ thống.";
                }
            }
        } elseif (isset($_POST["active"]) && $_POST["active"] == 1) { // Nếu là active
            if (!isset($_POST["makythi"]) || empty($_POST["makythi"])) { // Nếu trống mã kỳ thi
                $res->error_msg = "Mã kỳ thi không được để trống.";
            } elseif (!is_numeric($_POST["makythi"]) || !checkInteger($_POST["makythi"]) || $_POST["makythi"] < 1) {
                $res->error_msg = "Mã kỳ thi phải là số nguyên dương.";
            } else {
                $count = $kythictrl->setActive($_POST["makythi"]);
                if ($count == 1) { // Thành công nếu có 1 bản ghi được update.
                    $res->success_msg = "Kỳ thi ".$_POST["makythi"]." đã được chọn làm kỳ thi hiện tại.";
                } else { // Thất bại nếu không có bản ghi nào được update.
                    $res->error_msg = "Kỳ thi không tồn tại trong hệ thống.";
                }
            }
        } elseif (isset($_POST["edit"]) && $_POST["edit"] == 1) { // Nếu là edit
            if (!isset($_POST["makythi"]) || empty($_POST["makythi"])) { // Nếu trống mã kỳ thi
                $res->error_msg = "Mã kỳ thi không được để trống.";
            } elseif (!is_numeric($_POST["makythi"]) || !checkInteger($_POST["makythi"]) || $_POST["makythi"] < 1) {
                $res->error_msg = "Mã kỳ thi phải là số nguyên dương.";
            } elseif (!isset($_POST["nambatdau"]) || empty($_POST["nambatdau"])) { // Trống năm bắt đầu
                $res->error_msg = "Năm bắt đầu không được để trống.";
            } elseif (!is_numeric($_POST["nambatdau"]) || !checkInteger($_POST["nambatdau"]) || $_POST["nambatdau"] < 1900 || $_POST["nambatdau"] > 2099) {
                $res->error_msg = "Năm bắt đầu phải là số thuộc đoạn [1900;2099].";
            } elseif (!isset($_POST["namketthuc"]) || empty($_POST["namketthuc"])) { // Trống năm kết thúc
                $res->error_msg = "Năm kết thúc không được để trống.";
            } elseif (!is_numeric($_POST["namketthuc"]) || !checkInteger($_POST["namketthuc"]) || $_POST["namketthuc"] < 1900 || $_POST["namketthuc"] > 2099 || $_POST["nambatdau"] > $_POST["namketthuc"]) {
                $res->error_msg = "Năm kết thúc phải là số thuộc đoạn [1900;2099] và lớn hơn hoặc bằng năm bắt đầu.";
            } elseif (!isset($_POST["ky"]) || empty($_POST["ky"])) { // Trống kỳ
                $res->error_msg = "Kỳ không được để trống.";
            } elseif (!is_numeric($_POST["ky"]) || !checkInteger($_POST["ky"]) || $_POST["ky"] < 1) {
                $res->error_msg = "Kỳ phải là số nguyên dương.";
            } elseif (!isset($_POST["ngaybatdau"]) || empty($_POST["ngaybatdau"])) { // Trống ngày bắt đầu
                $res->error_msg = "Ngày bắt đầu không được để trống.";
            } elseif (strlen($_POST["ngaybatdau"]) != 10 || !isDate($_POST["ngaybatdau"])) {
                $res->error_msg = "Ngày bắt đầu phải là ngày theo định dạng YYYY-MM-DD.";
            } elseif (!isset($_POST["ngayketthuc"]) || empty($_POST["ngayketthuc"])) { // Trống ngày kết thúc
                $res->error_msg = "Ngày kết thúc không được để trống.";
            } elseif (strlen($_POST["ngayketthuc"]) != 10 || !isDate($_POST["ngayketthuc"])) {
                $res->error_msg = "Ngày kết thúc phải là ngày theo định dạng YYYY-MM-DD.";
            } elseif ($_POST["ngaybatdau"] > $_POST["ngayketthuc"]) {
                $res->error_msg = "Ngày bắt đầu không được quá ngày kết thúc.";
            } else {
                $makythi = $_POST["makythi"];
                $nambatdau = $_POST["nambatdau"];
                $ngaybatdaumin = $nambatdau."-01-01";
                $namketthuc = $_POST["namketthuc"];
                $ngayketthucmax = $namketthuc."-12-31";
                $ky = $_POST["ky"];
                $ngaybatdau = $_POST["ngaybatdau"];
                $ngayketthuc = $_POST["ngayketthuc"];
                // Kiểm tra xem ngày bắt đầu/kết thúc thi có nằm trong năm bắt đầu và năm kết thúc không
                if ($ngaybatdaumin <= $ngaybatdau && $ngaybatdaumin <= $ngayketthuc && $ngaybatdau <= $ngayketthucmax && $ngayketthuc <= $ngayketthucmax) {
                    $count = $kythictrl->edit($makythi, $nambatdau, $namketthuc, $ky, $ngaybatdau, $ngayketthuc); // Đếm số bản ghi được cập nhật
                    if ($count == 1) { // Thành công nếu có 1 bản ghi được thêm.
                        $res->success_msg = "Kỳ thi đã được sửa thành công.";
                    } else { // Thất bại nếu không có bản ghi nào được thêm.
                        $res->error_msg = "Có lỗi. Mã kỳ thi cũ có thể không tồn tại trong hệ thống hoặc kỳ thi mới đã có trong hệ thống.";
                    }
                } else {
                    $res->error_msg = "Ngày bắt đầu/kết thúc thi phải nằm trong năm bắt đầu và năm kết thúc.";
                }
            }
        } else {
            $res->error_msg = "Unknown.";
        }
        echo json_encode($res);
    } else { // Method request ngoài GET và POST
        $res = new stdClass();
        $res->error_msg = 'Unknown';
        echo json_encode($res);
}