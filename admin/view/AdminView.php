<?php

    require_once ("../../account/controller/LogoutController.php");
    session_start();

    if($_SESSION["isAdmin"] != 1){
        header("Location:http://localhost/examreg.com/");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Administration's Homepage</title>
    <link rel="stylesheet" type="text/css" href="../../css/adminView.css">
    <script src="../../jquery/jquery-3.4.1.js"></script>
    <script>
        //take the logout function to the client
        $(document).ready(function(){
            $("#logout-btn").click(function() {
                window.location.href="http://localhost/examreg.com/account/view/LogoutView.php";
            });
        });
    </script>
</head>
<body>
<header>
    <div class="container">
        <div id="branding">
            <h1><span class="highlight">Exam</span>Reg</h1>
        </div>
        <nav>
            <ul>
                <li class="current"><a id = "logout-btn">Log out</a></li>
            </ul>
        </nav>
    </div>
</header>

<section id="showcase">
    <div class="container">
        <h1>Administration Of Exam Registration System</h1>
    </div>
</section>

<section id="boxes">
    <div class="container">
        <div class="box">
            <a href=""><img src="../../css/img/graduate-student.png"></a>
            <h3>Students Roaster</h3>
            <p>Administration keeping track and managing student profile which taking part in the examination</p>
        </div>
        <div class="box">
            <a href=""><img src="../../css/img/microscope.png"></a>
            <h3>Subjects List</h3>
            <p>Administration keeping track of subjects and courses of the examination</p>
        </div>
        <div class="box">
            <a href=""><img src="../../css/img/logo_brush.png"></a>
            <h3>The Exams</h3>
            <p>Administration creating and managing the upcoming examination </p>
        </div>
    </div>
</section>

<footer>
    <p>Admin home page</p>
</footer>

</body>
</html>