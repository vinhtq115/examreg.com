<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="Affordable and professional web design">
    <meta name="keywords" content="web design, affordable web design, professional web design">
    <meta name="author" content="Brad Traversy">
    <title>Administration Homepage</title>
    <style>
        body{
            font: 15px/1.5 Arial, Helvetica,sans-serif;
            padding:0;
            margin:0;
            background-color:#f4f4f4;
        }

        /* Global */
        .container{
            width:80%;
            margin:auto;
            overflow:hidden;
        }

        ul{
            margin:0;
            padding:0;
        }

        /* Header **/
        header{
            background:#35424a;
            color:#ffffff;
            padding-top:30px;
            min-height:70px;
            border-bottom:#8bc6da 3px solid;
        }

        header a{
            color:#ffffff;
            text-decoration:none;
            text-transform: uppercase;
            font-size:16px;
        }

        header li{
            float:left;
            display:inline;
            padding: 0 20px 0 20px;
        }

        header #branding{
            float:left;
        }

        header #branding h1{
            margin:0;
        }

        header nav{
            float:right;
            margin-top:10px;
        }

        header .highlight, header .current a{
            color:#8bc6da;
            font-weight:bold;
        }

        header a:hover{
            color:#cccccc;
            font-weight:bold;
        }
        /*Showcase*/
        #showcase{
            min-height:400px;
            background:url('img/showcase.jpg') no-repeat 0 -400px;
            text-align:center;
            color:#ffffff;
        }

        #showcase h1{
            margin-top:100px;
            font-size:55px;
            margin-bottom:10px;
        }

        #showcase p{
            font-size:20px;
        }

        /* Boxes */
        #boxes{
            margin-top:20px;
        }

        #boxes .box{
            float:left;
            text-align: center;
            width:30%;
            padding:10px;
        }

        #boxes .box img{
            width:90px;
        }


        footer{
            padding:20px;
            margin-top:20px;
            color:#ffffff;
            background-color:#8bc6da;
            text-align: center;
        }



    </style>
</head>
<body>
<header>
    <div class="container">
        <div id="branding">
            <h1><span class="highlight">Exam</span>Registration</h1>
        </div>
        <nav>
            <ul>
                <li class="current"><a href="">Log out</a></li>
            </ul>
        </nav>
    </div>
</header>

<section id="showcase">
    <div class="container">
        <h1>Administration Of Exam Registration System</h1>
    </div>
</section>

<section id="boxes">
    <div class="container">
        <div class="box">
            <a href=""><img src="img/graduate-student.png"></a>
            <h3>Students Roaster</h3>
            <p>Administration keeping track and managing student profile which taking part in the examination</p>
        </div>
        <div class="box">
            <a href=""><img src="img/microscope.png"></a>
            <h3>Subjects List</h3>
            <p>Administration keeping track of subjects and courses of the examination</p>
        </div>
        <div class="box">
            <a href=""><img src="img/logo_brush.png"></a>
            <h3>The Exams</h3>
            <p>Administration creating and managing the upcoming examination </p>
        </div>
    </div>
</section>

<footer>
    <p>Admin home page</p>
</footer>
</body>
</html>