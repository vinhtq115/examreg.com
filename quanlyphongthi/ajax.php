<?php
    require_once dirname(__FILE__)."/../account/controller/LogoutController.php";
    session_start();
    if($_SESSION["isAdmin"] != 1){
        header("Location:http://examreg.com/account/view/LogoutView.php");
    }

    header("Content-type:application/json"); // Set kiểu trả về dưới dạng JSON
    require_once dirname(__FILE__)."/controller/PhongthiController.php";
    require_once dirname(__FILE__)."/../utils/Utils.php";
    $phongthictrl = new \quanlyphongthi\controller\PhongthiController();
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $res = new stdClass(); // Chứa response
        $hash = hash('sha256', $phongthictrl->table());
        if (isset($_GET['danhsachphongthi']) && $_GET['danhsachphongthi'] == 1) { // Client yêu cầu gửi danh sách phòng thi
            $res->phongthi = $phongthictrl->datalist();
        } else if (!isset($_GET['hash']) || $_GET['hash'] != $hash) { // Client kiểm tra xem hash của client có trùng server không. Nếu không trùng, server trả về bảng, datalist và hash mới.
            $res->table = $phongthictrl->table();
            $res->datalist = $phongthictrl->datalist();
            $res->hash = $hash;
        } else if (isset($_GET['hash']) && $_GET['hash'] == $hash) { // Nếu trùng hash, chỉ trả về hash
            $res->hash = $hash;
        }

        echo json_encode($res); // Trả về kết quả
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $res = new stdClass();
        if (isset($_POST["add"]) && isset($_POST["maphongthi"]) && isset($_POST["diadiem"]) && isset($_POST["soluongmay"])
        && !empty($_POST["maphongthi"]) && !empty($_POST["diadiem"]) && !empty($_POST["soluongmay"]) && $_POST["add"] == 1) { // Kiểm tra xem có phải add không
            if (is_numeric($_POST["soluongmay"]) && checkInteger($_POST["soluongmay"]) && $_POST["soluongmay"] >= 1 && strlen($_POST["diadiem"]) >= 1 && strlen($_POST["diadiem"]) <= 50
                && strlen($_POST["maphongthi"]) >= 1 && strlen($_POST["maphongthi"]) <= 20) { // Kiểm tra xem độ dài và kiểu dữ liệu có thỏa mãn không
                $count = $phongthictrl->add($_POST["maphongthi"], $_POST["diadiem"], $_POST["soluongmay"]); // Đếm số bản ghi được cập nhật
                if ($count == 1) { // Thành công nếu có 1 bản ghi được thêm.
                    $res->success_msg = "Phòng thi được thêm thành công.";
                } else { // Thất bại nếu không có bản ghi nào được thêm.
                    $res->error_msg = "Có lỗi. Mã phòng thi có thể đã tồn tại trong hệ thống.";
                }
            } else { // Không thỏa mãn
                $res->error_msg = "Đã xảy ra lỗi. Vui lòng thử lại.";
            }
        } elseif (isset($_POST["delete"]) && isset($_POST["maphongthi"]) && !empty($_POST["maphongthi"]) && $_POST["delete"] == 1) { // Kiểm tra xem có phải delete không
            if (strlen($_POST["maphongthi"]) >= 1 && strlen($_POST["maphongthi"]) <= 20) { // Kiểm tra xem độ dài data có thỏa mãn không
                $count = $phongthictrl->delete($_POST["maphongthi"]);
                if ($count == 1) { // Thành công nếu có 1 bản ghi được xóa.
                    $res->success_msg = "Phòng thi đã được xóa.";
                } else { // Thất bại nếu không có bản ghi nào được xóa.
                    $res->error_msg = "Mã phòng thi không tồn tại trong hệ thống.";
                }
            } else { // Không thỏa mãn
                $res->error_msg = "Đã xảy ra lỗi. Vui lòng thử lại.";
            }
        } elseif (isset($_POST["edit"]) && isset($_POST["maphongthicu"]) && isset($_POST["maphongthi"]) && isset($_POST["diadiem"])
        && isset($_POST["soluongmay"]) && $_POST["edit"] == 1) { // Kiểm tra xem có phải edit không
            if (is_numeric($_POST["soluongmay"]) && checkInteger($_POST["soluongmay"]) && $_POST["soluongmay"] >= 1 && strlen($_POST["diadiem"]) >= 1 && strlen($_POST["tenmonthi"]) <= 50
            && strlen($_POST["maphongthi"]) >= 1 && strlen($_POST["maphongthi"]) <= 20 && strlen($_POST["maphongthicu"]) >= 1 && strlen($_POST["maphongthicu"]) <= 20) { // Kiểm tra xem độ dài data và kiểu dữ liệu có thỏa mãn không
                $count = $phongthictrl->edit($_POST["maphongthicu"], $_POST["maphongthi"], $_POST["diadiem"], $_POST["soluongmay"]); // Đếm số bản ghi được cập nhật
                if ($count == 1) { // Thành công nếu có 1 bản ghi được thêm.
                    $res->success_msg = "Phòng thi được sửa thành công.";
                } else { // Thất bại nếu không có bản ghi nào được thêm.
                    $res->error_msg = "Có lỗi. Mã phòng thi cũ có thể không tồn tại trong hệ thống hoặc mã phòng thi mới đã có trong hệ thống.";
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