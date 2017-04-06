<?php
session_start();
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/20/17
 * Time: 4:14 PM
 */
include_once __DIR__ . '/../models/user.php';
include __DIR__ . '/../models/class.sms.php';
require_once __DIR__ . '/../models/class.feedback.php';

$userObject = User::getById($_SESSION['username']);


$user = $userObject->fetch(PDO::FETCH_ASSOC);
$user_id = $user['id'];



$feedback = '';
$status = 0;

    if(isset($_POST['submit'])) {
    if (isset($_POST['review_msg'])) {
        $message = $_POST['review_msg'];

        $review = new UserFeedback();
        $review->setText($message);
        $review->setUserId($user_id);
        $review->setApproved(0);

        $review->create();
        $status = 1;
        $feedback .= "Your review was received thank you for using PremierPesa";
        echo "<script>
                 
           alert('Your review was received thank you for using PremierPesa');
           location.href = '../index.php';

            </script>";

    } else {
        $status = 0;
        $feedback .= "Review message required";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include_once 'views_header.php'; ?>
    <title>Success page</title>
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

    <script src="../public/assets/js/jquery.js"></script>
    <script src="../public/assets/js/bootstrap.min.js"></script>

</head>
<body>
<?php include_once 'views_navbar.php'; ?>
<div class="container container-fluid wrapq">
    <div class="row">


        <div class="main" style="margin-top: 10%; margin-bottom: 20%; background-color: rgba(255,255,255,0.3);">

            <h2>Transaction completed successfully.</h2>
            <p>You will receive you Cash in you Mpesa Account in a moment.</p>


            <div class="col col-md-6">
                    <p id="feedback"></p>
            </div>
            <button href="#review_div" data-toggle="collapse" class="btn btn-default" style="margin-bottom: 15px;">
                Review our services here
            </button>

            <div id="review_div" class="collapse col-md-offset-4">

                <form id="review_form" style="width: 50%;"
                      action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group">
                        <label for="review_form">Review Message</label>
                        <textarea class="form-control" id="review_msg" name="review_msg" cols="3" rows="10"
                                  style="text-align:left; ">


                        </textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block" style="margin-bottom: 25px;">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="footers">
    <?php include_once 'views_footer.php'; ?>
</div>

<script src="../public/assets/js/vendor/jquery-1.11.2.min.js"></script>
<script src="../public/assets/js/vendor/bootstrap.min.js"></script>

<script src="../public/assets/js/jquery.magnific-popup.js"></script>
<script src="../public/assets/js/jquery.mixitup.min.js"></script>
<script src="../public/assets/js/jquery.easing.1.3.js"></script>
<script src="../public/assets/js/jquery.masonry.min.js"></script>

<script src="../public/assets/js/plugins.js"></script>
<script src="../public/assets/js/main.js"></script>



<!--<script src="https://uhchat.net/code.php?f=3ff3c3"></script>-->


</body>
</html>
