<?php 
$mysqli = mysqli_connect('localhost' , 'root' , '' , 'excel_demo');
$mysqli->set_charset('utf8');
if(mysqli_connect_error()){
	echo 'Connect Failed'.mysqli_connect_error();
	exit;
}
?>