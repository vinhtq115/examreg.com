<?php
//include the tool to be able to get data from Excell xls file
include dirname(__FILE__)."/../PHPExcelFile/Classes/PHPExcel/IOFactory.php";
require_once dirname(__FILE__)."/../view/getStudentView.php";
require_once dirname(__FILE__)."/../model/getStudentModel.php";
class getStudentController
{
    private $view; // set up view Class
    private $model; // set up model
    private $output; // this is for the view
    function __construct()
    {
        //$this ->view =  new getStudentView();
        //$this->view->getStudentExcelInterface();
        //$this -> getStudentExcel();
//        $this ->model = new getStudentModel();
//
//        if(isset($_POST["ImportStudent"])){ // the condition to start function upon clicking the button
//            $this->getStudentExcel();
//            // add view code here...
//        }
//        if(isset($_POST["ImportDisqualified"])){
//            $this->updateDisqualified(); // the condition to start function upon clicking the button
//            // add view code here...
//
//        }
//        if(isset($_POST["ImportCourse"])){
//            $this->updateCourseSem(); // the condition to start function upon clicking the button
//            // add view code here...
//
//        }

        //making buffer to call the view function so the index could call it!!!!!
    }

    function getStudentExcel(){ // this controller to get student info from excell and get it to database
 //       if(isset($_POST["ImportStudent"])){
//            $extension = end(explode(".", $_FILES["excel"]["name"])); // Getting Extension of selected file
//            $allowed_extension = array("xls" , "xlsx" , "csv"); // the file extension of excel which is allowed
//            if(in_array($extension , $allowed_extension)){

//                  $StudentPhpExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel
//                foreach ($StudentPhpExcel->getWorksheetIterator() as $worksheet){
//                    $highestRow = $worksheet->getHighestRow(); //the index number of the last row
//                    for($row = 2 ; $row <= $highestRow ; $row++) { // 0 : the A B C in excel, 1 : the columns name , from 2: the data
//                        // get the data and use the mysqli function to make the string update-able to the database
//                            $id = mysqli_real_escape_string($worksheet->getCellByColumnAndRow(0, $row)->getValue());
//                            $middleName = mysqli_real_escape_string($worksheet->getCellByColumnAndRow(1, $row)->getValue());
//                            $name = mysqli_real_escape_string($worksheet->getCellByColumnAndRow(2, $row)->getValue());
//                            $DateOfBirth = mysqli_real_escape_string($worksheet->getCellByColumnAndRow(3, $row)->getValue());
//                            $this->model->addStudentData($id , $middleName , $name , $DateOfBirth); // call model function
//                         //create account
//                            $account = mysqli_real_escape_string($worksheet->getCellByColumnAndRow(4, $row)->getValue());
//                            $password = mysqli_real_escape_string($worksheet->getCellByColumnAndRow(5, $row)->getValue());
//                            $this->model->createStudentAccount($account,$password,$id); // call model function
//                    }
//                }
//            }
       // }
    }

    function  updateDisqualified(){ // this function is to update the student that is not qualified to take exam
        if(isset($_POST["importDisqualified"])){
            $extension = end(explode(".", $_FILES["excel"]["name"]));
            $allowed_extension = array("xls" , "xlsx" , "csv");
            if(in_array($extension , $allowed_extension)){
                include dirname(__FILE__)."/../PHPExcelFile/Classes/PHPExcel/IOFactory.php";
                $file = $_FILES["excel"]["tmp_name"];// getting temporary source of excel file
                $StudentPhpExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel
                foreach ($StudentPhpExcel->getWorksheetIterator() as $worksheet){
                    $highestRow = $worksheet->getHighestRow(); //the index number of the last row
                    for($row = 2 ; $row <= $highestRow ; $row++) { // 0 : the A B C in excel, 1 : the columns name , from 2: the data
                        // get the data and use the mysqli function to make the string update-able to the database
                        $id = mysqli_real_escape_string($worksheet->getCellByColumnAndRow(0, $row)->getValue()); // get the ID of the Disqualified student
                        $this->model->updateDisqualifiedStudent($id);
                    }
                }
            }
        }
    }

    function updateCourseSem(){ // update hoc phan trong hoc ky
        if(isset($_POST["importCourse"])){
            include dirname(__FILE__)."/../PHPExcelFile/Classes/PHPExcel/IOFactory.php";

            $extension = end(explode(".", $_FILES["excel"]["name"]));
            $allowed_extension = array("xls" , "xlsx" , "csv");
            if(in_array($extension , $allowed_extension)){
                $file = $_FILES["excel"]["tmp_name"];// getting temporary source of excel file
                $StudentPhpExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel
                foreach ($StudentPhpExcel->getWorksheetIterator() as $worksheet){
                    $highestRow = $worksheet->getHighestRow(); //the index number of the last row
                    for($row = 2 ; $row <= $highestRow ; $row++) { // 0 : the A B C in excel, 1 : the columns name , from 2: the data
                        // get the data and use the mysqli function to make the string update-able to the database
                        $id = mysqli_real_escape_string($worksheet->getCellByColumnAndRow(0, $row)->getValue()); // get the ID of the  student
                        $courseid = mysqli_real_escape_string($worksheet->getCellByColumnAndRow(1, $row)->getValue());
                        $maky = mysqli_real_escape_string($worksheet->getCellByColumnAndRow(2, $row)->getValue());
                        $this->model->updateCourse($id,$courseid,$maky);
                    }
                }
            }
        }
    }

function getStudentData()
{ // get the student data
    $usermodel = new getStudentModel();
    $id = "";
    $hodem = "";
    $ten = "";
    $ngaythi = "";
    $dudieukienthi = "";
    $stmt = $usermodel->getStudentInfo();
    $stmt->execute([$id,$hodem,$ten,$ngaythi,$dudieukienthi]);
    //echo $stmt->rowCount();
    if($stmt->rowCount()){
        while($row= $stmt->fetch()){
            echo "<tr><td>".$row['id']."</td><td>".$row["hodem"]."</td><td>".$row["ten"]."</td><td>".$row["ngaysinh"]."</td><td>".$row["dudieukienduthi"]."</td></tr>";
        }
    }
}}

//$control = new getStudentController();
//$control->getStudentData();
