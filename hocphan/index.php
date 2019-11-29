<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý học phần</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/monthi.css">
</head>
<body>
    <div id="table">
        <!-- Danh sách học phần -->
        <div id="table-container">
            <?php
                require_once dirname(__FILE__)."/controller/MonthiController.php";
                $monthictrl = new \monthi\controller\MonthiController();
                echo $monthictrl->table();
            ?>
        </div>
    </div>
    <div>
        <h3>Thêm học phần</h3>
        <?php
            // Form thêm học phần
            echo $monthictrl->showAdd();
        ?>
    </div>
    <div>
        <h3>Xóa học phần</h3>
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
    <script src="script.js"></script>
</body>
</html>