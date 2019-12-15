<?php
    session_start();
    if($_SESSION["isAdmin"] != 1){
        header("Location:http://examreg.com/");
    }

    header("Content-type:application/json"); // Set kiểu trả về dưới dạng JSON
    require_once dirname(__FILE__)."/controller/PhongthiController.php";
    require_once dirname(__FILE__)."/../utils/Utils.php";

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $res = new stdClass(); // Chứa response
        if (!isset($_GET["kythi"]) || empty($_GET["kythi"]) || !checkInteger($_GET["kythi"])) {
            $res->error_msg = 'Thiếu hoặc sai mã kỳ thi. Mã kỳ thi phải là một số tự nhiên lớn hơn 0.';
        } elseif (!isset($_GET["cathi"]) || empty($_GET["cathi"]) || !checkInteger($_GET["cathi"])) {
            $res->error_msg = 'Thiếu hoặc sai mã ca thi. Mã ca thi phải là một số tự nhiên lớn hơn 0.';
        } else {
            $phongthictrl = new phongthi\controller\PhongthiController($_GET["cathi"]);
            // Lấy bảng từ controller và hash lại để so sánh với hash client gửi lên
            $table = $phongthictrl->table();
            $hash = hash('sha256', $table);
            if (isset($_GET['danhsachphongthidangco']) && $_GET['danhsachphongthidangco'] == 1) { // Client refresh datalist phòng thi của ca thi
                $res->danhsachphongthidangco = $phongthictrl->datalist();
            } else if (!isset($_GET['hash']) || $_GET['hash'] != $hash) {
                // Nếu khác hash thì trả về hash và bảng
                $res->table = $table;
                $res->danhsachphongthidangco = $phongthictrl->datalist();
                $res->hash = $hash;
            } else if (isset($_GET['hash']) && $_GET['hash'] == $hash) {
                // Nếu giống hash thì chỉ trả về hash
                $res->hash = $hash;
            }
        }
        echo json_encode($res);
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $res = new stdClass(); // Chứa response

        if (isset($_POST["kythi"]) && is_numeric($_POST["kythi"]) && checkInteger($_POST["kythi"])) {
            $kythi = $_POST["kythi"];
            // Kiểm tra xem kỳ thi có tồn tại hay không
            require_once dirname(__FILE__)."/../kythi/controller/KythiController.php";
            $kythictrl = new kythi\controller\KythiController();
            if (!$kythictrl->check($kythi)) {
                $res->error_msg = "Kỳ thi không tồn tại trong hệ thống.";
            } else { // Kỳ thi tồn tại trong hệ thống
                if (isset($_POST["cathi"]) && is_numeric($_POST["cathi"]) && checkInteger($_POST["cathi"])) {
                    $cathi = $_POST["cathi"];
                    $phongthictrl = new phongthi\controller\PhongthiController($cathi);
                    // Kiểm tra xem ca thi có tồn tại hay không
                    require_once dirname(__FILE__)."/../cathi/controller/CathiController.php";
                    $cathictrl = new cathi\controller\CathiController($kythi);
                    if (!$cathictrl->check($cathi)) {
                        $res->error_msg = "Ca thi không tồn tại trong hệ thống.";
                    } else { // Ca thi tồn tại trong hệ thống
                        if (isset($_POST["add"]) && $_POST["add"] == 1) { // Client thêm phòng thi
                            if (!isset($_POST["maphongthi"]) || empty($_POST["maphongthi"])) { // Nếu trống mã phòng thi
                                $res->error_msg = "Mã phòng thi không được để trống.";
                            } elseif (strlen($_POST["maphongthi"]) > 20 || strlen($_POST["maphongthi"]) < 1) {
                                $res->error_msg = "Mã phòng thi chỉ từ 1-20 ký tự.";
                            } else {
                                $count = $phongthictrl->add($_POST["maphongthi"]);
                                if ($count == 1) { // Thành công nếu có 1 phòng thi được thêm.
                                    $res->success_msg = "Phòng thi được thêm thành công.";
                                } else { // Thất bại nếu không có bản ghi nào được thêm.
                                    $res->error_msg = "Có lỗi. Phòng thi có thể không tồn tại hoặc ca thi đã có phòng thi này.";
                                }
                            }
                        } elseif (isset($_POST["delete"]) && $_POST["delete"] == 1) { // Client xóa phòng thi
                            if (!isset($_POST["maphongthi"]) || empty($_POST["maphongthi"])) { // Nếu trống mã phòng thi
                                $res->error_msg = "Mã phòng thi không được để trống.";
                            } elseif (strlen($_POST["maphongthi"]) > 20 || strlen($_POST["maphongthi"]) < 1) {
                                $res->error_msg = "Mã phòng thi chỉ từ 1-20 ký tự.";
                            } else {
                                $count = $phongthictrl->delete($_POST["maphongthi"]);
                                if ($count == 1) { // Thành công nếu có 1 phòng thi được xóa.
                                    $res->success_msg = "Phòng thi được xóa thành công.";
                                } else { // Thất bại nếu không có bản ghi nào được thêm.
                                    $res->error_msg = "Có lỗi. Phòng thi có thể không tồn tại trong ca thi.";
                                }
                            }
                        }
                    }
                } else {
                    $res->error_msg = "Thiếu mã ca thi hoặc mã ca thi không phải là số tự nhiên lớn hơn 0.";
                }
            }
        } else {
            $res->error_msg = "Thiếu mã kỳ thi hoặc mã kỳ thi không phải là số tự nhiên lớn hơn 0.";
        }
        echo json_encode($res);
    } else {
        $res = new stdClass();
        $res->error_msg = 'Unknown';
        echo json_encode($res);
    }