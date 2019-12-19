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
            print_r($sheetData);
//            print(sizeof($sheetData[1])); // 6
            /**
             * preprocessing phase
             * the $sheetData should have highest Column equivalent to F
             * if they do , check every single column name (index at 1)
             * to make sure it have the same name
             **/
            $numberOfColumn = sizeof($sheetData[1]); // number of column of the file
            if($numberOfColumn != 6){ // the number column uploading this file will be 6
                echo '<script language="javascript">';
                echo 'window.alert("The file is not in right format , please try again");';
                echo '</script>';
                return ;
            }
            $temp = $sheetData[1]['A']; // initialie collumn
            $temp = preg_replace('/\s+/', '', $temp); // delete all  white space
            if($temp != "id"){
                echo '<script language="javascript">';
                echo 'window.alert("The file is not in right format , check the first column, which is supposed to be \'id\'");';
                echo '</script>';
                return;
            }
            $temp = $sheetData[1]['B'];
            $temp = preg_replace('/\s+/', '', $temp); // delete all  white space
            if($temp != "hodem"){
                echo '<script language="javascript">';
                echo 'window.alert("The file is not in right format , check the second column, which is supposed to be \'hodem\'");';
                echo '</script>';
                return;
            }
            $temp = $sheetData[1]['C'];
            $temp = preg_replace('/\s+/', '', $temp); // delete all  white space
            if($temp != "ten"){
                echo '<script language="javascript">';
                echo 'window.alert("The file is not in right format , check the third column, which is supposed to be \'ten\'");';
                echo '</script>';
                return;
            }
            $temp = $sheetData[1]['D'];
            $temp = preg_replace('/\s+/', '', $temp); // delete all  white space
            if($temp != "ngaysinh"){
                echo '<script language="javascript">';
                echo 'window.alert("The file is not in right format , check the fouth column, which is supposed to be \'ngaysinh\'");';
                echo '</script>';
                return;
            }
            $temp = $sheetData[1]['E'];
            $temp = preg_replace('/\s+/', '', $temp); // delete all  white space

            if($temp != "account"){
                    echo '<script language="javascript">';
                    echo 'window.alert("The file is not in right format , check the fifth column, which is supposed to be \'account\'");';
                    echo '</script>';
                    return;
            }
            $temp = $sheetData[1]['F'];
            $temp = preg_replace('/\s+/', '', $temp); // delete all  white space

            if($temp != "password"){
                echo '<script language="javascript">';
                echo 'window.alert("The file is not in right format , check the sixth column, which is supposed to be \'password\'");';
                echo '</script>';
                return;
            }

            /**
             * adding data to the database
            **/
//            we will create an array to report error in javascript
               $has_error = 0; // use to decide if should return ("Upload successfully or not")
               $missing_error = "Mising error on:";
            for($row = 2 ; $row <= sizeof($sheetData) ; $row ++) { // iterate through the row , data start from 2
                $execute = 1; // the flag value for error
                $missing_data = 0; // for every row of data we have a flag to know if it is wrong or not if it wrong dont add it
                $id = $sheetData[$row]['A'];
                if($id == "null"){
                    $missing_data = 1;
                    $execute = 0;
                    $has_error = 1;
                }
                echo $id;
                $hodem = $sheetData[$row]['B'];
                if($hodem == "null"){
                    $missing_data = 1;
                    $execute = 0;
                    $has_error = 1;
                }
                echo $hodem;
                $ten = $sheetData[$row]['C'];
                if($ten == "null"){
                    $missing_data = 1;
                    $execute = 0;
                    $has_error = 1;
                }
                echo $ten;
                $ngaysinh = $sheetData[$row]['D'];
                if($ngaysinh == "null"){
                    $missing_data = 1;
                    $execute = 0;
                    $has_error = 1;
                }
                echo $ngaysinh;
                $account = $sheetData[$row]['E']; // this is ignored
                $pass = $sheetData[$row]['F'];
                if($pass == "null"){
                    $missing_data = 1;
                    $execute = 0;
                    $has_error = 1;
                }
                echo $pass;
                if($missing_data == 1) // if there is a missing data error do this
                {
                    $missing_error += "\n line $row";
                }
                $model = new getStudentModel();
                $stmt = $model->getIDOnly($id);
                $idSV = ""; // this won't do much but helping fetch the data
                $stmt->fetch([$idSV]);
                if($execute == 1){ // no error happen
                    if ($stmt->rowCount() > 0) { // the id already exist
                        $model->UpdateStudentInfo($id, $hodem, $ten, $ngaysinh); // update the information of the id
                        $model->UpdateAccount($pass, $id); // update the password of the Student
                    } else{ //the id doesn't exist
                        $model->addStudentData($id, $hodem, $ten, $ngaysinh); // add the student info with new id
                        $model->createStudentAccount($pass, $id); // update student password
                    }}
            }
            $error = "";
            $error += $missing_error;
            if($has_error == 0) { // if error occur
                echo '<script language="javascript">';
                echo 'window.alert("Upload successfully");';
                echo '</script>';
            }
            else {
                echo "<script language = \"javascript\">
                       alert('<?php echo $error?>\);
                      </script>";
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
