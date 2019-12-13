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
        $stmt = $model->getStudentInfo($ssid); //get student info
        $stmt->execute([$id,$idsinhvien,$hodem,$ten]);
        //echo $stmt->rowCount();
        if($stmt->rowCount()){
            while($row= $stmt->fetch()){ // this will only run one time
                echo "<tr><td>".$row["idsinhvien"]."</td><td>".$row["hodem"]."</td><td>".$row["ten"]."</td></tr>";
            }
        }
    }

    public function getCourseAndSubject(){
        $svid = $_SESSION["id"]; // get the session , the Session will alway be initialized
        // by the function above as controller will call it first
        $model = new StudentModel();
        $mahocphan = "";
        $idhocky = "";
        $stmt = $model->CourseOfStudent($svid); // this get all the courses ID of the student loggin in
        $stmt -> execute([$mahocphan,$idhocky]); // it have the ID of the course's semester as well
        if($stmt->rowCount()){
           while($row = $stmt->fetch()){ // for every row return a courseID and a semID
               $courseID = $row["mahocphan"]; // get course ID
               $semID = $row["idhocky"];//get the semester
               //this part get the subject
               $new_stmt = $model->getSubjectSt($courseID); //get the subject of course
               $mamonthi = "";
               $tenmonthi = "";
               //this part get the semester info
               $new_stmt2 = $model->getSemester($semID);
               $ky = "";
               $nambatdau = "";
               $namketthuc = "";
               $new_stmt2->execute([$ky,$nambatdau,$namketthuc]);
               $new_stmt-> execute([$mamonthi ,$tenmonthi]); //new variance for data to parse to fetch
               while($new_row = $new_stmt->fetch()){
                   $new_sem = $new_stmt2->fetch(); // this will fetch once only
                   echo "<tr><td>".$courseID."</td><td>".$new_row["mamonthi"]."</td><td>".$new_row["tenmonthi"]."</td>
                         <td>".$new_sem["ky"]."</td><td>".$new_sem["nambatdau"]."</td><td>".$new_sem["namketthuc"]."</td></tr>";
               }
           }
        }
    }
}