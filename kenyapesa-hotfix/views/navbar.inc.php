<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 16/03/2017
 * Time: 00:01
 */

?>

<div class="main_menu_bg">
    <div class="container">
        <div class="row">
            <div class="nave_menu">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#home">
                                <img src="public/assets/images/logo.png" alt="PremierPesa"/>
                            </a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->


                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                                <li class="pull-left"><a href="tel:+25723013549"> <i class="fa fa-mobile aria-hidden="
                                                                                     true" style="alignment: left"></i>
                                        Help line: 0723013549</a></li>
                            </ul>

                            <ul class="nav navbar-nav navbar-right">


                                <li><a href="#home">Home</a></li>
                                <li><a href="#service">Services</a></li>
                                <li><a href="#rates">Rates</a></li>
                                <li><a href="#about">About</a></li>
                                <li><a href="#testimonial">Testimonials</a></li>

                                <?php
                                if (isset($_SESSION["username"])) {
                                    ?>
                                    <li><a href="views/logout.php">Logout</a></li>
                                    <?php
                                } else {
                                    ?>
                                    <li><a href="#signup">Join</a></li>

                                    <li><a href="views/login.php">Login</a></li>
                                    <?php
                                }
                                ?>

                                <li><a href="#contact">Contact</a></li>
                            </ul>


                        </div>

                    </div>
                </nav>
            </div>
        </div>

    </div>
</div>
