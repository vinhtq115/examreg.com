<?php
require_once dirname(__FILE__)."/../../account/controller/LogoutController.php";
session_start();
if($_SESSION["isAdmin"] != 1){
    header("Location:http://examreg.com/account/view/LogoutView.php");
}
require_once dirname(__FILE__)."/../controller/getStudentController.php";

$getStudent = new getStudentController();
$getStudent -> showInterface();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Managing</title>
</head>
<body>
    <?php ?>
</body>
</html>