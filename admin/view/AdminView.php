<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="Affordable and professional web design">
    <meta name="keywords" content="web design, affordable web design, professional web design">
    <meta name="author" content="Brad Traversy">
    <title>Home page</title>
</head>
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
        border-bottom:#0F83D9 3px solid;
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
        color:#0F83D9;
        font-weight:bold;
    }
    header a:hover{
        color:#cccccc;
        font-weight:bold;
    }
    /* Showcase */

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

    /* Main-col */
    article#main-col{
        float:left;
        width:65%;
    }
    /* Services */
    ul#services li{
        list-style: none;
        padding:20px;
        border: #cccccc solid 1px;
        margin-bottom:5px;
        background:#e6e6e6;
    }
    footer{
        padding:20px;
        margin-top:20px;
        color:#ffffff;
        background-color:#0F83D9;
        text-align: center;
    }

</style>
<body>
<header>
    <div class="container">
        <div id="branding">
            <h1><span class="highlight">Exam</span>Registeration</h1>
        </div>
    </div>
</header>
<section id="main">
    <div class="container">
        <article id="main-col">
            <h1 class="page-title">Services</h1>
            <ul id="services">
                <li>
                    <h1><a href = "">Subjects</a></h1>
                </li>
                <li>
                    <h1><a href = "">Students</a></h1>
                </li>
                <li>
                    <h1><a href = "">Exams</a></h1>
                </li>
            </ul>
        </article>
    </div>
</section>
<footer>
    <p>Admin Home Page</p>
</footer>
</body>
</html>