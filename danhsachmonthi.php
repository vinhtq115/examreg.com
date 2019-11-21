<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Danh sách môn thi</title>
    <link rel="stylesheet" href="bootstrap/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body>
    <!-- Danh sách môn thi -->
    <?php
    require_once ("monthi/controller/MonthiController.php");

    $monthictrl = new \monthi\controller\MonthiController();

    $monthictrl->table();
    // Form thêm môn thi
    $monthictrl->showAdd();
    // Form xóa môn thi
    $monthictrl->showDelete();
    ?>
    <script>
        function showHint(str) {
            
        }
    </script>
</body>
</html>