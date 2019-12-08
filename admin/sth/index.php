<?php
require('../Classes/PHPExcel.php');

if(isset($_POST['ImportStudent'])){
    $file = $_FILES['file']['tmp_name']; // the file here is type not name

    $objReader = PHPExcel_IOFactory::createReaderForFile($file);
    $objReader->setLoadSheetsOnly('Sheet1');

    $objExcel = $objReader->load($file);
    $sheetData = $objExcel->getActiveSheet()->toArray('null' , true , true , true);
    print_r($sheetData);

    $highestRow = $objExcel->setActiveSheetIndex()->getHighestRow();
    echo $highestRow;
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
<div class="container box">
    <h3 align="center">IMPORT STUDENT FILES</h3></h3><br />
    <form method="POST" enctype="multipart/form-data">
        <label>Select Excel File</label>
        <input type="file" name="file"/>
        <br />
        <button type="submit" name="ImportStudent" class="btn btn-info" value="Import Student">Import Students</button>
    </form>
    <br />
    <br />
</div>
</body>
</html>