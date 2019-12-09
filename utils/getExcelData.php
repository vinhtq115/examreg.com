<?php
require dirname(__FILE__) . "/../vendor/autoload.php";
require_once dirname(__FILE__) . "/../vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/IOFactory.php"; // include phpspreadsheet from vendor
/**
 * the file is call to read parsed excel file and return the data
 * @param $inputFileName
 * @return array
 * @throws \PhpOffice\PhpSpreadsheet\Exception
 * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
 */
function getExcelReturnData($inputFileName){
//    $inputFileName = $_FILES['file']['name']; // file name
    //$inputFileName = "studentExcel.xlsx";
    /**  Identify the type of $inputFileName  **/
    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
    /**  Create a new Reader of the type that has been identified  **/
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
    /**  Load $inputFileName to a Spreadsheet Object  **/
    $reader->setLoadSheetsOnly('Sheet1');
    $spreadsheet = $reader->load($inputFileName);
    $sheetData = $spreadsheet->getActiveSheet()->toArray('null', true, true, true);
    return $sheetData;
}
?>