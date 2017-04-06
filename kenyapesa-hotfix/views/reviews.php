<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/24/17
 * Time: 8:53 AM
 */
require_once __DIR__.'/../models/class.feedback.php';
require_once __DIR__.'/../models/user.php';
?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once 'views_header.php'; ?>
    <title>Transaction Canceled</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="../public/assets/css/404.css" rel="stylesheet" type="text/css" media="all"/>
    <link href='http://fonts.googleapis.com/css?family=Fenix' rel='stylesheet' type='text/css'>
    <!--    <link rel="stylesheet" href="public/assets/css/font-awesome.min.css">-->
    <link rel="stylesheet" href="../public/assets/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../public/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/assets/css/magnific-popup.css">


    <!--For Plugins external css-->
    <link rel="stylesheet" href="../public/assets/css/plugins.css"/>

    <!--Theme custom css -->
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link rel="stylesheet" href="../public/assets/css/custom.css" type="text/css">
    <!--Theme Responsive css-->
    <link rel="stylesheet" href="../public/assets/css/responsive.css"/>
</head>
<body>


<?php include_once 'views_navbar.php';?>

<div class="container container-fluid" style="margin-top: 75px; ">

    <?php
    $reviews = UserFeedback::all();

    if (!is_null($reviews)){
        while ($review = $reviews->fetch(PDO::FETCH_ASSOC)) {

            $userObject = User::getId($review['user_id']);
            $full_name='';
            if(is_null($userObject)){
                $full_name .="anonymous";
            }
            else{
                $user=$userObject->fetch(PDO::FETCH_ASSOC);
                $full_name .= $user['first_name'] . " " . $user['last_name'];

            }

            $time_ago = UserFeedback::getTimeAgo($review['date']);

            ?>

    <div class="row">
        <div class="col col-md-12">
            <div class="col-md-offset-3">
                <div class="col-md-8 jumbotron" style="margin-top: auto;  background-color: white; font-size: 14px;">
                <img src="../public/assets/img/anonymous.png" class="anonymous pull-left" alt="User" style="margin-bottom: 20px;" >

                    <span style="color: rgba(235, 69, 3, 0.93) !important;"><?php echo $full_name; ?> </span>
                    <span style="color: rgba(0, 0, 0, 0.93) !important;"><?php echo $time_ago; ?> </span>
                    <p style="font-size: 12px;"><?php echo $review['text']?></p>
                </div>
            </div>
        </div>
    </div>

    <?php
        }
    }
    ?>

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

</body>
</html>