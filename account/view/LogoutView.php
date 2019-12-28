<?php
    require_once dirname(__FILE__)."/../controller/LogoutController.php";
    // Tạo LogoutController và kết thúc session
    $logout = new LogoutController();
    $logout -> endSession();