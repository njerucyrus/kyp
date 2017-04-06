<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 16/03/2017
 * Time: 00:03
 */
?>
<div class="overlay">
    <div class="container">
        <div class="row">

            <div class="col-sm-12">
                <div class="main_home_slider text-center">
                    <div class="single_home_slider">
                        <div class="main_home wow fadeInUp" data-wow-duration="700ms">
                            <h1>WELCOME TO PREMIERPESA</h1>
                            <p> It's easy and fast to transfer money from PayPal to Mpesa </p>
                            <div class="home_btn">
                                <a href="views/convert.php" class="btn btn-primary" style="background-color: #0099e5; border-color: #0099e5;">Convert</a>

                                <?php
                                if(!isset($_SESSION["username"])) {
                                    ?>
                                    <a href="views/login.php" class="btn btn-primary">Login</a>
                                    <?php
                                }
                                ?>
                            </div>

                        </div>

                    </div>
                    <div class="single_home_slider">
                        <div class="main_home wow fadeInUp" data-wow-duration="700ms">
                            <h1>MONEY SERVICES</h1>
                            <p>Sign up to enjoy fast and reliable services.</p>
                            <div class="home_btn">
                                <a href="views/convert.php" class="btn btn-primary" style="background-color: #0099e5; border-color: #0099e5;">Convert </a>

                                <?php
                                if(!isset($_SESSION["username"])) {
                                    ?>

                                    <a href="#signup.php" class="btn btn-primary">Sign Up</a>
                                    <?php
                                }
                                ?>

                            </div>

                        </div>

                    </div>
                </div>
                <a class="arrow-wrap nav navbar-nav" href="#service">
                    <span class="arrow"></span>
                </a>
            </div>

        </div>
    </div>


</div>

<style>
    @-webkit-keyframes arrows {
        0% { top:0; }
        10% { top:12%; }
        20% { top:0; }
        30% { top:12%; }
        40% { top:-12%; }
        50% { top:12%; }
        60% { top:0; }
        70% { top:12%; }
        80% { top:-12%; }
        90% { top:12%; }
        100% { top:0; }
    }

    .arrow-wrap .arrow {
        -webkit-animation: arrows 10s 5s;
        -webkit-animation-delay: 1s;
    }

    .arrow-wrap {
        position:absolute;
        z-index:1;
        left:50%;

        margin-left:-5em;
        background:#111;
        width:10em;
        height:10em;
        padding:4em 2em;
        border-radius:50%;
        font-size:0.5em;
        display:block;
    }

    .arrow {
        float:left;
        position:relative;
        width: 0px;
        height: 0px;
        border-style: solid;
        border-width: 3em 3em 0 3em;
        border-color: #ffffff transparent transparent transparent;
        -webkit-transform:rotate(360deg)
    }

    .arrow:after {
        content:'';
        position:absolute;

        left:-3em;
        width: 0px;
        height: 0px;
        border-style: solid;
        border-width: 3em 3em 0 3em;
        border-color: #111 transparent transparent transparent;
        -webkit-transform:rotate(360deg)
    }

</style>