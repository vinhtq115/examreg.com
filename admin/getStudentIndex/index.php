<?php
session_start();
require_once dirname(__FILE__)."/../../account/controller/LogoutController.php";
//require_once dirname(__FILE__)."/../view/getStudentView.php";
require_once dirname(__FILE__)."/../controller/getStudentController.php";
//require dirname(__FILE__)."/../../vendor/autoload.php";
//require_once dirname(__FILE__)."/../../vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/IOFactory.php"; // include phpspreadsheet from vendor

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
    <title>Student Managing</title>
    <script src="/../../bootstrap/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
    <link href="/../../bootstrap/bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/../../css/getStudent.css">
    <link rel="stylesheet" type="text/css" href="/../../css/getStudentTable.css">
    <link rel="stylesheet" type="text/css" href="/../../css/responsive.css">
    <style>
        .btn btn-primary btn-block{
            background-color: #0b2e13;
        }
    </style>
</head>
<body>
<nav class="navbar">
    <span class="open-slide">
      <a href="#" onclick="openSlideMenu()">
        <svg width="30" height="30">
            <path d="M0,5 30,5" stroke="#fff" stroke-width="5"/>
            <path d="M0,14 30,14" stroke="#fff" stroke-width="5"/>
            <path d="M0,23 30,23" stroke="#fff" stroke-width="5"/>
        </svg>
      </a>
    </span>

    <ul class="navbar-nav">
        <li><a href = "#">Student Management</li>
    </ul>
<!--    <ul class = "navbar-nav">-->
<!--        <li class="current">Xin chào --><?php //echo $_SESSION["id"]?><!--</li>-->
<!--    </ul>-->
</nav>

<div id="side-menu" class="side-nav">
    <a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
    <a href="http://examreg.com/admin/view/AdminView.php" >HomePage</a>
    <a href="http://examreg.com/monthi/">Subjects</a>
    <a href="http://examreg.com/hocphan/">Courses</a>
    <a href="http://examreg.com/account/view/LogoutView.php">Log out</a>
</div>

<div id="main">
    <div class = "container box">
        <table class="content-table">
            <thead>
            <tr>
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
    <h3 align="center">Delete Student</h3></h3><br />
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
            <td>Ma hoc phan</td>
            <td>Ma Ki Thi</td>
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
            <button class = "btn btn-primary btn-danger" name = "DeleteCourse">Submit</button>
    </form>
    <br />
    <br />
</div>

<div class="container box">
    <h3 align="center">Update Courses</h3></h3><br />
    <form align = "center" method="POST" enctype="multipart/form-data">
        <label>Chọn file Excel</label>
        <input type="file" name="file"/>
        <br />
        <button type="submit" name="UpdateCourses" class="btn btn-danger" value="UpdateStudent">Tải lên</button>
    </form>
    <br />
    <br />
</div>
<!--TODO: Add delete for every update-->
</div>

<script>
    function openSlideMenu(){
        document.getElementById('side-menu').style.width = '250px';
        document.getElementById('main').style.marginLeft = '250px';
    }

    function closeSlideMenu(){
        document.getElementById('side-menu').style.width = '0';
        document.getElementById('main').style.marginLeft = '0';
    }

</script>
</body>

</html>