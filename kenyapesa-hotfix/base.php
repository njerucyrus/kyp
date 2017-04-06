<?php
session_start();
?>
<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->
<head>

    <?php include "views/head.inc.php"; ?>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="200">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
<!--<div class='preloader'>-->
<!--    <div class='loaded'>&nbsp;</div>-->
<!--</div>-->

<div class="culmn">

    <header id="main_menu" class="header navbar-fixed-top">
        <?php include "views/navbar.inc.php"; ?>
    </header> <!--End of header -->


    <section id="home" class="home">
        <?php include "views/home.inc.php"; ?>
    </section>


    <section id="service" class="service" style="margin-top: 10px;">
        <?php include "views/services.inc.php"; ?>
    </section>

    <section id="rates" class="rates">
        <?php include 'views/rates.php' ?>
    </section>


    <section id="about" class="about">
        <?php include "views/about.inc.php"; ?>
    </section>


    <section id="counter" class="counter">
        <?php include_once 'views/counter.inc.php'; ?>
    </section>  <!-- End of counter section -->


    <section id="choose" class="choose">
        <?php include "views/why_choose_us.inc.php"; ?>
    </section>


    <section id="testimonial" class="testimonial">

        <?php include "views/testimonial.inc.php"; ?>
    </section>

    <?php
    if (!isset($_SESSION["username"])) {
        ?>
        <section id="signup" class="signup">

            <?php include "views/signup.php"; ?>
        </section>
        <?php
    }
    ?>


    <section id="contact" class="contact">
        <?php include "views/contact.inc.php"; ?>

    </section>  <!-- End of contact section -->


    <!--maps here-->

    <div id="footers">
        <?php include "views/footer.inc.php"; ?>
    </div>

</div>

<!-- START SCROLL TO TOP  -->

<div class="scrollup">
    <a href="#"><i class="fa fa-chevron-up"></i></a>
</div>

<script src="public/assets/js/vendor/jquery-1.11.2.min.js"></script>
<script src="public/assets/js/vendor/bootstrap.min.js"></script>

<script src="public/assets/js/jquery.magnific-popup.js"></script>
<script src="public/assets/js/jquery.mixitup.min.js"></script>
<script src="public/assets/js/jquery.easing.1.3.js"></script>
<script src="public/assets/js/jquery.masonry.min.js"></script>

<script src="public/assets/js/plugins.js"></script>
<script src="public/assets/js/main.js"></script>

<script src="https://uhchat.net/code.php?f=3ff3c3"></script>

</body>
</html>
