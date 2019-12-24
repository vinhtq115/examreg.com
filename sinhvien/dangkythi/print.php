<?php
    session_start();
    // Kiểm tra session
    if(!isset($_SESSION["isAdmin"]) || $_SESSION["isAdmin"] != 0 || !isset($_SESSION["id"])) { // Nếu là admin hoặc chưa login thì cho về trang chủ
        header("Location:http://examreg.com/");
    }
    // Kiểm tra xem có đủ điều kiện thi không. Nếu không thì cũng cho về trang chủ
    if (isset($_SESSION["dudieukienduthi"]) && $_SESSION["dudieukienduthi"] == false) {
        header("Location:http://examreg.com/sinhvien");
    }

    require_once dirname(__FILE__)."/controller/IndangkythiController.php";
    use NcJoes\OfficeConverter\OfficeConverter; // Wrapper để chuyển DOCX sang PDF

    $indangkythictrl = new \sinhvien\dangkythi\controller\IndangkythiController($_SESSION["id"]); // Tạo controller in đăng ký với id sinh viên
    $templateProcessor = $indangkythictrl->process(); // Xử lý file mẫu và trả về
    // Tạo file DOCX tạm
    $filename = uniqid(rand(), true) . '.docx';
    $docxpath = sys_get_temp_dir().'/'.$filename;
    $templateProcessor->saveAs($docxpath); // Lưu DOCX vào file tạm thời đó

    // Tạo file PDF tạm
    $filename_pdf = uniqid(rand(), true) . '.pdf';
    $pdfpath = sys_get_temp_dir().'/'.$filename_pdf;

    $converter = new OfficeConverter($docxpath);
    $converter->convertTo($filename_pdf); // Chuyển định dạng file DOCX sang PDF

    header('Content-type: application/pdf');
    header("Content-Disposition: inline; filename=phieu_bao_du_thi.pdf"); // Đổi tên, bỏ chế độ download

    readfile($pdfpath);
    // Xóa file trên server
    unlink($docxpath);
    unlink($pdfpath);