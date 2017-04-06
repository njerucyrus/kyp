<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 22/03/2017
 * Time: 10:52
 */
?>
<header id="main_menu" class="header navbar-fixed-top">
    <div class="main_menu_bg">
        <div class="container">
            <div class="row">
                <div class="nave_menu">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="../base.php#home">
                                    <img src="../public/assets/images/logo.png"/>
                                </a>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->



                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li class="pull-left"><a href="tel:+25723013549"> <i class="fa fa-mobile aria-hidden="true" style="alignment: left"></i>
                                            Help line: 0723013549</a></li>
                                </ul>

                                <ul class="nav navbar-nav navbar-right">
                                    <li><a href="../base.php#home">HOME</a></li>
                                    <li><a href="../base.php#service">Services</a></li>
                                    <li><a href="../base.php#rates">Rates</a></li>
                                    <li><a href="../base.php#about">About</a></li>
                                    <li><a href="../base.php#testimonial">Testimonials</a></li>

                                    <li><a href="../base.php#contact">CONTACT</a></li>
                                    <?php
                                    if(isset($_SESSION["username"])){
                                        ?>
                                        <li><a href="logout.php">Logout</a></li>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <li><a href="../base.php#signup">Join</a></li>
                                        <li><a href="login.php">Login</a></li>
                                        <?php
                                    }
                                    ?>



                                </ul>


                            </div>

                        </div>
                    </nav>
                </div>
            </div>

        </div>
    </div>

</header>
