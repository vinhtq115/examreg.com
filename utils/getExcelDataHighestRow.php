<?php

require dirname(__FILE__) . "/../vendor/autoload.php";
require_once dirname(__FILE__) . "/../vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/IOFactory.php"; // include phpspreadsheet from vendor
/**
 * Trả về số dòng
 * @param $inputFileName
 * @return int
 * @throws \PhpOffice\PhpSpreadsheet\Exception
 * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
 */
function getExcelDataHighestRow($inputFileName)
{
    /**  Nhận dạng kiểu của file  **/
    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
    /**  Tạo Reader ứng với kiểu file  **/
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
    /**  Tải file vào Spreadsheet Object  **/
    $reader->setLoadSheetsOnly('Sheet1');
    $spreadsheet = $reader->load($inputFileName);

    $highestRow = $spreadsheet->setActiveSheetIndex(0)->getHighestRow();
    return $highestRow;
}

