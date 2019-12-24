<?php
    session_start();

    if(!isset($_SESSION["isAdmin"]) || $_SESSION["isAdmin"] != 0 || !isset($_SESSION["id"])) { // Nếu là admin hoặc chưa login thì cho về trang chủ
        header("Location:http://examreg.com/");
    }
    // Kiểm tra xem có đủ điều kiện thi không. Nếu không thì cũng cho về trang chủ
    if (isset($_SESSION["dudieukienduthi"]) && $_SESSION["dudieukienduthi"] == false) {
        header("Location:http://examreg.com/sinhvien");
    }

    require_once dirname(__FILE__)."/controller/IndangkythiController.php";
    $indangkythictrl = new \sinhvien\dangkythi\controller\IndangkythiController($_SESSION["id"]);
    header('Content-Type: application/octet-stream');
    header("Content-Disposition: attachment; filename=phieu_bao_du_thi.docx");

    $templateProcessor = $indangkythictrl->process(); // Xử lý file mẫu và trả về
    $templateProcessor->saveAs("php://output"); // Cho người dùng download thẳng về