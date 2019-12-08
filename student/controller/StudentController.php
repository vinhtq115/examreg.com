<?php
session_start();
require_once dirname(__FILE__)."/../model/StudentModel.php";


class StudentController{
    public function getSelf(){
        $ssid = $_SESSION["id"];
        $model = new StudentModel();
        $id = '';
        $idsinhvien = '';
        $hodem = '';
        $ten = '';
        $stmt = $model->getStudentInfo($ssid);
        $stmt->execute([$id,$idsinhvien,$hodem,$ten]);
        //echo $stmt->rowCount();
        if($stmt->rowCount()){
            while($row= $stmt->fetch()){ // this will only run one time
                $_SESSION["IDSV"] = $row["idsinhvien"];
                echo "<tr><td>".$row["idsinhvien"]."</td><td>".$row["hodem"]."</td><td>".$row["ten"]."</td></tr>";
            }
        }
    }

    public function getCourseAndSubject(){
        $svid = $_SESSION["IDSV"]; // get the session , the Session will alway be initialized
        // by the function above as controller will call it first
        $model = new StudentModel();
        $mahocphan = "";
        $idhocky = "";
        $stmt = $model->CourseOfStudent(); // this get all the courses ID of the student loggin in
        $stmt -> execute([$mahocphan,$idhocky]);
        if($stmt->rowCount()){
           while($row = $stmt->fetch()){
               $ranID = $row["mahocphan"];
               $new_stmt = $model->getSubjectSt($ranID);
               $mamonthi = "";
               $tenmonthi = "";
               $new_stmt-> execute([$mamonthi ,$tenmonthi]);
               while($new_row = $new_stmt->fetch()){
                   echo "<tr><td>".$ranID."</td><td>".$new_row["mamonthi"]."</td><td>".$new_row["tenmonthi"]."</td></tr>";
               }
           }
        }
    }
}