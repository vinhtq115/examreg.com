<?php
require_once dirname(__FILE__)."/../../account/controller/LogoutController.php";
session_start();

if($_SESSION["isAdmin"] != 1){
    header("Location:http://examreg.com/account/view/LogoutView.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Trang chủ quản trị viên</title>
    <link rel="stylesheet" type="text/css" href="/css/adminView.css">
    <!--<link rel="stylesheet" type="text/css" href="/css/header.css">-->
    <script src="/externals/jquery/jquery-3.4.1.js"></script>
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
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark primary-color">
    <!-- Tên trang web -->
    <a class="navbar-brand" href="/">ExamReg</a>
    <!-- Nội dung thanh điều hướng -->
    <div class="collapse navbar-collapse">
        <!-- Đường dẫn -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link disabled" href="/"><img src = "/css/img/smallhome.png">Trang chủ</a>
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
                <a class="nav-link" href="/students"><img src = "/css/img/smallStudent.png">Sinh viên</a>
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

<section id="showcase">
    <div class="container">
        <h1>TRANG QUẢN TRỊ HỆ THỐNG KỲ THI</h1>
    </div>
</section>

<section id="boxes">
    <div class="container">
        <div class="box">
            <a href="http://examreg.com/students/"><img src="/css/img/graduate-student.png"></a> <!--This will redirect to getting student excel-->
            <h3>Quản lý sinh viên</h3>
            <p>Trang quản lý danh sách sinh viên, cấp tài khoản, cập nhật trạng thái đủ điều kiện dự thi</p>
        </div>
        <div class="box">
            <a href="http://examreg.com/monthi/"><img src="/css/img/microscope.png"></a>
            <h3>Quản lý môn thi</h3>
            <p>Trang quản lý danh sách môn thi của trường</p>
        </div>
        <div class="box">
            <a href="http://examreg.com/hocphan/"><img src="/css/img/book.png"></a>
            <h3>Quản lý học phần</h3>
            <p>Trang quản lý danh sách học phần của trường</p>
        </div>
    </div>
    <div class="container">
        <div class="box">
            <a href="http://examreg.com/kythi"><img src="/css/img/logo_brush.png"></a>
            <h3>Quản lý kỳ thi</h3>
            <p>Trang quản lý danh sách kỳ thi</p>
        </div>
        <div class="box">
            <a href="http://examreg.com/quanlyphongthi"><img src="/css/img/door.png"></a>
            <h3>Quản lý phòng thi</h3>
            <p>Trang quản lý danh sách phòng thi và thông tin từng phòng</p>
        </div>
        <div class="box">
            <a href="http://examreg.com/account/view/ChangePassView.php"><img src="/css/img/clock.png"></a>
            <h3>Đổi mật khẩu</h3>
            <p>Cho phép thay đổi mật khẩu</p>
        </div>
    </div>
</section>

<footer>
    <p>&copy; 2019</p>
</footer>

</body>
</html>