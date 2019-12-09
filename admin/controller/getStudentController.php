<?php
//include the tool to be able to get data from Excell xls file
//include dirname(__FILE__)."/../Classes/PHPExcel.php";
require_once dirname(__FILE__)."/../view/getStudentView.php";
require_once dirname(__FILE__)."/../model/getStudentModel.php";
require_once dirname(__FILE__)."/../../utils/getExcelData.php";
class getStudentController
{
    private $model; // set up model
    function __construct(){

    }

    function getStudentExcel(){ // this controller to get student info from excell and get it to database
        if(isset($_POST['ImportStudent'])){
            $file = $_FILES['file']['tmp_name']; // the file here is type not name
            $sheetData = getExcelReturnData($file);

            for($row = 2 ; $row <= sizeof($sheetData) ; $row ++){ // iterate through the row , data start from 2
                $id = $sheetData[$row]['A'];
                $hodem = $sheetData[$row]['B'];
                $ten = $sheetData[$row]['C'];
                $ngaysinh = $sheetData[$row]['D'];
                $account = $sheetData[$row]['E'];
                $pass = $sheetData[$row]['F'];
                $model = new getStudentModel();
                $model -> addStudentData($id , $hodem , $ten , $ngaysinh);
                $model -> createStudentAccount($pass,$id);
            }
        }
    }

    function  updateDisqualified(){ // this function is to update the student that is not qualified to take exam
        if(isset($_POST['UpdateDis'])){
            $file = $_FILES['file']['tmp_name']; // the file here is type not name
            $sheetData = getExcelReturnData($file);
            print_r($sheetData);
            for($row = 2 ; $row <= sizeof($sheetData) ; $row ++){ // iterate through the row , data start from 2
                $idsinhvien = $sheetData[$row]['A'];
                $qualification = $sheetData[$row]['B'];
                $model = new getStudentModel();
                $model->updateDisqualifiedStudent($idsinhvien,$qualification);
            }
        }
    }

    function updateCourseSem(){ // update hoc phan trong hoc ky
        if(isset($_POST[""])){
            $file = $_FILES['file']['tmp_name']; // the file here is type not name
            $sheetData = getExcelReturnData($file);

            for($row = 2 ; $row <= sizeof($sheetData) ; $row ++){ // iterate through the row , data start from 2
                $id = $sheetData[$row]['A'];
                $courseID = $sheetData[$row]['B'];
                $kythi = $sheetData[$row]['C'];
                $model = new getStudentModel();
                $model->updateCourse($id , $courseID , $kythi);
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
