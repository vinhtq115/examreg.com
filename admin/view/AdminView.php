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
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <script src="/externals/jquery/jquery-3.4.1.js"></script>
</head>
<body>
<header>
    <div class="container">
        <div id="branding">
            <h1><span class="highlight">Exam</span>Reg</h1>
        </div>
        <nav>
            <ul>
                <li class="current"><a id = "logout-btn" href="http://examreg.com/account/view/LogoutView.php">Đăng xuất</a></li>
            </ul>
        </nav>
    </div>
</header>
    <section id="showcase">
        <div class="container">
            <h1>TRANG QUẢN TRỊ HỆ THỐNG KỲ THI</h1>
        </div>
    </section>

    <section id="boxes">
        <div class="container">
            <div class="box">
                <a href="http://examreg.com/admin/getStudentIndex/"><img src="/css/img/graduate-student.png"></a> <!--This will redirect to getting student excel-->
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
                <h3>Change Password</h3>
                <p>Change the user password. Both student and admin can use</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2019</p>
    </footer>

</body>
</html>