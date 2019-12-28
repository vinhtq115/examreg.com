<?php
require dirname(__FILE__) . "/../vendor/autoload.php";
require_once dirname(__FILE__) . "/../vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/IOFactory.php";

/**
 * Hàm lấy file excel và trả về mảng dữ liệu
 * @param $inputFileName
 * @return array
 * @throws \PhpOffice\PhpSpreadsheet\Exception
 * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
 */
function getExcelReturnData($inputFileName){
    /**  Lấy định dạng file  **/
    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
    /**  Tạo Reader ứng với dạng file  **/
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
    /**  Tải file vào một Spreadsheet Object  **/
    $reader->setLoadSheetsOnly('Sheet1');
    $spreadsheet = $reader->load($inputFileName);
    // Trả dữ liệu về mảng
    $sheetData = $spreadsheet->getActiveSheet()->toArray('null', true, true, true);
    return $sheetData;
}
