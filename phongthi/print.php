<?php
    session_start();
    if($_SESSION["isAdmin"] != 1){
        header("Location:http://examreg.com/account/view/LogoutView.php");
    }

    // Kiểm tra xem kỳ thi có tồn tại hay không
    $kythi = $_GET["kythi"];
    require_once dirname(__FILE__)."/../kythi/controller/KythiController.php";
    $kythictrl = new kythi\controller\KythiController();
    if (!$kythictrl->check($kythi)) {
        header("Location: http://examreg.com/404.html");
    }
    // Kỳ thi tồn tại trong hệ thống

    // Kiểm tra xem ca thi có tồn tại hay không
    $cathi = $_GET["cathi"];
    require_once dirname(__FILE__)."/../cathi/controller/CathiController.php";
    $cathictrl = new cathi\controller\CathiController($kythi);
    $temp = $cathictrl->check($cathi);
    if (!$temp) {
        header("Location: http://examreg.com/404.html");
    }
    // Ca thi tồn tại trong hệ thống

    // Kiểm tra xem phòng thi có tồn tại hay không
    $phongthi = $_GET["phongthi"];
    require_once dirname(__FILE__)."/controller/PhongthiController.php";
    $phongthictrl = new phongthi\controller\PhongthiController($cathi);
    $temp = $phongthictrl->check($phongthi);
    if (!$temp) {
        header("Location: http://examreg.com/404.html");
    }
    // Phòng thi tồn tại trong ca thi

    require_once dirname(__FILE__)."/controller/InphongthiController.php";
    use NcJoes\OfficeConverter\OfficeConverter; // Wrapper để chuyển DOCX sang PDF

    $ctrl = new \phongthi\controller\InphongthiController($_GET["cathi"], $_GET["phongthi"]); // Tạo controller
    $templateProcessor = $ctrl->process(); // Xử lý file mẫu và trả về

    // Tạo file DOCX tạm
    $filename = uniqid(rand(), true) . '.docx';
    $docxpath = sys_get_temp_dir().'/'.$filename;
    $templateProcessor->saveAs($docxpath); // Lưu DOCX vào file tạm thời đó

    // Tạo file PDF tạm
    $filename_pdf = uniqid(rand(), true) . '.pdf';
    $pdfpath = sys_get_temp_dir().'/'.$filename_pdf;
    // Chuyển định dạng
    $converter = new OfficeConverter($docxpath);
    $converter->convertTo($filename_pdf); // Chuyển định dạng file DOCX sang PDF

    header('Content-type: application/pdf');
    header("Content-Disposition: inline; filename=danh_sach_phong_thi.pdf"); // Đổi tên, bỏ chế độ download

    readfile($pdfpath);
    // Xóa file trên server
    unlink($docxpath);
    unlink($pdfpath);