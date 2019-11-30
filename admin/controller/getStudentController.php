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
        $model = new getStudentModel();
        if(isset($_POST["import"])){
            $extension = end(explode(".", $_FILES["excel"]["name"])); // Getting Extension of selected file
            $allowed_extension = array("xls" , "xlsx" , "csv"); // the file extension of excel which is allowed
            if(in_array($extension , $allowed_extension)){
                $StudentPhpExcel = PHPExcel_IOFactory::load(/*$file*/); // create object of PHPExcel
                foreach ($StudentPhpExcel->getWorksheetIterator() as $worksheet){
                    $highestRow = $worksheet->getHighestRow(); //the index number of the last row
                    for($row = 2 ; $row <= $highestRow ; $row++) { // 0 : the A B C in excel, 1 : the columns name , from 2: the data
                        // get the data and use the mysqli function to make the string update-able to the database
                            $id = mysqli_real_escape_string($worksheet->getCellByColumnAndRow(0, $row)->getValue());
                            $middleName = mysqli_real_escape_string($worksheet->getCellByColumnAndRow(1, $row)->getValue());
                            $name = mysqli_real_escape_string($worksheet->getCellByColumnAndRow(2, $row)->getValue());
                            $DateOfBirth = mysqli_real_escape_string($worksheet->getCellByColumnAndRow(3, $row)->getValue());
                            $DieuKienBool = mysqli_real_escape_string($worksheet->getCellByColumnAndRow(4, $row)->getValue());
                            $this->model->addStudentData($id , $middleName , $name , $DateOfBirth , $DieuKienBool);
                    }
                }
            }
        }
    }
}