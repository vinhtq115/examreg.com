<?php
require_once dirname(__FILE__)."/../../account/controller/LogoutController.php";
session_start();
require_once dirname(__FILE__)."/../controller/StudentController.php";

if(empty($_SESSION["id"])){
    header("Location:http://examreg.com/account/view/LogoutView.php");
}

$random_controller = new StudentController();
$decide = $random_controller->isQuaified(); //to check if student is qualified to take the exam
if(!$decide){ // return false
    header("Location:http://examreg.com/NotQualified.html");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student HomePage</title>
    <link rel="stylesheet" type="text/css" href="/../../css/responsive.css">
    <link rel="stylesheet" type="text/css" href="/../../css/getStudentTable.css">
    <link rel="stylesheet" type="text/css" href="/../../css/getStudent.css">
    <style>
        .navbar{
            background-color:#1F7DDE;
            overflow:hidden;
            height:55px;
        }
        .content-table thead tr {
            background-color: #1F7DDE;
            color: #ffffff;
            text-align: left;
            font-weight: bold;
        }
        .content-table tbody tr:last-of-type {
            border-bottom: 2px solid #1F7DDE;
        }

        #info-box{
            table-layout: auto;
            width: 95%;
        }
    </style>
    <link
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
        <li><img src="/../../css/img/logo.png" alt="examregImage"></li>
    </ul>
</nav>
<div id="side-menu" class="side-nav">
    <a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
    <a href="http://examreg.com/account/view/ChangePassView.php"><img src = "/../../css/img/smalltext.png">Alter Password</a>
    <a href="http://examreg.com/account/view/LogoutView.php"><img src = "/../../css/img/smalldoor.png">Log out</a>
</div>

<div id="main">
        <table class="content-table">
            <thead>
            <tr>
                <td>Student ID</td>
                <td>Middle Name</td>
                <td>Name</td>
            </tr>
            </thead>
            <tbody>
                <?php
                    $controller = new StudentController();
                    $controller->getSelf();
                ?>
            </tbody>
        </table>
        <br/>
        <br/>
<!--    <div align="center" class = "container box">-->
        <table class="content-table" id = "info-box">
            <thead>
            <tr>
<!--                TODO:use backend to get these 3 atrribute-->
                <td>Course ID</td>
                <td>SubjectID</td>
                <td>SubjectName</td>
                <td>Semester</td>
                <td>Year Begin</td>
                <td>Year End</td>
            </tr>
            </thead>
            <tbody>
                <?php $controller->getCourseAndSubject();?>
            </tbody>
        </table>
        <br/>
        <br/>
        <table>
<!--            TODO: Add a cathi available to hoc phan for dang ky-->
        </table>
<!--    </div>-->
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
