<?php
session_start();
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/20/17
 * Time: 4:14 PM
 */


?>
<!DOCTYPE HTML>
<html>
<head>
    <?php include_once 'views_header.php';?>
    <title>Transaction Canceled</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="../public/assets/css/404.css" rel="stylesheet" type="text/css" media="all"/>
    <link href='http://fonts.googleapis.com/css?family=Fenix' rel='stylesheet' type='text/css'>
    <!--    <link rel="stylesheet" href="public/assets/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="../public/assets/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/assets/css/magnific-popup.css">


    <!--For Plugins external css-->
    <link rel="stylesheet" href="../public/assets/css/plugins.css" />

    <!--Theme custom css -->
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link rel="stylesheet" href="../public/assets/css/custom.css" type="text/css">
    <!--Theme Responsive css-->
    <link rel="stylesheet" href="../public/assets/css/responsive.css" />
</head>
<body>
<div class="wrapq">
    <?php include_once 'views_navbar.php';?>
    <div class="main">

    <div style="margin-top: 100px; margin-bottom: 20%;">
        <h1>Oops Your transaction was canceled</h1>
        <p>Go back to the home page to continue using our services <span class="error"><a href="../base.php"> Home</a></span>.<br>
            <span>Thank you</span></p>
    </div>

    </div>

</div>
<div  id="footers" >
    <?php include_once 'views_footer.php';?>
</div>

<script src="../public/assets/js/vendor/jquery-1.11.2.min.js"></script>
<script src="../public/assets/js/vendor/bootstrap.min.js"></script>

<script src="../public/assets/js/jquery.magnific-popup.js"></script>
<script src="../public/assets/js/jquery.mixitup.min.js"></script>
<script src="../public/assets/js/jquery.easing.1.3.js"></script>
<script src="../public/assets/js/jquery.masonry.min.js"></script>

<script src="../public/assets/js/plugins.js"></script>
<script src="../public/assets/js/main.js"></script>
<script src="https://uhchat.net/code.php?f=3ff3c3"></script>
</body>
</html>
