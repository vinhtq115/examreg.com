<?php
    // Kiểm tra session xem có phải là admin không. Nếu có thì trả về homepage.
    session_start();
    if($_SESSION["isAdmin"] == 1 || !isset($_SESSION["id"])){
        header("Location:http://examreg.com/");
    }

    header("Content-type:application/json"); // Set kiểu trả về dưới dạng JSON
    require_once dirname(__FILE__)."/controller/DangkythiController.php";
    require_once dirname(__FILE__)."/../../utils/Utils.php";

    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $res = new stdClass(); // Chứa response
        if (!isset($_GET["mssv"]) || empty($_GET["mssv"]) || !is_numeric($_GET["mssv"]) || !checkInteger($_GET["mssv"])) {
            $res->error_msg = 'Thiếu mã số sinh viên hoặc mã số sinh viên không phải là số.';
        } else {
            $dangkythictrl = new \sinhvien\dangkythi\controller\DangkythiController($_GET["mssv"]);
            // Lấy bảng từ controller về và hash lại để só sánh với hash client gửi lên
            $table_registrable = $dangkythictrl->getRegistrableCathi();
            $hash_registrable = hash("sha256", $table_registrable);
            $table_registered = $dangkythictrl->getRegisteredCathi();
            $hash_registered = hash("sha256", $table_registered);

            if (isset($_GET["hash_registrable"])) { // Client refresh bảng registrable
                if ($_GET["hash_registrable"] != $hash_registrable) {
                    $res->hash = $hash_registrable;
                    $res->table = $table_registrable;
                } else {
                    $res->hash = $hash_registrable;
                }
            } elseif (isset($_GET["hash_registered"])) { // Client refresh bảng registered
                if ($_GET["hash_registered"] != $hash_registered) {
                    $res->hash = $hash_registered;
                    $res->table = $table_registered;
                } else {
                    $res->hash = $hash_registered;
                }
            }
        }
        echo json_encode($res);
    }
    elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $res = new stdClass(); // Chứa response

        if (isset($_POST["register"]) && $_POST["register"] == 1) {
            // Kiểm tra dữ liệu vào
            if (!isset($_POST["mssv"]) || empty($_POST["mssv"]) || !is_numeric($_POST["mssv"]) || !checkInteger($_POST["mssv"])) {
                $res->error_msg = 'Thiếu mã số sinh viên hoặc mã số sinh viên không phải là số.';
            } elseif (!isset($_POST["macathi"]) || empty($_POST["macathi"]) || !is_numeric($_POST["macathi"]) || !checkInteger($_POST["macathi"])) {
                $res->error_msg = 'Thiếu mã ca thi hoặc mã ca thi không phải là số.';
            } elseif (!isset($_POST["maphongthi"]) || empty($_POST["maphongthi"])) {
                $res->error_msg = 'Thiếu mã phòng thi.';
            } else {
                $dangkythictrl = new \sinhvien\dangkythi\controller\DangkythiController($_POST["mssv"]);
                $status_code = $dangkythictrl->register($_POST["macathi"], $_POST["maphongthi"]);
                // Gửi thông báo thành công/lỗi
                switch ($status_code) {
                    case 0: // OK
                        $res->success_msg = "Đã đăng ký ca thi.";
                        break;
                    case 1: // Không tồn tại ca thi trong kỳ thi hiện tại
                        $res->error_msg = "Không tồn tại ca thi trong kỳ thi hiện tại. Ca thi có thể đã bị xóa.";
                        break;
                    case 2: // Phòng thi không tồn tại
                        $res->error_msg = "Phòng thi không tồn tại.";
                        break;
                    case 3: // Phòng thi không nằm trong ca thi
                        $res->error_msg = "Phòng thi không nằm trong ca thi.";
                        break;
                    case 4: // Phòng thi không đủ máy.
                        $res->error_msg = "Phòng thi không còn trống.";
                        break;
                    case 5: // Thí sinh đã đăng ký phòng thi cho ca thi.
                        $res->error_msg = "Ca thi đã tồn tại trong danh sách đăng ký của thí sinh.";
                        break;
                }
            }
        }

        echo json_encode($res);
    }
    else
    {
        $res = new stdClass();
        $res->error_msg = 'Unknown';
        echo json_encode($res);
    }