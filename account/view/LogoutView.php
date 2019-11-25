<?php
//require_once ("../controller/LogoutController.php");
require_once ("/Applications/XAMPP/xamppfiles/htdocs/examreg.com/account/controller/LogoutController.php");
$logout = new LogoutController();
$logout -> endSession();