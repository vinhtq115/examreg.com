<?php
require_once dirname(__FILE__)."/../controller/LogoutController.php";
$logout = new LogoutController();
$logout -> endSession();