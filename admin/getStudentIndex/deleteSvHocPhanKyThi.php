<?php
require_once dirname(__FILE__) . "/../model/getStudentModel.php";
$model = new getStudentModel();
$idsv = $_POST["id1"];
$hocphan = $_POST["id2"];
$hocki = $_POST["id3"];
$sql = "DELETE FROM `sinhvien_hoc_hocphan` WHERE `masinhvien`= '$idsv' AND `mahocphan` = '$hocphan' AND `idhocky`= '$hocki';"; // get POST id send w jquery
$model->TrySQL($sql); // this is to execute the sql