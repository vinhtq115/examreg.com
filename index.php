<?php
session_start();
require_once dirname(__FILE__)."/account/controller/LoginController.php";
require_once dirname(__FILE__)."/account/view/LoginView.php";
// Kiểm tra session
if($_SESSION["id"] != ""){
    if($_SESSION["isAdmin"] == 1){ // Nếu là admin thì đưa về menu admin
        header('Location: http://examreg.com/admin/view/AdminView.php');
    }else if($_SESSION["isAdmin"] == 0){ // Nếu là sinh viên thì đưa về menu sinh viên
        header('Location: http://examreg.com/sinhvien');
    }
}

?>
<!doctype html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\"
          content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
    <title>Exam Register</title>
    <link rel="stylesheet" href="/externals/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/externals/bootstrap-3.3.7-dist/css/bootstrap.css">
    <link rel="stylesheet" type = "text/css" href = "css/loginView.css">
    <script src="/externals/jquery/jquery-3.4.1.js" type = "text/javascript"></script>

</head>
<body>
<?php
        $usercontroller = new LoginController();
?>
</body>
</html>
