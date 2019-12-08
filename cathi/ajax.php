<?php
    // Kiểm tra session xem có phải là admin không. Nếu không thì logout.
    require_once dirname(__FILE__)."/../account/controller/LogoutController.php";
    session_start();
    if($_SESSION["isAdmin"] != 1){
        header("Location:http://examreg.com/account/view/LogoutView.php");
    }

    require_once dirname(__FILE__)."/controller/CathiController.php";
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

    /**
     * Hàm kiểm tra giờ xem có đúng định dạng (HH:MM:SS) và hợp lệ không
     * @param $time: Thời gian
     * @return bool
     */
    function isTime($time) {
        if (preg_match("/^([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/", $time)) {
            return true;
        } else {
            return false;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $res = new stdClass(); // Chứa response
        if (!isset($_GET["kythi"]) || empty($_GET["kythi"]) || !checkInteger($_GET["kythi"])) {
            $res->error_msg = 'Thiếu hoặc sai mã kỳ thi. Mã kỳ thi phải là một số tự nhiên lớn hơn 0.';
        } else {
            $cathictrl = new \cathi\controller\CathiController($_GET["kythi"]);
            // Lấy bảng từ controller và hash lại để so sánh với hash client gửi lên
            $table = $cathictrl->table();
            $hash = hash('sha256', $table);

            if (isset($_GET['danhsachcathi']) && $_GET['danhsachcathi'] == 1) { // Client refresh datalist
                $res->danhsachcathi = $cathictrl->datalist();
            } else if (!isset($_GET['hash']) || $_GET['hash'] != $hash) {
                // Nếu khác hash thì trả về hash và bảng
                $res->table = $table;
                $res->danhsachcathi = $cathictrl->datalist();
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
            $cathictrl = new \cathi\controller\CathiController($_POST["kythi"]);
            if (isset($_POST["add"]) && $_POST["add"] == 1) { // Client thêm ca thi
                if (!isset($_POST["mahocphan"]) || empty($_POST["mahocphan"])) { // Nếu trống mã học phần
                    $res->error_msg = "Mã học phần không được để trống.";
                } elseif (!preg_match("/^\b[a-zA-Z0-9]+\s[0-9]+\b$/", $_POST["mahocphan"])) { // Mã học phần sai định dạng
                    $res->error_msg = "Mã học phần sai định dạng.";
                } elseif (!isset($_POST["ngaythi"]) || empty($_POST["ngaythi"])) { // Nếu trống ngày thi
                    $res->error_msg = "Ngày thi không được để trống.";
                } elseif (strlen($_POST["ngaythi"]) != 10 || !isDate($_POST["ngaythi"])) { // Nếu ngày thi sai định dạng hoặc không hợp lệ
                    $res->error_msg = "Ngày thi không hợp lệ.";
                } elseif (!isset($_POST["giobatdau"]) || empty($_POST["giobatdau"])) { // Nếu trống giờ bắt đầu
                    $res->error_msg = "Giờ bắt đầu không được để trống.";
                } elseif (!isTime($_POST["giobatdau"])) { // Giờ bắt đầu sai định dạng hoặc không hợp lệ
                    $res->error_msg = "Giờ bắt đầu sai định dạng hoặc không hợp lệ.";
                } elseif (!isset($_POST["gioketthuc"]) || empty($_POST["gioketthuc"])) { // Nếu trống giờ kết thúc
                    $res->error_msg = "Giờ kết thúc không được để trống.";
                } elseif (!isTime($_POST["gioketthuc"])) { // Giờ kết thúc sai định dạng hoặc không hợp lệ
                    $res->error_msg = "Giờ kết thúc sai định dạng hoặc không hợp lệ.";
                } elseif (strtotime($_POST["giobatdau"]) > strtotime($_POST["gioketthuc"])) { // Giờ bắt đầu > giờ kết thúc
                    $res->error_msg = "Giờ bắt đầu phải xảy ra trước giờ kết thúc.";
                } else { // Mọi điều kiện trên thỏa mãn
                    // Kiểm tra xem năm thi có nằm trong năm bắt đầu và năm kết thúc của kỳ thi không
                    $years = $cathictrl->getYear()[0];
                    $nambatdau = $years["nambatdau"];
                    $namketthuc = $years["namketthuc"];
                    if ($nambatdau <= substr($_POST["ngaythi"], 0, 4) && substr($_POST["ngaythi"], 0, 4) <= $namketthuc) {
                        $count = $cathictrl->add($_POST["mahocphan"], $_POST["ngaythi"], $_POST["giobatdau"], $_POST["gioketthuc"]);
                        if ($count == 1) { // Thành công nếu có 1 ca thi được thêm.
                            $res->success_msg = "Ca thi được thêm thành công.";
                        } else { // Thất bại nếu không có bản ghi nào được thêm.
                            $res->error_msg = "Có lỗi. Có thể đã có ca thi khác trùng thông tin.";
                        }
                    } else {
                        $res->error_msg = "Năm của ngày thi phải năm trong khoảng của năm bắt đầu và năm kết thúc kỳ thi.";
                    }
                }
            } elseif (isset($_POST["delete"]) && $_POST["delete"] == 1) { // Client xóa ca thi
                if (!isset($_POST["macathi"]) || empty($_POST["macathi"])) { // Nếu trống mã ca thi
                    $res->error_msg = "Thiếu mã ca thi.";
                } elseif (!is_numeric($_POST["macathi"]) || !checkInteger($_POST["macathi"])) { // Mã ca thi không phải là số tự nhiên > 0.
                    $res->error_msg = "Mã ca thi phải là số tự nhiên lớn hơn 0.";
                } else { // Mọi điều kiện thỏa mãn
                    $count = $cathictrl->delete($_POST["macathi"]);
                    if ($count == 1) { // Thành công nếu có 1 bản ghi được xóa.
                        $res->success_msg = "Ca thi đã được xóa.";
                    } else { // Thất bại nếu không có bản ghi nào được xóa.
                        $res->error_msg = "Ca thi không tồn tại trong học kỳ này.";
                    }
                }
            } elseif (isset($_POST["edit"]) && $_POST["edit"] == 1) { // Client sửa ca thi
                if (!isset($_POST["macathi"]) || empty($_POST["macathi"])) { // Nếu trống mã ca thi
                    $res->error_msg = "Thiếu mã ca thi.";
                } elseif (!is_numeric($_POST["macathi"]) || !checkInteger($_POST["macathi"])) { // Mã ca thi không phải là số tự nhiên > 0.
                    $res->error_msg = "Mã ca thi phải là số tự nhiên lớn hơn 0.";
                } elseif (!isset($_POST["mahocphan"]) || empty($_POST["mahocphan"])) { // Nếu trống mã học phần
                    $res->error_msg = "Mã học phần không được để trống.";
                } elseif (!preg_match("/^\b[a-zA-Z0-9]+\s[0-9]+\b$/", $_POST["mahocphan"])) { // Mã học phần sai định dạng
                    $res->error_msg = "Mã học phần sai định dạng.";
                } elseif (!isset($_POST["ngaythi"]) || empty($_POST["ngaythi"])) { // Nếu trống ngày thi
                    $res->error_msg = "Ngày thi không được để trống.";
                } elseif (strlen($_POST["ngaythi"]) != 10 || !isDate($_POST["ngaythi"])) { // Nếu ngày thi sai định dạng hoặc không hợp lệ
                    $res->error_msg = "Ngày thi không hợp lệ.";
                } elseif (!isset($_POST["giobatdau"]) || empty($_POST["giobatdau"])) { // Nếu trống giờ bắt đầu
                    $res->error_msg = "Giờ bắt đầu không được để trống.";
                } elseif (!isTime($_POST["giobatdau"])) { // Giờ bắt đầu sai định dạng hoặc không hợp lệ
                    $res->error_msg = "Giờ bắt đầu sai định dạng hoặc không hợp lệ.";
                } elseif (!isset($_POST["gioketthuc"]) || empty($_POST["gioketthuc"])) { // Nếu trống giờ kết thúc
                    $res->error_msg = "Giờ kết thúc không được để trống.";
                } elseif (!isTime($_POST["gioketthuc"])) { // Giờ kết thúc sai định dạng hoặc không hợp lệ
                    $res->error_msg = "Giờ kết thúc sai định dạng hoặc không hợp lệ.";
                } elseif (strtotime($_POST["giobatdau"]) > strtotime($_POST["gioketthuc"])) { // Giờ bắt đầu > giờ kết thúc
                    $res->error_msg = "Giờ bắt đầu phải xảy ra trước giờ kết thúc.";
                } else { // Mọi điều kiện trên thỏa mãn
                    // Kiểm tra xem năm thi có nằm trong năm bắt đầu và năm kết thúc của kỳ thi không
                    $years = $cathictrl->getYear()[0];
                    $nambatdau = $years["nambatdau"];
                    $namketthuc = $years["namketthuc"];
                    if ($nambatdau <= substr($_POST["ngaythi"], 0, 4) && substr($_POST["ngaythi"], 0, 4) <= $namketthuc) {
                        $count = $cathictrl->edit($_POST["macathi"], $_POST["mahocphan"], $_POST["ngaythi"], $_POST["giobatdau"], $_POST["gioketthuc"]);
                        if ($count == 1) { // Thành công nếu có 1 bản ghi được sửa.
                            $res->success_msg = "Ca thi đã được sửa.";
                        } else { // Thất bại nếu không có bản ghi nào được sửa.
                            $res->error_msg = "Ca thi không tồn tại trong học kỳ này.";
                        }
                    } else {
                        $res->error_msg = "Năm của ngày thi phải năm trong khoảng của năm bắt đầu và năm kết thúc kỳ thi.";
                    }
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