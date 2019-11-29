<?php
    //TODO: implement session thing.

    require_once dirname(__FILE__)."/controller/MonthiController.php";
    $monthictrl = new \monthi\controller\MonthiController();
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $res = new stdClass();
        $res->table = $monthictrl->table();
        echo json_encode($res);
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $res = new stdClass();
        if (isset($_POST["add"]) && isset($_POST["mamonthi"]) && isset($_POST["tenmonthi"]) && isset($_POST["tinchi"])
        && !empty($_POST["mamonthi"]) && !empty($_POST["tenmonthi"]) && !empty($_POST["tinchi"]) && $_POST["add"] == 1) { // Kiểm tra xem có phải add không
            if (is_numeric($_POST["tinchi"]) && strlen($_POST["tenmonthi"]) >= 1 && strlen($_POST["tenmonthi"]) <= 100
            && strlen($_POST["mamonthi"]) >= 1 && strlen($_POST["mamonthi"]) <= 20) { // Kiểm tra xem độ dài data và kiểu dữ liệu có thỏa mãn không
                $count = $monthictrl->add($_POST["mamonthi"], $_POST["tenmonthi"], $_POST["tinchi"]); // Đếm số bản ghi được cập nhật
                if ($count == 1) { // Thành công nếu có 1 bản ghi được thêm.
                    $res->success_msg = "Môn học được thêm thành công.";
                } else { // Thất bại nếu không có bản ghi nào được thêm.
                    $res->error_msg = "Có lỗi. Môn học có thể đã tồn tại trong hệ thống.";
                }
            } else { // Không thỏa mãn
                $res->error_msg = "Đã xảy ra lỗi. Vui lòng thử lại.";
            }
        } elseif (isset($_POST["delete"]) && isset($_POST["mamonthi"]) && !empty($_POST["mamonthi"]) && $_POST["delete"] == 1) { // Kiểm tra xem có phải delete không
            if (strlen($_POST["mamonthi"]) >= 1 && strlen($_POST["mamonthi"]) <= 20) { // Kiểm tra xem độ dài data có thỏa mãn không
                $count = $monthictrl->delete($_POST["mamonthi"]);
                if ($count == 1) { // Thành công nếu có 1 bản ghi được xóa.
                    $res->success_msg = "Môn học đã được xóa.";
                } else { // Thất bại nếu không có bản ghi nào được xóa.
                    $res->error_msg = "Môn học không tồn tại trong hệ thống.";
                }
            } else { // Không thỏa mãn
                $res->error_msg = "Đã xảy ra lỗi. Vui lòng thử lại.";
            }
        } elseif (isset($_POST["edit"]) && isset($_POST["mamonthicu"]) && isset($_POST["mamonthi"]) && isset($_POST["tenmonthi"])
        && isset($_POST["tinchi"]) && $_POST["edit"] == 1) { // Kiểm tra xem có phải edit không
            if (is_numeric($_POST["tinchi"]) && strlen($_POST["tenmonthi"]) >= 1 && strlen($_POST["tenmonthi"]) <= 100
                && strlen($_POST["mamonthi"]) >= 1 && strlen($_POST["mamonthi"]) <= 20 && strlen($_POST["mamonthicu"]) >= 1 && strlen($_POST["mamonthicu"]) <= 20) { // Kiểm tra xem độ dài data và kiểu dữ liệu có thỏa mãn không
                $count = $monthictrl->edit($_POST["mamonthicu"], $_POST["mamonthi"], $_POST["tenmonthi"], $_POST["tinchi"]); // Đếm số bản ghi được cập nhật
                if ($count == 1) { // Thành công nếu có 1 bản ghi được thêm.
                    $res->success_msg = "Môn học được sửa thành công.";
                } else { // Thất bại nếu không có bản ghi nào được thêm.
                    $res->error_msg = "Có lỗi. Mã môn học cũ có thể không tồn tại trong hệ thống hoặc mã môn học mới đã có trong hệ thống.";
                }
            }
        }
        echo json_encode($res);
    } else {
        $res = new stdClass();
        $res->error_msg = 'Unknown';
        echo json_encode($res);
    }