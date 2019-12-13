<?php
//include the tool to be able to get data from Excell xls file
//include dirname(__FILE__)."/../Classes/PHPExcel.php";
//require_once dirname(__FILE__)."/../view/getStudentView.php";
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
                $stmt = $model->getIDOnly($id);
                $idSV = ""; // this won't do much
                $stmt ->fetch([$idSV]);
                if($stmt->rowCount() > 0){ // the id already exist
                    $model -> UpdateStudentInfo($id , $hodem , $ten , $ngaysinh); // update the information of the id
                    $model -> UpdateAccount($pass,$id); // update the password of the Student
                }else{ //the id doesn't exist
                    $model -> addStudentData($id , $hodem , $ten , $ngaysinh);
                    $model -> createStudentAccount($pass,$id);
                }
            }
        }
    }

    function  updateDisqualified(){ // this function is to update the student that is not qualified to take exam
        if(isset($_POST['UpdateDis'])){
            $file = $_FILES['file']['tmp_name']; // the file here is type not name
            $sheetData = getExcelReturnData($file);
            for($row = 2 ; $row <= sizeof($sheetData) ; $row ++){ // iterate through the row , data start from 2
                $idsinhvien = $sheetData[$row]['A'];
                $qualification = $sheetData[$row]['B'];
                $model = new getStudentModel();
                $model->updateDisqualifiedStudent($idsinhvien,$qualification);
            }
        }
    }

    function updateCourseSem(){ // update hoc phan trong hoc ky
        if(isset($_POST["UpdateCourses"])){
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

    function DeleteStudent(){
        if(isset($_POST["DeleteStudent"])){
            $file = $_FILES['file']['tmp_name']; // the file here is type not name
            $sheetData = getExcelReturnData($file);

            for($row = 2 ; $row <= sizeof($sheetData) ; $row ++){ // iterate through the row , data start from 2
                $id = $sheetData[$row]['A'];
                $model = new getStudentModel();
                $model->DeleteStudentWID($id);
            }
        }
    }

    function getStudentData() // This will get Student info and desplay on the screen
    { // get the student data
        $usermodel = new getStudentModel();
        $id = "";
        $hodem = "";
        $ten = "";
        $ngaythi = "";
        $dudieukienthi = "";
        $stmt = $usermodel->getStudentInfo();
        $stmt->execute([$id,$hodem,$ten,$ngaythi,$dudieukienthi]); // The info will be parsed to these variance
        //echo $stmt->rowCount();
        if($stmt->rowCount()){
            while($row= $stmt->fetch()){
                echo "<tr><td>".$row['id']."</td><td>".$row["hodem"]."</td><td>".$row["ten"]."</td><td>".$row["ngaysinh"]."</td><td>".$row["dudieukienduthi"]."</td></tr>";
            } // print the vars out on the table
        }
    }

    function getSVCourseSem() // This will get Student info and desplay on the screen
    { // get the student data
        $usermodel = new getStudentModel();
        $masinhvien = "";
        $mahocphan = "";
        $idhocky = "";
        $stmt = $usermodel->getStudentCourseHKInfo();
        $stmt->execute([$masinhvien,$mahocphan,$idhocky]); // The info will be parsed to these variance
        //echo $stmt->rowCount();
        if($stmt->rowCount()){
            while($row= $stmt->fetch()){
                echo "<tr><td>".$row['masinhvien']."</td><td>".$row["mahocphan"]."</td><td>".$row["idhocky"]."</td></tr>";
            } // print the vars out on the table
        }
    }

    function deleteCourse(){
        if(isset($_POST["DeleteCourse"])){
            $sinhvien = $_POST["sinhvienID"];
            $hocphan = $_POST["courseID"];
            $hocky = $_POST["semID"];
            $model = new getStudentModel();
            $model->deleteCourseHK($sinhvien,$hocphan,$hocky);
        }
    }
}

//$control = new getStudentController();
//$control->getStudentData();
