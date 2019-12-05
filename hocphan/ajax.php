<?php
    // Kiểm tra session xem có phải là admin không. Nếu không thì logout.
    require_once dirname(__FILE__)."/../account/controller/LogoutController.php";
    session_start();
    if($_SESSION["isAdmin"] != 1){
        header("Location:http://examreg.com/account/view/LogoutView.php");
    }

    require_once dirname(__FILE__)."/controller/HocphanController.php";
    $hocphanctrl = new \hocphan\controller\HocphanController();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $res = new stdClass(); // Chứa response
        // Lấy bảng từ controller và hash lại để so sánh với hash client gửi lên
        $table = $hocphanctrl->table();
        $hash = hash('sha256', $table);
        if (!isset($_GET['hash']) || $_GET['hash'] != $hash) {
            // Nếu khác thì trả về hash và bảng
            $res->table = $hocphanctrl->table();
            $res->hash = $hash;
        } else if (isset($_GET['gethash']) && $_GET['gethash'] == 1) {
            // Nếu giống thì chỉ trả về hash
            $res->hash = $hash;
        }
        echo json_encode($res);
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $res = new stdClass(); // Chứa response
        if (isset($_POST["add"]) && isset($_POST["mamonthi"]) && isset($_POST["mahocphan"])
        && !empty($_POST["mamonthi"]) && !empty($_POST["mahocphan"]) && $_POST["add"] == 1) { // Kiểm tra xem có phải add không
            if (strlen($_POST["mahocphan"]) >= 1 && strlen($_POST["mahocphan"]) <= 20 && strlen($_POST["mamonthi"]) >= 1
            && strlen($_POST["mamonthi"]) <= 20) { // Kiểm tra xem độ dài data có thỏa mãn không
                if (preg_match("/^\b[a-zA-Z0-9]+\b$/", $_POST["mamonthi"])) { // Kiểm tra xem mã môn thi có thỏa mãn regex không
                    if (preg_match("/^\b".$_POST["mamonthi"]."\s[0-9]+\b$/", $_POST["mahocphan"])) { // Kiểm tra xem mã học phần có thỏa mãn regex không
                        $count = $hocphanctrl->add($_POST["mahocphan"], $_POST["mamonthi"]); // Đếm số bản ghi được cập nhật
                        if ($count == 1) { // Thành công nếu có 1 bản ghi được thêm.
                            $res->success_msg = "Học phần được thêm thành công.";
                        } else { // Thất bại nếu không có bản ghi nào được thêm.
                            $res->error_msg = "Có lỗi. Học phần có thể đã tồn tại trong hệ thống.";
                        }
                    } else {
                        $res->error_msg = "Có lỗi. Mã học phần phải bắt đầu bằng mã môn học theo sau bởi dấu cách và số lớp học phần.";
                    }
                } else {
                    $res->error_msg = "Có lỗi. Mã môn học chỉ được phép là 1 từ chứa ký tự từ a-z, A-Z, 0-9.";
                }
            } else { // Không thỏa mãn
                $res->error_msg = "Đã xảy ra lỗi. Vui lòng thử lại.";
            }
        } elseif (isset($_POST["delete"]) && isset($_POST["mahocphan"]) && !empty($_POST["mahocphan"])
        && $_POST["delete"] == 1) { // Kiểm tra xem có phải delete không
            if (strlen($_POST["mahocphan"]) >= 1 && strlen($_POST["mahocphan"]) <= 20) { // Kiểm tra xem độ dài data có thỏa mãn không
                if (preg_match("/^\b[a-zA-Z0-9]+\s[0-9]+\b$/", $_POST["mahocphan"])) { // Kiểm tra xem mã học phần có thỏa mãn regex không
                    $count = $hocphanctrl->delete($_POST["mahocphan"]);
                    if ($count == 1) { // Thành công nếu có 1 bản ghi được xóa.
                        $res->success_msg = "Học phần đã được xóa.";
                    } else { // Thất bại nếu không có bản ghi nào được xóa.
                        $res->error_msg = "Học phần không tồn tại trong hệ thống.";
                    }
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