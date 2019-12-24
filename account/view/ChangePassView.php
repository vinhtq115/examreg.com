<?php
session_start();
require_once dirname(__FILE__)."/../controller/LogoutController.php";
require_once dirname(__FILE__)."/../controller/ChangePassController.php";
if(!isset($_SESSION["isAdmin"])){
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
    <title>Đổi Mật Khẩu</title>
    <link href="/../../externals/bootstrap/css/bootstrap.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/../../css/responsive.css">
    <link rel="stylesheet" type="text/css" href="/../../css/changePass.css">
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
           <img src="/../../css/img/logo.png" alt="examregImage">
      </a>
    </span>
</nav>
<div id="side-menu" class="side-nav">
    <a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
    <!--    <a href="http://examreg.com/admin/view/AdminView.php" ><img src = "/css/img/smallhome.png">HomePage</a>-->
    <!--    <a href="http://examreg.com/monthi/"><img src = "/css/img/smallbook.png">Subjects</a>-->
    <!--    <a href="http://examreg.com/hocphan/"><img src = "/css/img/smallglass.png">Courses</a>-->
    <!--    <a href="http://examreg.com/kythi/"><img src = "/css/img/term.png">Term</a>-->
    <!--    <a href="http://examreg.com/quanlyphongthi/"><img src = "/css/img/lamp.png">Room</a>-->
    <!--    <a href="http://examreg.com/admin/getStudentIndex/"><img src = "/css/img/smallStudent.png">Student</a>-->
    <?php
    $con = new ChangePassController();
    $con->returnOption();
    ?>
    <a href="http://examreg.com/account/view/LogoutView.php"><img src = "/css/img/smalldoor.png">Đăng xuất</a>
</div>

<div id="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" id = "title">Đổi Mật Khẩu</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Mật khẩu mới</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="newpass" required = "required" placeholder="Nhập mật khẩu">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Nhập lại mật khẩu mới</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="renewpass" required = "required" placeholder="Xin hãy nhập ">
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" name = "changePass">
                                    Thay đổi mật khẩu
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