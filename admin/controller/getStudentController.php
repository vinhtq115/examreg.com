<?php
//include the tool to be able to get data from Excell xls file
require_once dirname(__FILE__)."../PHPExcel/IOFactory.php";
require_once dirname(__FILE__)."../view/getStudentView.php";
require_once dirname(__FILE__)."../model/getStudentModel.php";
class getStudentController
{
    private $view; // set up view Class
    private $model; // set up model
    private $output; // this is for the view
    function __construct()
    {
        $this ->view =  new getStudentView();
        $this ->model = new getStudentModel();
    }

    public function showInterface(){
        return $this->view->getStudentExcelInterface();
    }
    function getStudentExcel(){
    if(isset($_POST["import"])){
        $extension = end(explode(".", $_FILES["excel"]["name"])); // Getting Extension of selected file
        $allowed_extension = array("xls" , "xlsx" , "csv"); // the file extension of excel which is allowed
        if(in_array($extension , $allowed_extension)){
                $StudentPhpExcel = PHPExcel_IOFactory::load(/*$file*/); // create object of PHPExcel ;
                foreach ($StudentPhpExcel->getWorksheetIterator() as $worksheet){
                    
                }
            }
        }
    }
}