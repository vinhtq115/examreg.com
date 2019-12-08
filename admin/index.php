<?php 
	require('connect/db_connect.php');
	require('Classes/PHPExcel.php');

	if(isset($_POST['btnGui'])){
		$file = $_FILES['file']['tmp_name']; // the file here is type not name

		$objReader = PHPExcel_IOFactory::createReaderForFile($file);
		$objReader->setLoadSheetsOnly('Sheet1');

		$objExcel = $objReader->load($file);
		$sheetData = $objExcel->getActiveSheet()->toArray('null' , true , true , true);
		//print_r($sheetData);

		$highestRow = $objExcel->setActiveSheetIndex()->getHighestRow();
		for($row = 2 ; $row <= $highestRow ; $row ++){
			$CustomerID = $sheetData[$row]['A'];
			$CustomerName = $sheetData[$row]['B'];
			$Address = $sheetData[$row]['C'];
			$City = $sheetData[$row]['D'];
			$PostalCode = $sheetData[$row]['E'];
			$Country = $sheetData[$row]['F'];

			$sql = "INSERT INTO `test`(`CustomerID`, `CustomerName`, `Address`, `City`, `PostalCode`, `Country`) VALUES ('$CustomerID','$CustomerName','$Address','$City','$PostalCode','$Country')";
			$mysqli->query($sql);
		
		}echo "Inserted!";
	}
?>
<!Doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Import data</title>
		<link rel = "stylesheet" href = "">
	</head>
	<body>
		<form method = "POST" enctype="multipart/form-data">
			<input type="file" name="file">
			<button type = "submit" name = "btnGui">Import</button>
		</form>
	</body>
</html>