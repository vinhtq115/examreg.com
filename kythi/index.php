<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý kỳ thi</title>
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
</head>
<body>
    <!-- Danh sách kỳ thi -->
    <div id="table">
        <div id="table-container">
            <?php
                require_once dirname(__FILE__)."/controller/KythiController.php";
                $kythictrl = new \kythi\controller\KythiController();
                echo $kythictrl->table();
            ?>
        </div>
        <div id='datalistcontainer'>
        </div>
    </div>
    <div>
        <h3>Thêm kỳ thi</h3>
        <?php
            // Form thêm kỳ thi
            echo $kythictrl->showAdd();
        ?>
    </div>
    <div>
        <h3>Xóa kỳ thi</h3>
        <div id="kythidangxoa"></div>
        <?php
            // Form xóa môn thi
            echo $kythictrl->showDelete();
        ?>
    </div>
    <div>
        <h3>Sửa kỳ thi</h3>
        <div id="kythidangsua"></div>
        <?php
            // Form sửa kỳ thi thi
            echo $kythictrl->showEdit();
        ?>
    </div>
    <!--<script src="script.js"></script>-->
</body>
</html>