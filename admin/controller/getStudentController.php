<?php
//include the tool to be able to get data from Excell xls file
include dirname(__FILE__)."/../Classes/PHPExcel.php";
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
        if(isset($_POST['ImportStudent'])){
           $file = $_FILES['file']['tmp_name']; // the file here is type not name

           		$objReader = PHPExcel_IOFactory::createReaderForFile($file);
           		$objReader->setLoadSheetsOnly('Sheet1');

           		$objExcel = $objReader->load($file);
           		$sheetData = $objExcel->getActiveSheet()->toArray('null' , true , true , true);
           		print_r($sheetData);
           
		        $highestRow = $objExcel->setActiveSheetIndex()->getHighestRow();

//            for($row = 2 ; $row <= $highestRow ; $row ++){ // run through the row
//                $id = $sheetData[$row]['A'];
//                $hodem = $sheetData[$row]['B'];
//                $ten = $sheetData[$row]['C'];
//                $ngaysinh = $sheetData[$row]['D'];
//                $account = $sheetData[$row]['E'];
//                $account = $sheetData[$row]['F'];
//                //These query job are for later
//
//                //$password;
//                //$sql = "INSERT INTO `test`(`CustomerID`, `CustomerName`, `Address`, `City`, `PostalCode`, `Country`) VALUES ('$CustomerID','$CustomerName','$Address','$City','$PostalCode','$Country')";
//                // need database connection
//                //$mysqli->query($sql);
//
//            }echo "Inserted!";
        }
    }

    function  updateDisqualified(){ // this function is to update the student that is not qualified to take exam
        if(isset($_POST['updateDis'])){
            $file = $_FILES['file']['tmp_name'];

            $objReader = PHPExcel_IOFactory::createReaderForFile($file); // creating reader for file
            $objReader->setLoadSheetsOnly('Sheet1'); // read a specific sheet only (for now hopefully)

            $objExcel = $objReader->load($file); // load file
            //Make sheetData
            $sheetData = $objExcel->getActiveSheet()->toArray('null' , true , true , true);
            print_r($sheetData); //print to easily debug and code it will return array with index

            $highestRow = $objExcel->setActiveSheetIndex()->getHighestRow(); // get the Highest arrow
            for($row = 2 ; $row <= $highestRow ; $row ++){ // run through the row
                $id = $sheetData[$row]['A'];
                //$password;
                //$sql = "INSERT INTO `test`(`CustomerID`, `CustomerName`, `Address`, `City`, `PostalCode`, `Country`) VALUES ('$CustomerID','$CustomerName','$Address','$City','$PostalCode','$Country')";
                // need database connection
                //$mysqli->query($sql);

            }echo "Inserted!";
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
