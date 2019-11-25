<?php


require_once dirname(__FILE__)."/account/controller/LoginController.php";

$usercontroller = new LoginController();
$usercontroller-> getLoginInfo();



