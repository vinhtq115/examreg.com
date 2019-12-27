<?php
session_start();
require_once dirname(__FILE__)."/../../account/controller/LogoutController.php";
require_once dirname(__FILE__)."/../controller/getStudentController.php";
if($_SESSION["isAdmin"] != 1){
    header("Location:http://examreg.com/account/view/LogoutView.php");
}
$control = new getStudentController(); // initiate a controller
if(isset($_POST["ImportStudent"])){  // if the form below is POSTED , these will take action
    $control->getStudentExcel();
}
if(isset($_POST["UpdateDis"])){
    $control->updateDisqualified();
}
if(isset($_POST["DeleteStudent"])){
    $control->DeleteStudent();
}
if(isset($_POST["UpdateCourses"])){
    $control->updateCourseSem();
}
if(isset($_POST["DeleteCourse"])){
    $control->deleteCourse();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quản lí sinh viên</title>
    <script src="/externals/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
    <link href="/externals/bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/css/getStudent.css">
    <link rel="stylesheet" type="text/css" href="/css/getStudentTable.css">
    <link rel="stylesheet" type="text/css" href="/css/responsive.css">
    <style>
        .btn btn-primary btn-block{
            background-color: #0b2e13;
        }
        .content-table{
            margin-left: 25px;
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


<div id="main">
    <div class = "container box">
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
            $control->getStudentData();
            ?>
            </tbody>
        </table>
    </div>
    <div class="container box">
        <h3 align="center">Nhập danh sách sinh viên</h3></h3><br />
        <form method="POST" enctype="multipart/form-data">
            <label>Chọn file Excel</label>
            <input type="file" name="file"/>
            <br />
            <button type="submit" name="ImportStudent" class="btn btn-danger" value="Import Student">Tải lên</button>
        </form>
        <br />
        <br />
    </div>
</div>
<div class="container box">
    <h3 align="center">Cập nhật trạng thái đủ điều kiện dự thi</h3></h3><br />
    <form method="POST" enctype="multipart/form-data">
        <label>Chọn file Excel</label>
        <input type="file" name="file"/>
        <br />
        <button type="submit" name="UpdateDis" class="btn btn-danger" value="UpdateDisqulified">Tải lên</button>
    </form>
    <br />
    <br />
</div>

<div class="container box">
    <h3 align="center">Xoá Sinh Viên Khỏi Hệ Thống</h3></h3><br />
    <form method="POST" enctype="multipart/form-data">
        <label>Chọn file Excel</label>
        <input type="file" name="file"/>
        <br />
        <button type="submit" name="DeleteStudent" class="btn btn-danger" value="DelStud">Tải lên</button>
    </form>
    <br />
    <br />
</div>

<div class = "container box">
    <table class="content-table">
        <thead>
        <tr>
            <td>Mã sinh viên</td>
            <td>Mã học phần</td>
            <td>Tên môn thi</td>
            <td>Số tín</td>
            <td>Học kì</td>
            <td>Bắt đầu</td>
            <td>Kết thúc</td>
        </tr>
        </thead>
        <tbody>
        <?php
        $control->getSVCourseSem();
        ?>
        </tbody>
    </table>

    <form action = "" method="POST">
        <input name = "sinhvienID" class = "form-control" required = "required" placeholder="Student ID">
        <input name = "courseID" class = "form-control" required = "required" placeholder="Course ID">
        <input name = "semID" class = "form-control" required = "required" placeholder="Semester ID">
        <button class = "btn btn-primary btn-danger" name = "DeleteCourse">Tải lên</button>
    </form>
    <br />
    <br />
</div>

<div class="container box">
    <h3 align="center">Cập nhập sinh viên và khoá học</h3></h3><br />
    <form align = "center" method="POST" enctype="multipart/form-data">
        <label>Chọn file Excel</label>
        <input type="file" name="file"/>
        <br />
        <button type="submit" name="UpdateCourses" class="btn btn-danger" value="UpdateStudent">Tải lên</button>
    </form>
    <br />
    <br />
</div>
</div>
<!--<script src = "responsive.js"></script>-->
</body>

</html>