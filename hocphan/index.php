<?php
    session_start();
    if($_SESSION["isAdmin"] != 1){
        header("Location:http://examreg.com/");
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý học phần</title>
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
    <!--<link rel="stylesheet" href="../css/header.css">-->
</head>
<body>
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
                <li class="nav-item active">
                    <a class="nav-link disabled" href="/hocphan"><img src = "/css/img/smallglass.png">Học phần</a>
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
                    <a class="nav-link" href="/account/view/ChangePassView.php"><img src = "/css/img/smalltext.png"></i>Đổi mật khẩu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/account/view/LogoutView.php"><img src = "/css/img/smalldoor.png"></i>Đăng xuất</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="main">
        <div id="table">
            <!-- Danh sách học phần -->
            <div id="table-container">
                <?php
                    require_once dirname(__FILE__)."/controller/HocphanController.php";
                    $hocphanctrl = new \hocphan\controller\HocphanController();
                    $table = $hocphanctrl->table();
                    echo $table;
                    echo "<p id='tablehash' hidden>".hash("sha256", $table)."</p>";
                ?>
            </div>
            <div id="datalistcontainer">
                <?php
                    echo $hocphanctrl->datalist_hocphan();
                    echo $hocphanctrl->datalist_monthi();
                ?>
            </div>
        </div>
        <div>
            <h3>Thêm học phần</h3>
            <?php
                // Form thêm học phần
                echo $hocphanctrl->showAdd();
            ?>
        </div>
        <div>
            <h3>Xóa học phần</h3>
            <div id="hocphandangxoa"></div>
            <?php
                // Form xóa môn thi
                echo $hocphanctrl->showDelete();
            ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>