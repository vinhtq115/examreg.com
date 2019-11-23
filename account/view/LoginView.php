<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exam Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/examreg.com/bootstrap/bootstrap-3.3.7-dist/css/bootstrap.css">

    <style type="text/css">
        body {
            font-family: 'Varela Round', sans-serif;
        }
        .modal-login {
            width: 350px;
        }
        .modal-login .modal-content {
            padding: 20px;
            border-radius: 5px;
            border: none;
        }
        .modal-login .modal-header {
            border-bottom: none;
            position: relative;
            justify-content: center;
        }

        .modal-login h4 {
            color: #636363;
            text-align: center;
            font-size: 26px;
            margin-top: 0;
        }
        .modal-login .modal-content {
            color: #999;
            border-radius: 1px;
            margin-bottom: 15px;
            background: #fff;
            border: 1px solid #f3f3f3;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 25px;
        }
        .modal-login .form-group {
            margin-bottom: 20px;
        }
        .modal-login label {
            font-weight: normal;
            font-size: 13px;
        }
        .modal-login .form-control {
            min-height: 38px;
            padding-left: 5px;
            box-shadow: none !important;
            border-width: 0 0 1px 0;
            border-radius: 0;
        }
        .modal-login .form-control:focus {
            border-color: #ccc;
        }
        .modal-login .input-group-addon {
            max-width: 42px;
            text-align: center;
            background: none;
            border-width: 0 0 1px 0;
            padding-left: 5px;
            border-radius: 0;
        }
        .modal-login .btn {
            font-size: 16px;
            font-weight: bold;
            background: #19aa8d;
            border-radius: 3px;
            border: none;
            min-width: 140px;
            outline: none !important;
        }
        .modal-login .btn:hover, .modal-login .btn:focus {
            background: #179b81;
        }
        .modal-login a {
            color: #fff;
            text-decoration: underline;
        }
        .modal-login a:hover {
            text-decoration: none;
        }
        .modal-login a {
            color: #19aa8d;
            text-decoration: none;
        }
        .modal-login a:hover {
            text-decoration: underline;
        }
        .modal-login .fa {
            font-size: 21px;
        }

        #myModal{
            margin-top: 300px;
        }
        body{
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div id="myModal" >
    <div class="modal-dialog modal-login">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sign In</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" name="id" placeholder="Account ID" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="text" class="form-control" name="pass" placeholder="Password" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>