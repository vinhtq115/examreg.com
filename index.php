<?php
session_start();
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
    <script src="/jquery/jquery-3.4.1.js" type = "text/javascript"></script>
    <script src = "account/ajaxLogin.js" type = "text/javascript"></script>
</head>
<body>
<?php
        $usercontroller = new LoginController();//call the controller
        $usercontroller->__construct();
   ?>

<!--<div id="myModal" >-->
<!--    <div class="modal-dialog modal-login">-->
<!--    <div class="modal-content">-->
<!--        <div class="modal-header">-->
<!--            <h4 class="modal-title">Sign In</h4>-->
<!--        </div>-->
<!--        <div class="modal-body">-->
<!--            <form action="" method="post">-->
<!--                <div class="form-group">-->
<!--                    <div class="input-group">-->
<!--                        <span class="input-group-addon"><i class="fa fa-user"></i></span>-->
<!--                        <input id = "id" type="text" class="form-control" name="id" placeholder="Account ID" required="required">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <div class="input-group">-->
<!--                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>-->
<!--                        <input id = "pass" type="password" class="form-control" name="pass" placeholder="Password" required="required">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <button type="submit" id = "submit-btn" class="btn btn-primary btn-block btn-lg">Sign In</button>-->
<!--                </div>-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--</div>-->
<!--    <script>-->
<!--         $(document).ready(function()-->
<!--         {-->
<!--            $("#submit-btn").click(do_login());-->
<!--        };);-->
<!--    </script>-->
</body>
</html>
