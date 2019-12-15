<?php
    session_start();
    if($_SESSION["isAdmin"] != 1){
        header("Location:http://examreg.com/");
    }

    header("Content-type:application/json"); // Set kiểu trả về dưới dạng JSON
    require_once dirname(__FILE__)."/controller/MonthiController.php";
    require_once dirname(__FILE__)."/../utils/Utils.php";
    $monthictrl = new \monthi\controller\MonthiController();
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $res = new stdClass(); // Chứa response
        $hash = hash('sha256', $monthictrl->table());
        if (isset($_GET['danhsachmonthi']) && $_GET['danhsachmonthi'] == 1) { // Client yêu cầu gửi danh sách môn thi
            $res->monthi = $monthictrl->datalist();
        } else if (!isset($_GET['hash']) || $_GET['hash'] != $hash) { // Client kiểm tra xem hash của client có trùng server không. Nếu không trùng, server trả về bảng, datalist và hash mới.
            $res->table = $monthictrl->table();
            $res->datalist = $monthictrl->datalist();
            $res->hash = $hash;
        } else if (isset($_GET['hash']) && $_GET['hash'] == $hash) { // Nếu trùng hash, chỉ trả về hash
            $res->hash = $hash;
        }

        echo json_encode($res);
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $res = new stdClass();
        if (isset($_POST["add"]) && isset($_POST["mamonthi"]) && isset($_POST["tenmonthi"]) && isset($_POST["tinchi"])
        && !empty($_POST["mamonthi"]) && !empty($_POST["tenmonthi"]) && !empty($_POST["tinchi"]) && $_POST["add"] == 1) { // Kiểm tra xem có phải add không
            if (is_numeric($_POST["tinchi"]) && checkInteger($_POST["tinchi"]) && $_POST["tinchi"] >= 1 && strlen($_POST["tenmonthi"]) >= 1 && strlen($_POST["tenmonthi"]) <= 100
            && strlen($_POST["mamonthi"]) >= 1 && strlen($_POST["mamonthi"]) <= 20) { // Kiểm tra xem độ dài và kiểu dữ liệu có thỏa mãn không
                // Kiểm tra regex
                if (preg_match("/^\b[a-zA-Z0-9]+\b$/", $_POST["mamonthi"])) {
                    $count = $monthictrl->add($_POST["mamonthi"], $_POST["tenmonthi"], $_POST["tinchi"]); // Đếm số bản ghi được cập nhật
                    if ($count == 1) { // Thành công nếu có 1 bản ghi được thêm.
                        $res->success_msg = "Môn học được thêm thành công.";
                    } else { // Thất bại nếu không có bản ghi nào được thêm.
                        $res->error_msg = "Có lỗi. Môn học có thể đã tồn tại trong hệ thống.";
                    }
                }
                else {
                    $res->error_msg = "Có lỗi. Mã môn học chỉ được phép là 1 từ chứa ký tự từ a-z, A-Z, 0-9.";
                }
            } else { // Không thỏa mãn
                $res->error_msg = "Đã xảy ra lỗi. Vui lòng thử lại.";
            }
        } elseif (isset($_POST["delete"]) && isset($_POST["mamonthi"]) && !empty($_POST["mamonthi"]) && $_POST["delete"] == 1) { // Kiểm tra xem có phải delete không
            if (strlen($_POST["mamonthi"]) >= 1 && strlen($_POST["mamonthi"]) <= 20) { // Kiểm tra xem độ dài data có thỏa mãn không
                if (preg_match("/^\b[a-zA-Z0-9]+\b$/", $_POST["mamonthi"])) {
                    $count = $monthictrl->delete($_POST["mamonthi"]);
                    if ($count == 1) { // Thành công nếu có 1 bản ghi được xóa.
                        $res->success_msg = "Môn học đã được xóa.";
                    } else { // Thất bại nếu không có bản ghi nào được xóa.
                        $res->error_msg = "Môn học không tồn tại trong hệ thống.";
                    }
                } else {
                    $res->error_msg = "Có lỗi. Mã môn học chỉ được phép là 1 từ chứa ký tự từ a-z, A-Z, 0-9.";
                }
            } else { // Không thỏa mãn
                $res->error_msg = "Đã xảy ra lỗi. Vui lòng thử lại.";
            }
        } elseif (isset($_POST["edit"]) && isset($_POST["mamonthicu"]) && isset($_POST["mamonthi"]) && isset($_POST["tenmonthi"])
        && isset($_POST["tinchi"]) && $_POST["edit"] == 1) { // Kiểm tra xem có phải edit không
            if (is_numeric($_POST["tinchi"]) && strlen($_POST["tenmonthi"]) >= 1 && strlen($_POST["tenmonthi"]) <= 100
                && strlen($_POST["mamonthi"]) >= 1 && strlen($_POST["mamonthi"]) <= 20 && strlen($_POST["mamonthicu"]) >= 1 && strlen($_POST["mamonthicu"]) <= 20) { // Kiểm tra xem độ dài data và kiểu dữ liệu có thỏa mãn không
                if (preg_match("/^\b[a-zA-Z0-9]+\b$/", $_POST["mamonthicu"]) && preg_match("/^\b[a-zA-Z0-9]+\b$/", $_POST["mamonthi"])) {
                    $count = $monthictrl->edit($_POST["mamonthicu"], $_POST["mamonthi"], $_POST["tenmonthi"], $_POST["tinchi"]); // Đếm số bản ghi được cập nhật
                    if ($count == 1) { // Thành công nếu có 1 bản ghi được thêm.
                        $res->success_msg = "Môn học được sửa thành công.";
                    } else { // Thất bại nếu không có bản ghi nào được thêm.
                        $res->error_msg = "Có lỗi. Mã môn học cũ có thể không tồn tại trong hệ thống hoặc mã môn học mới đã có trong hệ thống.";
                    }
                } else {
                    $res->error_msg = "Có lỗi. Mã môn học cũ/mới chỉ được phép là 1 từ chứa ký tự từ a-z, A-Z, 0-9.";
                }
            } else { // Không thỏa mãn
                $res->error_msg = "Đã xảy ra lỗi. Vui lòng thử lại.";
            }
        }
        echo json_encode($res);
    } else {
        $res = new stdClass();
        $res->error_msg = 'Unknown';
        echo json_encode($res);
    }