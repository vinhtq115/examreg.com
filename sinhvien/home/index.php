<?php
    session_start();
    if($_SESSION["isAdmin"] != 0 || !isset($_SESSION["id"])) {
        header("Location:http://examreg.com/");
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sinh viên</title>
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
    <!--MDB core JavaScript-->
    <script src="/externals/MDB/js/mdb.min.js"></script>
    <!--MDBootstrap Datatables-->
    <script src="/externals/MDB/js/addons/datatables.min.js"></script>
    <!--Custom CSS-->
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body>
    <?php
        require_once dirname(__FILE__)."/controller/SinhvienController.php";
        $controller = new \sinhvien\home\controller\SinhvienController($_SESSION["id"]);
    ?>
    <!--Thanh điều hướng-->
    <nav class="navbar navbar-expand-lg navbar-dark primary-color">
        <a class="navbar-brand" href="/">ExamReg</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link disabled" href="/sinhvien/home">Trang chủ</a>
                </li>
                <?php
                    if ($controller->isQualified()) { // Nếu đủ điều kiện dự thi
                        $_SESSION["dudieukienduthi"] = true;
                        echo "<li class='nav-item'>
                                <a class='nav-link' href='/sinhvien/dangkythi'>Đăng ký thi</a>
                              </li>
                              <li class='nav-item'>
                                <a class='nav-link' href='/sinhvien/indangkythi'>In đăng ký thi</a>
                              </li>";
                    } else {
                        $_SESSION["dudieukienduthi"] = false;
                    }
                ?>
            </ul>
            <ul class="navbar-nav mr-1">
                <li class="nav-item">
                    <a class="nav-link" href="/account/view/ChangePassView.php"><i class="fas fa-lock"></i>Đổi mật khẩu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/account/view/LogoutView.php"><i class="fas fa-sign-out-alt"></i>Đăng xuất</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="main">
        <?php
            echo $controller->showWelcomeMessage();
            echo $controller->showCurrentSemester();
            echo $controller->showInstruction();
        ?>
    </div>
</body>
</html>
