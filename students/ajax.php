<?php
    // Kiểm tra session
    session_start();
    if($_SESSION["isAdmin"] != 1){
        header("Location:http://examreg.com/");
    }

    header("Content-type:application/json"); // Set kiểu trả về dưới dạng JSON
    require_once dirname(__FILE__)."/controller/StudentsController.php";
    $ctrl = new \students\controller\StudentsController();
    // Kiểm tra REQUEST_METHOD là GET
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $res = new stdClass(); // Chứa response
        $table1 = $ctrl->tableSV();
        $table2 = $ctrl->tableSVHHP();
        $hash1 = hash('sha256', $table1); // Hash của bảng SV
        $hash2 = hash('sha256', $table2); // Hash của bảng SVHHP
        // Client kiểm tra xem hash của client có trùng server không. Nếu không trùng, server trả về bảng và hash mới.
        if (isset($_GET['hash1'])) { // Check hash bảng sinh viên
            if ($_GET['hash1'] != $hash1) {
                $res->table = $table1;
            }
            $res->hash = $hash1;
        } else if (isset($_GET['hash2'])) { // Check hash bảng sinh viên học học phần
            if ($_GET['hash2'] != $hash2) {
                $res->table = $table2;
            }
            $res->hash = $hash2;
        }

        echo json_encode($res); // Trả về kết quả
    } else {
        $res = new stdClass();
        $res->error_msg = 'Unknown';
        echo json_encode($res);
    }