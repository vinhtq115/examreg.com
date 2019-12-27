<?php
require_once dirname(__FILE__)."/../controller/getStudentController.php";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/externals/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
    <link href="/externals/bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/css/getStudent.css">
    <link rel="stylesheet" type="text/css" href="/css/getStudentTable.css">
    <link rel="stylesheet" type="text/css" href="/css/responsive.css">
    <title>Student Info</title>
    <style>
        .content-table{
            margin-left: 450px;
        }
        #on-right{
            float: right;
        }
        #on-left{
            float: left;
        }
    </style>
</head>
<body>
<nav class="navbar">
    <ul class="navbar-nav" id = on-left>
        <li><p>Examreg</p></li>
        <li class = "nav-item"><a href="http://examreg.com/admin/view/AdminView.php" ><img src = "/css/img/smallhome.png">Trang chủ</a></li>
        <li class = "nav-item"><a href="http://examreg.com/monthi/"><img src = "/css/img/smallbook.png">Môn thi</a></li>
        <li class = "nav-item"><a href="http://examreg.com/hocphan/"><img src = "/css/img/smallglass.png">Học phần</a></li>
        <li class = "nav-item"><a href="http://examreg.com/kythi/"><img src = "/css/img/term.png">Kỳ thi</a></li>
        <li class = "nav-item"><a href="http://examreg.com/quanlyphongthi/"><img src = "/css/img/lamp.png">Phòng Thi</a></li>
        <li class = "nav-item"><a href="http://examreg.com/admin/getStudentIndex/"><img src = "/css/img/smallStudent.png">Quản lí sinh viên</a></li>
    </ul>
    <ul class = "navbar-nav" id = "on-right">
        <li><a href="http://examreg.com/account/view/ChangePassView.php"><img src = "/css/img/smalltext.png">Đổi mật khẩu</a></li>
        <li><a class = "right-bar" href="http://examreg.com/account/view/LogoutView.php"><img src = "/css/img/smalldoor.png">Đăng xuất</a></li>
    </ul>
</nav>

    <table class="content-table">
        <thead>
        <tr>
            <td>STT</td>
            <td>Mã sinh viên</td>
            <td>Họ đệm</td>
            <td>Tên</td>
            <td>Ngày sinh</td>
            <td>Đủ điều kiện dự thi</td>
        </tr>
        </thead>
        <tbody>
        <?php
        $control =new getStudentController();
        $control->getStudentData();
        ?>
        </tbody>
    </table>

</body>
</html>