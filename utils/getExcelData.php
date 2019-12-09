<?php
require dirname(__FILE__) . "/../vendor/autoload.php";
require_once dirname(__FILE__) . "/../vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/IOFactory.php"; // include phpspreadsheet from vendor

use PhpOffice\PhpSpreadsheet\Spreadsheet;

function getExcelReturnData($inputFileName){
    $spreadsheet = new Spreadsheet();

    // Identify the type of $inputFileName
    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
    // Create a new Reader of the type that has been identified
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
    // Advise the Reader that we only want to load cell data
    $reader->setReadDataOnly(true);

    $worksheetData = $reader

    /*


    // Load $inputFileName to a Spreadsheet Object
    $reader->setLoadSheetsOnly('Sheet1');
    $spreadsheet = $reader->load($inputFileName);
    $sheetData = $spreadsheet->getActiveSheet()->toArray('null', true, true, true);
    return $sheetData;*/
}

