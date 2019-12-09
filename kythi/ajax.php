<?php
    require_once dirname(__FILE__)."/../account/controller/LogoutController.php";
    session_start();
    if($_SESSION["isAdmin"] != 1){ // Kiểm tra xem có phải là admin không. Nếu không phải thì logout ra ngoài
        header("Location:http://examreg.com/account/view/LogoutView.php");
    }

    require_once dirname(__FILE__)."/controller/KythiController.php";
    require_once dirname(__FILE__)."/../utils/Utils.php";

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
        if (isset($_POST["add"]) && $_POST["add"] == 1 && isset($_POST["nambatdau"]) && !empty($_POST["nambatdau"])
        && isset($_POST["namketthuc"]) && !empty($_POST["namketthuc"]) && isset($_POST["ky"]) && !empty($_POST["ky"])) { // Kiểm tra xem có phải add không
            if (is_numeric($_POST["nambatdau"]) && $_POST["nambatdau"] >= 1900 && $_POST["nambatdau"] <= 2099 && is_numeric($_POST["namketthuc"]) && $_POST["namketthuc"] >= 1900 && $_POST["namketthuc"] <= 2099
                && is_numeric($_POST["ky"]) && $_POST["ky"] >= 1 && $_POST["nambatdau"] <= $_POST["namketthuc"]) { // Kiểm tra xem độ lớn và kiểu dữ liệu có thỏa mãn không
                $count = $kythictrl->add($_POST["nambatdau"], $_POST["namketthuc"], $_POST["ky"]); // Đếm số bản ghi được cập nhật
                if ($count == 1) { // Thành công nếu có 1 bản ghi được thêm.
                    $res->success_msg = "Kỳ thi được thêm thành công.";
                } else { // Thất bại nếu không có bản ghi nào được thêm.
                    $res->error_msg = "Có lỗi. Kỳ thi có thể đã tồn tại trong hệ thống.";
                }
            } else {
                $res->error_msg = "Có lỗi. Năm bắt đầu, năm kết thúc và kỳ phải là số. 1900 <= năm kết thúc, năm bắt đầu <= 2099. Kỳ >= 1.";
            }
        } elseif (isset($_POST["delete"]) && isset($_POST["makythi"]) && !empty($_POST["makythi"]) && $_POST["delete"] == 1) { // Kiểm tra xem có phải delete không
            if (is_numeric($_POST["makythi"]) && checkInteger($_POST["makythi"]) && $_POST["makythi"] >= 1) { // Kiểm tra xem kiểu dữ liệu có thỏa mãn không
                $count = $kythictrl->delete($_POST["makythi"]);
                if ($count == 1) { // Thành công nếu có 1 bản ghi được xóa.
                    $res->success_msg = "Kỳ thi đã được xóa.";
                } else { // Thất bại nếu không có bản ghi nào được xóa.
                    $res->error_msg = "Kỳ thi không tồn tại trong hệ thống.";
                }
            } else {
                $res->error_msg = "Có lỗi. Mã kỳ thi phải là một số nguyên lớn hơn 0.";
            }
        } elseif (isset($_POST["edit"]) && $_POST["edit"] == 1 && isset($_POST["makythi"]) && isset($_POST["nambatdau"]) && isset($_POST["namketthuc"])
        && isset($_POST["ky"]) && !empty($_POST["makythi"]) && !empty($_POST["nambatdau"]) && !empty($_POST["namketthuc"]) && !empty($_POST["ky"])) { // Kiểm tra xem có phải edit không
            if (is_numeric($_POST["nambatdau"]) && checkInteger($_POST["nambatdau"]) && $_POST["nambatdau"] >= 1900 && $_POST["nambatdau"] <= 2099
            && is_numeric($_POST["namketthuc"]) && checkInteger($_POST["namketthuc"]) && $_POST["namketthuc"] >= 1900 && $_POST["namketthuc"] <= 2099
            && is_numeric($_POST["ky"]) && checkInteger($_POST["ky"]) && $_POST["ky"] >= 1 && $_POST["nambatdau"] <= $_POST["namketthuc"]
            && is_numeric($_POST["makythi"]) && checkInteger($_POST["makythi"]) && $_POST["makythi"] > 0) { // Kiểm tra xem độ dài data và kiểu dữ liệu có thỏa mãn không
                $count = $kythictrl->edit($_POST["makythi"], $_POST["nambatdau"], $_POST["namketthuc"], $_POST["ky"]); // Đếm số bản ghi được cập nhật
                if ($count == 1) { // Thành công nếu có 1 bản ghi được thêm.
                    $res->success_msg = "Kỳ thi đã được sửa thành công.";
                } else { // Thất bại nếu không có bản ghi nào được thêm.
                    $res->error_msg = "Có lỗi. Mã kỳ thi cũ có thể không tồn tại trong hệ thống hoặc kỳ thi mới đã có trong hệ thống.";
                }
            } else {
                $res->error_msg = "Có lỗi. Mã kỳ thi phải là một số nguyên lớn hơn 0. Năm bắt đầu, năm kết thúc và kỳ phải là số. 1900 <= năm kết thúc, năm bắt đầu <= 2099. Kỳ >= 1.";
            }
        }
        echo json_encode($res);
    } else { // Method request ngoài GET và POST
        $res = new stdClass();
        $res->error_msg = 'Unknown';
        echo json_encode($res);
}