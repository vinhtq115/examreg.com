<?php
//session_start();
require_once dirname(__FILE__)."/account/controller/LoginController.php";
require_once dirname(__FILE__)."/account/view/LoginView.php";

if($_SESSION["id"] != ""){
    if($_SESSION["isAdmin"] == 1){
        header('Location: http://examreg.com/admin/view/AdminView.php');
    }else if($_SESSION["isAdmin"] == 0){
        header('Location: http://examreg.com/student/view/StudentView.php');
    }
}

?>
<!doctype html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\"
          content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
    <title>Exam Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="bootstrap/bootstrap-3.3.7-dist/css/bootstrap.css">
    <link rel="stylesheet" type = "text/css" href = "css/loginView.css">
    <script src=/jquery/jquery-3.4.1.js" type = "text/javascript"></script>
    <script type="text/javascript">
                $(document).ready(function(){
                    $("#submit-btn").click(function(){
                        var username = $("#id").val().trim();
                        var password = $("#pass").val().trim();
                        if( username != "" && password != "" ){
                            $.ajax({ // send the message
                                url:'account/controller/LoginController.php',
                                type:'post',
                                data:{username:username,password:password},
                                success:function(response){
                                    var msg = "";
                                    if(response == 1){ // receiveing message
                                       window.location = "/admin/view/AdminView.php";
                                    }else if(response == 0){
                                        window.location = "/student/view/StudentView.php";
                                    }else if(response == 2){
                                        msg = "Invalid username and password!";
                                        alert(msg);
                                    }}});}});});
    </script>
</head>
<body>
    <?php
        $usercontroller = new LoginView();
        $usercontroller->getView();
    ?>
</body>
</html>
