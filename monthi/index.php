<?php
    session_start();
    if($_SESSION["isAdmin"] != 1){
        header("Location:http://examreg.com/");
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý môn thi</title>
    <!--Font Awesome-->
    <link rel="stylesheet" href="/externals/fontawesome/css/all.min.css">
    <!--Bootstrap core CSS-->
    <link rel="stylesheet" href="/externals/bootstrap/css/bootstrap.min.css">
    <!--Material Design Bootstrap-->
    <link rel="stylesheet" href="/externals/MDB/css/mdb.min.css">
    <!--MDBootstrap Datatables-->
    <link rel="stylesheet" href="/externals/MDB/css/addons/datatables.min.css">
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
    <!--<link rel="stylesheet" href="/css/header.css">-->
</head>
<body>
    <?php
        /*include dirname(__FILE__)."/../include/header.php";*/
    ?>
    <!--Thanh điều hướng-->
    <nav class="navbar navbar-expand-lg navbar-dark primary-color">
        <!-- Tên trang web -->
        <a class="navbar-brand" href="/">ExamReg</a>
        <!-- Nội dung thanh điều hướng -->
        <div class="collapse navbar-collapse">
            <!-- Đường dẫn -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Trang chủ</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link disabled" href="/monthi">Môn thi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/hocphan">Học phần</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/kythi">Kỳ thi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/quanlyphongthi">Phòng thi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/getStudentIndex/">Sinh viên</a>
                </li>
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
        <!-- Danh sách môn thi -->
        <div id="table">
            <div id="table-container">
                <?php
                    require_once dirname(__FILE__)."/controller/MonthiController.php";
                    $monthictrl = new \monthi\controller\MonthiController();
                    $table = $monthictrl->table();
                    echo $table;
                    echo "<p id='tablehash' hidden>".hash("sha256", $table)."</p>";
                ?>
            </div>
            <div id='datalistcontainer'>
                <?php
                    echo $monthictrl->datalist();
                ?>
            </div>
        </div>
        <div>
            <h3>Thêm môn thi</h3>
            <?php
                // Form thêm môn thi
                echo $monthictrl->showAdd();
            ?>
        </div>
        <div>
            <h3>Xóa môn thi</h3>
            <div id="mondangxoa"></div>
            <?php
                // Form xóa môn thi
                echo $monthictrl->showDelete();
            ?>
        </div>
        <div>
            <h3>Sửa môn thi</h3>
            <div id="mondangsua"></div>
            <?php
                // Form sửa môn thi
                echo $monthictrl->showEdit();
            ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>