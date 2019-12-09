<?php
    session_start();
    // Nếu chưa đăng nhập thì về trang chủ
    if(!isset($_SESSION["id"])){
        require_once dirname(__FILE__)."/../account/controller/LogoutController.php";
        header("Location:http://examreg.com/");
    }
?>
<header>
    <div class="container">
        <div id="branding">
            <a href="http://examreg.com"><h1><span class="highlight">Exam</span>Reg</h1></a>
        </div>
        <nav>
            <ul>
                <li class="current">Xin chào <?php echo $_SESSION["id"]?></li>
            </ul>
        </nav>
    </div>
</header>