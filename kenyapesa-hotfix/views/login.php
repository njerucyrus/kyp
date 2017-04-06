<?php
session_start();
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/17/17
 * Time: 10:09 AM
 */

require_once __DIR__ . '/../models/class.auth.php';
require_once __DIR__ . '/../models/user.php';


if (isset($_SESSION['username'])) {
    header("Location: ../base.php");
}
$error_message = '';
if(isset($_POST['submit'])) {
    if (isset($_POST['email']) and isset($_POST['password'])) {

        $username = $_POST['email'];
        $password = $_POST['password'];

        $auth = new Auth();

        $authenticated = $auth->authenticate($username, $password);
        if ($authenticated) {

            //check if the user is admin
            $userObject = User::getById($username);
            $user = $userObject->fetch(PDO::FETCH_ASSOC);

            if ($user['is_admin'] == 1 and $user['status'] == 'approved') {
                $_SESSION['admin_username'] = $username;
            }
            if ($user['status'] == 'approved') {
                $_SESSION['username'] = $username;
                header("Location: ../base.php");

            }
            if ($user['status'] == 'pending') {
                $error_message .= "Cant Login:- Your account is not approved";
            }
            if ($user['status'] == 'blocked') {
                $error_message .= "Cant Login:- Your account has been blocked";
            }

        } else {
            session_destroy();
            $error_message .= "Cant Login :-invalid username/password";
        }

    } else {
        $error_message .= "Username / Password Cannot be empty";
    }
}
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

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Kenyapesa Fastest way to transfer money from paypay to mpesa</title>
    <!-- Meta Tag Manager -->
    <meta name="description" content="Money transfer services"/>
    <meta name="keywords" content="PayPal to Mpesa"/>
    <meta name="keywords" content="PayPal Mpesa"/>
    <meta name="keywords" content="Withdraw PayPal Kenya"/>
    <!-- / Meta Tag Manager -->


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <!--        <!--Google Font link-->
    <!--        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">-->
    <!--        <link href="https://fonts.googleapis.com/css?family=Raleway:400,600,700" rel="stylesheet">-->

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

    <script src="../public/assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>


    <style>
        .login_div {
            margin-top: 125px;
            margin-bottom: 3.5em;
            background: transparent;

        }
        .calculator{
            border-style: solid ;
            border-color: green;
            border-radius: 25px;
            border-width: thin 2px;

        }

        input[type=text], input[type=email], input[type=password], input[type=number] {
            height: 50px;
            border-radius: 25px !important;

        }

    </style>


</head>
<body data-spy="scroll" data-target=".navbar" data-offset="200">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
<div class='preloader'>
    <div class='loaded'>&nbsp;</div>
</div>

<div class="culmn">

    <header id="main_menu" class="header navbar-fixed-top">


       <?php include_once 'views_navbar.php';?>

    </header> <!--End of header -->


    <div class="login_div container-fluid">
        <div class="row">

            <div class="col col-md-6 col-md-offset-3">
                <div>
                    <?php
                    if ($error_message !=''){
                        echo "<p class='alert alert-danger'>".$error_message."</p>";
                    }
                    ?>

                </div>

                <div class='calculator'>
                <form id="login_form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="padding: 20px; margin-top:15px;">
                    <fieldset>
                        <legend>Login Here</legend>
                    </fieldset>
                    <div class="form-group">
                        <label for="email">Email address:</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="your paypal email"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="password"
                               required>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox"> Remember me</label>
                    </div>
                    <div class="row">
                    <a href='reset_password_step1.php' class="btn-link pull-right" style="margin-right:10px;">Forgot Password ?</a>
                    </div>
                    <input type="submit"  name="submit" class="btn btn-primary"  value="Sign in">
                </form>
                </div>
                </div>
        </div>

    </div>


    <div id="footers">

       <?php include_once 'views_footer.php';?>


    </div>

</div>

<!-- START SCROLL TO TOP  -->

<div class="scrollup">
    <a href="#"><i class="fa fa-chevron-up"></i></a>
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




