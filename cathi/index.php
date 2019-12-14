<?php
    require_once dirname(__FILE__)."/../account/controller/LogoutController.php";
    require_once dirname(__FILE__)."/../utils/Utils.php";
    session_start();
    if($_SESSION["isAdmin"] != 1){
        header("Location:http://examreg.com/account/view/LogoutView.php");
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý ca thi</title>
    <!--Font Awesome-->
    <link rel="stylesheet" href="../externals/fontawesome/css/all.min.css">
    <!--Bootstrap core CSS-->
    <link rel="stylesheet" href="../externals/bootstrap/css/bootstrap.min.css">
    <!--Material Design Bootstrap-->
    <link rel="stylesheet" href="../externals/MDB/css/mdb.min.css">
    <!--MDBootstrap Datatables-->
    <link rel="stylesheet" href="../externals/MDB/css/addons/datatables.min.css">
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
    <link rel="stylesheet" href="../css/custom.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/kythi.css">
</head>
<body>
    <?php
        // Kiểm tra xem kỳ thi có tồn tại hay không
        $kythi = $_GET["kythi"];
        require_once dirname(__FILE__)."/../kythi/controller/KythiController.php";
        $kythictrl = new kythi\controller\KythiController();
        if (!$kythictrl->check($kythi)) {
            header("Location: http://examreg.com/404.html");
        }
        // Kỳ thi tồn tại trong hệ thống
        require_once dirname(__FILE__)."/controller/CathiController.php";
        $cathictrl = new \cathi\controller\CathiController($kythi);
        include dirname(__FILE__)."/../include/header.php";
        echo "<p id='kythi' hidden>".$_GET["kythi"]."</p>"; // Chứa mã kỳ thi
    ?>
    <div id="main">
        <!-- Thông tin kỳ thi -->
        <div>
            <?php
                $years = $cathictrl->getYear()[0];
                $nambatdau = $years["nambatdau"];
                $namketthuc = $years["namketthuc"];
                $ky = $years["ky"];
                echo "<p>Mã kỳ thi: ".$_GET["kythi"]."<br>";
                echo "Năm bắt đầu: ".$nambatdau."<br>";
                echo "Năm kết thúc: ".$namketthuc."<br>";
                echo "Kỳ: ".$ky."</p>";
            ?>
        </div>
        <!-- Danh sách ca thi -->
        <div id="table">
            <div id="table-container">
                <?php
                    $table = $cathictrl->table();
                    echo $table;
                    echo "<p id='tablehash' hidden>".hash("sha256", $table)."</p>";
                ?>
            </div>
        </div>
        <div id='datalistcontainer'>
            <?php
            echo $cathictrl->datalist();
            echo $cathictrl->datalist_hocphan();
            ?>
        </div>
        <div>
            <h3>Thêm ca thi</h3>
            <?php
                // Form thêm ca thi
                echo $cathictrl->showAdd();
            ?>
        </div>
        <div>
            <h3>Xóa ca thi</h3>
            <div id="cathidangxoa"></div>
            <?php
                // Form xóa ca thi
                echo $cathictrl->showDelete();
            ?>
        </div>
        <div>
            <h3>Sửa ca thi</h3>
            <div id="cathidangsua"></div>
            <?php
                // Form sửa ca thi
                echo $cathictrl->showEdit();
            ?>
        </div>
    </div>
    <script src="/cathi/script.js"></script>
</body>
