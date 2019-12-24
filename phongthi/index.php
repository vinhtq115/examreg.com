<?php
    session_start();
    if($_SESSION["isAdmin"] != 1){
        header("Location:http://examreg.com/account/view/LogoutView.php");
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý phòng thi</title>
    <!--Font Awesome-->
    <link rel="stylesheet" href="/externals/fontawesome/css/all.min.css">
    <!--Bootstrap core CSS-->
    <link rel="stylesheet" href="/externals/bootstrap/css/bootstrap.min.css">
    <!--Material Design Bootstrap-->
    <link rel="stylesheet" href="/externals/MDB/css/mdb.min.css">
    <!--MDBootstrap Datatables-->
    <link rel="stylesheet" href="/externals/MDB/css/addons/datatables.min.css">
    <!--JQuery-->
    <script src="/externals/jquery/jquery-3.4.1.min.js"></script>
    <!--Bootstrap tooltips-->
    <script src="/externals/popper.js/umd/popper.min.js"></script>
    <!--Bootstrap core JavaScript-->
    <script src="/externals/bootstrap/js/bootstrap.min.js"></script>
    <!--MDB core JavaScript-->
    <script src="/externals/MDB/js/mdb.min.js"></script>
    <!--MDBootstrap Datatables-->
    <script src="/externals/MDB/js/addons/datatables.min.js"></script>
    <!--Custom CSS-->
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/kythi.css">
    <!--<link rel="stylesheet" href="/css/header.css">-->
</head>
<body>
    <?php
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
        echo "<p id='kythi' hidden>".$_GET["kythi"]."</p>"; // Chứa mã kỳ thi
        echo "<p id='cathi' hidden>".$_GET["cathi"]."</p>"; // Chứa mã ca thi
    ?>
    <!--Thanh điều hướng-->
    <nav class="navbar navbar-expand-lg navbar-dark primary-color">
        <!-- Tên trang web -->
        <a class="navbar-brand" href="/">ExamReg</a>
        <!-- Nội dung thanh điều hướng -->
        <div class="collapse navbar-collapse">
            <!-- Đường dẫn -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/"><img src = "/css/img/smallhome.png">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/monthi"><img src = "/css/img/smallbook.png">Môn thi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/hocphan"><img src = "/css/img/smallglass.png">Học phần</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/kythi"><img src = "/css/img/term.png">Kỳ thi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/quanlyphongthi"><img src = "/css/img/lamp.png">Phòng thi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/getStudentIndex/"><img src = "/css/img/smallStudent.png">Sinh viên</a>
                </li>
            </ul>
            <ul class="navbar-nav mr-1">
                <li class="nav-item">
                    <a class="nav-link" href="/account/view/ChangePassView.php"><img src = "/css/img/smalltext.png">Đổi mật khẩu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/account/view/LogoutView.php"><img src = "/css/img/smalldoor.png">Đăng xuất</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="main">
        <!-- Thông tin ca thi -->
        <div>
            <?php
                echo "<p>Mã ca thi: ".$temp->macathi."<br>";
                echo "Mã học phần: ".$temp->mahocphan."<br>";
                echo "Tên môn thi: ".$temp->tenmonthi."<br>";
                echo "Ngày thi: ".$temp->ngaythi." (YYYY-MM-DD)<br>";
                echo "Giờ thi: ".$temp->giobatdau."-".$temp->gioketthuc."<br>";
            ?>
        </div>
        <!-- Danh sách phòng thi -->
        <div id="table">
            <div id="table-container">
                <?php
                    require_once dirname(__FILE__)."/controller/PhongthiController.php";
                    $phongthictrl = new \phongthi\controller\PhongthiController($cathi);
                    $table = $phongthictrl->table();
                    echo $table;
                    echo "<p id='tablehash' hidden>".hash("sha256", $table)."</p>";
                ?>
            </div>
            <div id='datalistcontainer'>
                <?php
                    echo $phongthictrl->datalist();
                    echo $phongthictrl->datalist_phongthi();
                ?>
            </div>
        </div>
        <div>
            <h3>Thêm phòng thi</h3>
            <?php
                // Form thêm phòng thi
                echo $phongthictrl->showAdd();
            ?>
        </div>
        <div>
            <h3>Xóa phòng thi</h3>
            <div id="phongthidangxoa"></div>
            <?php
                // Form xóa phòng thi
                echo $phongthictrl->showDelete();
            ?>
        </div>
    </div>
    <script src="/phongthi/script.js"></script>
</body>
