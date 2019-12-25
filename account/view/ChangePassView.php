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
    <!--Font Awesome-->
    <link rel="stylesheet" href="../../externals/fontawesome/css/all.min.css">
    <!--Bootstrap core CSS-->
    <link rel="stylesheet" href="../../externals/bootstrap/css/bootstrap.min.css">
    <!--Material Design Bootstrap-->
    <link rel="stylesheet" href="../../externals/MDB/css/mdb.min.css">
    <!--MDBootstrap Datatables-->
    <link rel="stylesheet" href="../../externals/MDB/css/addons/datatables.min.css">
    <!--JQuery-->
    <script src="/externals/jquery/jquery-3.4.1.min.js"></script>
    <!--Bootstrap tooltips-->
    <script src="/externals/popper.js/umd/popper.min.js"></script>
    <!--Bootstrap core JavaScript-->
    <script src="/externals/bootstrap/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/changePass.css">
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body>
<?php
    if ($_SESSION["isAdmin"] == 1) {
        echo "<!--Thanh điều hướng cho admin-->
    <nav class=\"navbar navbar-expand-lg navbar-dark primary-color\">
        <!-- Tên trang web -->
        <a class=\"navbar-brand\" href=\"/\">ExamReg</a>
        <!-- Nội dung thanh điều hướng -->
        <div class=\"collapse navbar-collapse\">
            <!-- Đường dẫn -->
            <ul class=\"navbar-nav mr-auto\">
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"/\"><img src = \"/css/img/smallhome.png\">Trang chủ</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"/monthi\"><img src = \"/css/img/smallbook.png\">Môn thi</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"/hocphan\"><img src = \"/css/img/smallglass.png\">Học phần</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"/kythi\"><img src = \"/css/img/term.png\">Kỳ thi</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"/quanlyphongthi\"><img src = \"/css/img/lamp.png\">Phòng thi</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"/admin/getStudentIndex/\"><img src = \"/css/img/smallStudent.png\">Sinh viên</a>
                </li>
            </ul>
            <ul class=\"navbar-nav mr-1\">
                <li class=\"nav-item active\">
                    <a class=\"nav-link disabled\" href=\"/account/view/ChangePassView.php\"><img src = \"/css/img/smalltext.png\">Đổi mật khẩu</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"/account/view/LogoutView.php\"><img src = \"/css/img/smalldoor.png\">Đăng xuất</a>
                </li>
            </ul>
        </div>
    </nav>";
    } else {
        echo "<!--Thanh điều hướng cho sinh viên-->
    <nav class=\"navbar navbar-expand-lg navbar-dark primary-color\">
        <a class=\"navbar-brand\" href=\"/\">ExamReg</a>
        <div class=\"collapse navbar-collapse\">
            <ul class=\"navbar-nav mr-auto\">
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"/sinhvien/home\"><img src = \"/css/img/smallhome.png\">Trang chủ</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='/sinhvien/dangkythi'><img src = \"/css/img/register.png\">Đăng ký thi</a>
                </li>
            </ul>
            <ul class=\"navbar-nav mr-1\">
                <li class=\"nav-item active\">
                    <a class=\"nav-link disabled\" href=\"/account/view/ChangePassView.php\"><img src = \"/css/img/smalltext.png\">Đổi mật khẩu</a>
                </li>
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"/account/view/LogoutView.php\"><img src = \"/css/img/smalldoor.png\">Đăng xuất</a>
                </li>
            </ul>
        </div>
    </nav>";
    }
?>
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
</body>
</html>