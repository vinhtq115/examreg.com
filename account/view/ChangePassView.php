<?php
session_start();
require_once dirname(__FILE__)."/../controller/LogoutController.php";
require_once dirname(__FILE__)."/../controller/ChangePassController.php";

if($_SESSION["isAdmin"] != 1 && $_SESSION["isAdmin"] != 0){
    header("Location:http://examreg.com/account/view/LogoutView.php");
}

if(isset($_POST['changePass'])){ // upon submiting form , this will work
    $controller = new ChangePassController();
    $controller->changePass();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Change Password</title>
    <link href="/../../bootstrap/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/../../css/responsive.css">
    <style>
        .container{
            margin-top: 250px;
        }
        .navbar{
            background-color:#1FAADE;
            overflow:hidden;
            height:65px;
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
</nav>
<div id="side-menu" class="side-nav">
    <a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
    <a href="http://examreg.com/account/view/LogoutView.php">Log out</a>
</div>

<div id="main">
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Change Password</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">New Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="newpass" required = "required" placeholder="Type Your New Password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Check Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="renewpass" required = "required" placeholder="Type Your New Password Again">
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" name = "changePass">
                                    Change Password
                                </button>
                            </div>
                    </div>
                    </form>
                </div>
        </div>
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