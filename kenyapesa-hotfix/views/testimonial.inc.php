<?php

/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 16/03/2017
 * Time: 00:36
 */
require_once __DIR__ . '/../models/class.feedback.php';
require_once __DIR__ . '/../models/user.php';
?>


<!--<div class="video_overlay">-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="main_testimonial sections text-center">-->
<!--                <div class="col-md-12" data-wow-delay="0.2s">-->
<!--                    <div class="main_teastimonial_slider text-center">-->
<!---->
<!--                        --><?php
//                        $counter=0;
//                        $stmt = UserFeedback::all();
//                        if(is_object($stmt)) {
//                            while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
//                                    $user = User::getId($row['user_id']);
//
//                                    if(!is_null($user)) {
//                                        $userData = $user->fetch(PDO::FETCH_ASSOC);
//
//                                        $first_name = $userData['first_name'];
//                                        $last_name = $userData['last_name'];
//
//                                    }
//                                    else{
//                                        $first_name = 'Anonymous';
//                                        $last_name = '';
//                                    }
//
//
//
//                                ?>
<!---->
<!---->
<!---->
<!---->
<!---->
<!--                        <div class="single_testimonial">-->
<!--                                    <div class="row">-->
<!--                                        <div class="col-sm-8 col-sm-offset-2">-->
<!---->
<!--                                            <p> <i class="fa fa-quote-left"></i>--><?php //echo $row['text'];?><!-- <i class="fa fa-quote-right"></i></p>-->
<!--                                            <div class="single_test_author">-->
<!--                                                <h4>--><?php //echo $first_name . " ".$last_name; ?><!-- </h4>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!--                                --><?php
//                            }
//                        }
//                       ?>
<!--                    </div>-->
<!---->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!---->



<div class="video_overlay">

<div id="carousel-example-captions" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <?php
        $counter = 1;
        $stmt = UserFeedback::all();
        if (is_object($stmt)) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user = User::getId($row['user_id']);

                if (!is_null($user)) {
                    $userData = $user->fetch(PDO::FETCH_ASSOC);

                    $first_name = $userData['first_name'];
                    $last_name = $userData['last_name'];

                } else {
                    $first_name = 'Anonymous';
                    $last_name = '';
                }
                ?>
                <div class="item<?php if ($counter <= 1) {
                    echo " active";
                } ?>">

                    <div class="main_testimonial sections text-center">

                    <div class="single_testimonial">
                        <div class="row">
                            <div class="col-sm-12 text-center">

                                <div class="single_test_author">
                               <i class="fa fa-quote-left"></i>
                                    <p> <?php echo $row['text']; ?></p>

                                <p>   <?php echo $first_name . " ".$last_name; ?></p>
                                </div>
                        </div>
                    </div>
                    </div>



                    </div>
                </div>
                <?php
                $counter++;
            }
        }

        ?>

        <ol class="carousel-indicators">
            <li data-target="#carousel-example-captions" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-captions" data-slide-to="1"></li>
            <li data-target="#carousel-example-captions" data-slide-to="2"></li>
        </ol>
        <!-- Left and right controls -->
        <a class="left carousel-control" href="#carousel-example-captions" role="button" data-slide="prev">
            <span class="fa fa-hand-o-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-captions" role="button" data-slide="next">
            <span class="fa fa-hand-o-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div class="home_btn" style=" margin: auto;
    width: 10%;

    padding: 10px;">
        <a href="views/reviews.php" class="btn btn-primary" style=" background-color: #0099e5; border-color: #0099e5;">View More</a>