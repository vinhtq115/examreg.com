<?php
//require_once ("../controller/LogoutController.php");
require_once ("../account/controller/LogoutController.php");
$logout = new LogoutController();
$logout -> endSession();