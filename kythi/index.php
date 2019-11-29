<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý kỳ thi</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/monthi.css">
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