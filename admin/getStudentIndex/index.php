<?php
session_start();
//require_once dirname(__FILE__)."/../../account/controller/LogoutController.php";
require_once dirname(__FILE__)."/../view/getStudentView.php";
require_once dirname(__FILE__)."/../controller/getStudentController.php";
require_once dirname(__FILE__)."/../Classes/PHPExcel.php";
require dirname(__FILE__)."/../../vendor/autoload.php";
require_once dirname(__FILE__)."/../../vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/IOFactory.php"; // include phpspreadsheet from vendor

if($_SESSION["isAdmin"] != 1){
    header("Location:http://examreg.com/account/view/LogoutView.php");
}
$control = new getStudentController(); // initiate a controller
if(isset($_POST["ImportStudent"])){
    $control->getStudentExcel();
}
if(isset($_POST["UpdateDis"])){
    $control->updateDisqualified();
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="/../../bootstrap/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
    <link href="/../../bootstrap/bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/../../css/getStudent.css">
    <link rel="stylesheet" type="text/css" href="/../../css/getStudentTable.css">
    <link rel="stylesheet" type="text/css" href="/../../css/responsive.css">
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
                <td>Student ID</td>
                <td>Family Middle Name</td>
                <td>First Name</td>
                <td>Date Taking Exam</td>
                <td>Qualified To Take Exam</td>
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
        <h3 align="center">IMPORT STUDENT FILES</h3></h3><br />
        <form method="POST" enctype="multipart/form-data">
            <label>Select Excel File</label>
            <input type="file" name="file"/>
            <br />
            <button type="submit" name="ImportStudent" class="btn btn-info" value="Import Student">Import Students</button>
        </form>
        <br />
        <br />
    </div>
</div>
<div class="container box">
    <h3 align="center">UPDATE STUDENT QUALIFICATION</h3></h3><br />
    <form method="POST" enctype="multipart/form-data">
        <label>Select Excel File</label>
        <input type="file" name="file"/>
        <br />
        <button type="submit" name="UpdateDis" class="btn btn-info" value="UpdateDisqulified">Update Disqualified</button>
    </form>
    <br />
    <br />
</div>

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