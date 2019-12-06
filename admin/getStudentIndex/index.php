<?php
session_start();
//require_once dirname(__FILE__)."/../../account/controller/LogoutController.php";
require_once dirname(__FILE__)."/../../admin/view/getStudentView.php";
require_once dirname(__FILE__)."/../PHPExcelFile/Classes/PHPExcel/IOFactory.php";
require_once dirname(__FILE__)."/../PHPExcelFile/Classes/PHPExcel.php";

if($_SESSION["isAdmin"] != 1){
    header("Location:http://examreg.com/account/view/LogoutView.php");
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
</head>
<body>
<div class = "container box">
<table class="content-table">
    <thead>
    <tr>
        <td>Student ID</td>
        <td>Family Middle Name</td>
        <td>Name</td>
        <td>Date Taking Exam</td>
        <td>Qualified To Take Exam</td>
    </tr>
    </thead>
    <tbody>
    <?php
    $control = new getStudentController();
    $control->getStudentData();
    ?>
    </tbody>
</table>
</div>
<div class="container box">
<h3 align="center">IMPORT STUDENT FILES</h3></h3><br />
<form method="POST" enctype="multipart/form-data">
    <label>Select Excel File</label>
    <input type="file" name="excel"/>
    <br />
    <input type="submit" name="ImportStudent" class="btn btn-info" value="Import Student"/>
</form>
<br />
<br />
</div>

</body>
</html>