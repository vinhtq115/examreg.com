<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý học phần</title>
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
    <div id="table">
        <!-- Danh sách học phần -->
        <div id="table-container">
            <?php
                require_once dirname(__FILE__)."/controller/HocphanController.php";
                $hocphanctrl = new \hocphan\controller\HocphanController();
                $table = $hocphanctrl->table();
                echo $table;
                echo "<p id='tablehash' hidden>".hash("sha256", $table)."</p>";
            ?>
        </div>
    </div>
    <div>
        <h3>Thêm học phần</h3>
        <?php
            // Form thêm học phần
            echo $hocphanctrl->showAdd();
        ?>
    </div>
    <div>
        <h3>Xóa học phần</h3>
        <div id="hocphandangxoa"></div>
        <?php
            // Form xóa môn thi
            echo $hocphanctrl->showDelete();
        ?>
    </div>
    <script src="script.js"></script>
</body>
</html>