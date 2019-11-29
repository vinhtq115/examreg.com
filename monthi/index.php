<?php
require_once dirname(__FILE__)."/../../account/controller/LogoutController.php";
session_start();
if($_SESSION["isAdmin"] != 0 && $_SESSION["isAdmin"] != 1){
    header("Location:http://examreg.com/account/view/LogoutView.php");
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý môn thi</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/monthi.css">
</head>
<body>
    <!-- Danh sách môn thi -->
    <div id="table">
        <div id="table-container">
        <?php
            require_once dirname(__FILE__)."/controller/MonthiController.php";
            $monthictrl = new \monthi\controller\MonthiController();
            echo $monthictrl->table();
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
    <script src="script.js"></script>
</body>
</html>