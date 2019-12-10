<?php
session_start();
require_once dirname(__FILE__)."/../controller/LogoutController.php";
require_once dirname(__FILE__)."/../controller/ChangePassController.php";

if($_SESSION["isAdmin"] != 1 && $_SESSION["isAdmin"] != 0){
    header("Location:http://examreg.com/account/view/LogoutView.php");
}

if(isset($_POST['changePass'])){ // upon submiting form , this will work
    $controller = new ChangePassController();
    $controller->changePass();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Change Password</title>
    <link href="/../../bootstrap/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet"/>
    <style>
        .container{
            margin-top: 250px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Change Password</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">New Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="newpass" required = "required" placeholder="Type Your New Password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Check Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="renewpass" required = "required" placeholder="Type Your New Password Again">
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" name = "changePass">
                                    Change Password
                                </button>
                            </div>
                    </div>
                    </form>
                </div>
        </div>
    </div>

</body>
</html>