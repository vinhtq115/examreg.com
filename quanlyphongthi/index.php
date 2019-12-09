<?php
    require_once dirname(__FILE__)."/../account/controller/LogoutController.php";
    session_start();
    if($_SESSION["isAdmin"] != 1){
        header("Location:http://examreg.com/account/view/LogoutView.php");
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý phòng thi</title>
    <!--Font Awesome-->
    <link rel="stylesheet" href="../externals/fontawesome/css/all.min.css">
    <!--Bootstrap core CSS-->
    <link rel="stylesheet" href="../externals/bootstrap/css/bootstrap.min.css">
    <!--Material Design Bootstrap-->
    <link rel="stylesheet" href="../externals/MDB/css/mdb.min.css">
    <!--MDBootstrap Datatables-->
    <link rel="stylesheet" href="../externals/MDB/css/addons/datatables.min.css">
    <!--JQuery-->
    <script src="/jquery/jquery-3.4.1.min.js"></script>
    <!--Bootstrap tooltips-->
    <script src="../externals/popper.js/umd/popper.min.js"></script>
    <!--Bootstrap core JavaScript-->
    <script src="../externals/bootstrap/js/bootstrap.min.js"></script>
    <!--MDB core JavaScript-->
    <script src="../externals/MDB/js/mdb.min.js"></script>
    <!--MDBootstrap Datatables-->
    <script src="../externals/MDB/js/addons/datatables.min.js"></script>
    <!--Custom CSS-->
    <link rel="stylesheet" href="../css/custom.css">
    <link rel="stylesheet" href="../css/header.css">
</head>
<body>
    <?php
        include dirname(__FILE__)."/../include/header.php";
    ?>
    <div id="main">
        <!-- Danh sách phòng thi -->
        <div id="table">
            <div id="table-container">
                <?php
                    require_once dirname(__FILE__)."/controller/PhongthiController.php";
                    $phongthictrl = new \quanlyphongthi\controller\PhongthiController();
                    $table = $phongthictrl->table();
                    echo $table;
                    echo "<p id='tablehash' hidden>".hash("sha256", $table)."</p>";
                ?>
            </div>
            <div id='datalistcontainer'>
                <?php
                    echo $phongthictrl->datalist();
                ?>
            </div>
        </div>
        <div>
            <h3>Thêm phòng thi</h3>
            <?php
                // Form thêm phòng thi
                echo $phongthictrl->showAdd();
            ?>
        </div>
        <div>
            <h3>Xóa phòng thi</h3>
            <div id="phongthidangxoa"></div>
            <?php
                // Form xóa phòng thi
                echo $phongthictrl->showDelete();
            ?>
        </div>
        <div>
            <h3>Sửa phòng thi</h3>
            <div id="phongthidangsua"></div>
            <?php
                // Form sửa phòng thi
                echo $phongthictrl->showEdit();
            ?>
        </div>
    </div>
    <script src="script.js"></script>
    <script src="/externals/MDB/js/addons/datatables.min.js"></script>
</body>
</html>