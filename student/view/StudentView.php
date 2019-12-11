<?php
require_once dirname(__FILE__)."/../../account/controller/LogoutController.php";
session_start();
require_once dirname(__FILE__)."/../controller/StudentController.php";

if($_SESSION["isAdmin"] != 1 && $_SESSION["isAdmin"] != 0){
    header("Location:http://examreg.com/account/view/LogoutView.php");
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
        .current{
            font-family: sans-serif;
            color: #ffffff;
            font-size: x-large;
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
<!--    <ul class ="navbar-nav">-->
<!--        <li class="current">Xin chào --><?php //echo $_SESSION["id"]?><!--</li>-->
<!--    </ul>-->
</nav>
<div id="side-menu" class="side-nav">
    <a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
    <a href="http://examreg.com/account/view/ChangePassView.php">Change Password</a>
    <a href="http://examreg.com/account/view/LogoutView.php">Log out</a>
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
    <div align="center" class = "container box">
        <table class="content-table">
            <thead>
            <tr>
                <td>Course ID</td>
                <td>SubjectID</td>
                <td>SubjectName</td>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
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
