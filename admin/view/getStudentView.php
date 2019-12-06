<?php

class getStudentView{
    public function __construct() {

    }
    public function getStudentExcelInterface(){ // this is the form to get the data
        $html = "
            <div class=\"container box\">
                <h3 align=\"center\">IMPORT STUDENT FILES</h3></h3><br />
                <form method=\"post\" enctype=\"multipart/form-data\">
                    <label>Select Excel File</label>
                    <input type=\"file\" name=\"excel\" />
                    <br />
                    <input type=\"submit\" name=\"ImportStudent\" class=\"btn btn-info\" value=\"ImportStudent\" />
                </form>
                <br />
                <br />
            </div>
            
            <div class=\"container box\">
                <h3 align=\"center\">UPDATE DISQUALIFIED STUDENT</h3><br />
                <form method=\"post\" enctype=\"multipart/form-data\">
                    <label>Select Excel File</label>
                    <input type=\"file\" name=\"excel\" />
                    <br />
                    <input type=\"submit\" name=\"ImportDisqualified\" class=\"btn btn-info\" value=\"ImportDisqualified\"/>
                </form>
                <br />
                <br />
            </div>
            
            <div class=\"container box\">
                <h3 align=\"center\">IMPORT COURSES</h3><br />
                <form method=\"post\" enctype=\"multipart/form-data\">
                    <label>Select Excel File</label>
                    <input type=\"file\" name=\"excel\" />
                    <br />
                    <input type=\"submit\" name=\"ImportDisqualified\" class=\"btn btn-info\" value=\"ImportDisqualified\"/>
                </form>
                <br />
                <br />
            </div>
            ";
        echo $html;
    }

    public function getResponsive(){

    }

    public function getTable($stmt){
        if($stmt->rowCount()){
            while($row= $stmt->fetch()){
                echo "<tr><td>..</td></tr>";
            }
        }
    }
    /**
     * the functions below will have input as the file ,
     * data receive from db
     * make tables to view the file
     * it will be call in the controller
    **/

};
?>


