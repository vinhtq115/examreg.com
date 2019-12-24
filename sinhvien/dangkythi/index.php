<?php
    session_start();
    if($_SESSION["isAdmin"] != 0 || !isset($_SESSION["id"])) { // Nếu là admin hoặc chưa login thì cho về trang chủ
        header("Location:http://examreg.com/");
    }
    // Kiểm tra xem có đủ điều kiện thi không. Nếu không thì cũng cho về trang chủ
    if (isset($_SESSION["dudieukienduthi"]) && $_SESSION["dudieukienduthi"] == false) {
        header("Location:http://examreg.com/sinhvien");
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký thi</title>
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
    <link rel="stylesheet" href="/css/dangkythi.css">
</head>
<body>
    <!--Thanh điều hướng-->
    <nav class="navbar navbar-expand-lg navbar-dark primary-color">
        <a class="navbar-brand" href="/">ExamReg</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/sinhvien/home">Trang chủ</a>
                </li>
                <li class='nav-item active'>
                    <a class='nav-link disabled' href='/sinhvien/dangkythi'>Đăng ký thi</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='/sinhvien/indangkythi'>In đăng ký thi</a>
                </li>
            </ul>
            <ul class="navbar-nav mr-1">
                <li class="nav-item">
                    <a class="nav-link" href="/account/view/ChangePassView.php"><i class="fas fa-lock"></i>Đổi mật khẩu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/account/view/LogoutView.php"><i class="fas fa-sign-out-alt"></i>Đăng xuất</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="main">
        <?php
            require_once dirname(__FILE__)."/controller/DangkythiController.php";
            $dangkythictrl = new \sinhvien\dangkythi\controller\DangkythiController($_SESSION["id"]);
            if ($dangkythictrl->getAllowedToRegister() == 0) {
                echo $dangkythictrl->showDisabled();
            } else {
                echo $dangkythictrl->showWarning();
                echo "<p id='mssv' hidden>".$_SESSION["id"]."</p>";
            }
        ?>
        <!--Bảng đăng ký ca thi-->
        <h1>Đăng ký ca thi</h1>
        <div id="table-container-1">
            <?php
                $registrable_table = $dangkythictrl->getRegistrableCathi();
                echo $registrable_table;
                echo "<p id='table1hash' hidden>".hash("sha256", $registrable_table)."</p>";
            ?>
        </div>
        <!--Danh sách ca thi đã đăng ký-->
        <h1>Danh sách ca thi đã đăng ký</h1>
        <div id="table-container-2">
            <?php
                $registered_table = $dangkythictrl->getRegisteredCathi();
                echo $registered_table;
                echo "<p id='table2hash' hidden>".hash("sha256", $registered_table)."</p>";
            ?>
        </div>
        <div class="float-right">
            <button id="print" class="btn btn-default"><i class="fas fa-print"></i> Xuất phiếu báo dự thi</button>
            <button id="download" class="btn btn-primary"><i class="fas fa-download"></i> Download</button>
        </div>
    </div>
    <div id="pdfhere" class="position-relative">
    </div>
    <script src="script.js"></script>
</body>