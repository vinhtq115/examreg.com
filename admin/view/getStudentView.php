<?php

class getStudentView{
    public function __construct() {

    }
    public function getStudentExcelInterface(){ // this is the form to get the data
        $html = "<html>
                <head>
                <title>Import Excel to Mysql using PHPExcel in PHP</title>
                <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js\"></script>
                <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js\"></script>
                <link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css\" rel=\"stylesheet\" />
                <style>
                    body
                    {
                        margin:0;
                        padding:0;
                        background-color:#f1f1f1;
                    }
                    .box
                    {
                        width:700px;
                        border:1px solid #ccc;
                        background-color:#fff;
                        border-radius:5px;
                        margin-top:100px;
                    }
            
                </style>
            </head>
            <body>
            <div class=\"container box\">
                <h3 align=\"center\">Import Excel to Mysql using PHPExcel in PHP</h3><br />
                <form method=\"post\" enctype=\"multipart/form-data\">
                    <label>Select Excel File</label>
                    <input type=\"file\" name=\"excel\" />
                    <br />
                    <input type=\"submit\" name=\"import\" class=\"btn btn-info\" value=\"Import\" />
                </form>
                <br />
                <br />
                <!---?php
                echo //output; 
                ?--->
            </div>
            </body>
            </html>";
        return $html;
    }
    /**
     * the functions below will have input as the file ,
     * data receive from db
     * make tables to view the file
     * it will be call in the controller
    **/

    public function returnStudentExcel($output){
        echo $output; // this will return the data
    }


};
?>


