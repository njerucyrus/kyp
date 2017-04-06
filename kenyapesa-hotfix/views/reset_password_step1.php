<?php
session_start();
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/1/17
 * Time: 3:50 PM
 */
require_once __DIR__.'/../models/user.php';
require_once __DIR__.'/../models/class.reset_password.php';

$error_message = '';
$user_phone = '';
if (isset($_POST['submit'])) {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $user = new User();
        $verified = $user->verifyEmail($email);

        if ($verified==true) {
            $passwordReset = new ResetPassword($email);
            $user_phone = $passwordReset->retrieveUserPhone();

            $_SESSION['PHONE_NUMBER'] = substr_replace($user_phone['phone_number'], "****", 7, 3);
            $passwordReset->sendCode();
            $_SESSION['PASSWORD_RESET_CODE'] = $passwordReset->getResetCode();
            $_SESSION['EMAIL'] = $email;
            header('Location: reset_password_step2.php');
        } else {
            $error_message .= "Error! Email provided does not match any account";
        }
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <?php include_once 'views_header.php';?>
    <title>Reset Password</title>
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

        <div class="main" style="margin-top: 70px;  background-color: rgba(255,255,255,0.3);">
<div class="container container-fluid">
    <div class="row col-md-offset-4"  style="margin-top: 100px; ">

        <div class="col col-md-6">
            <h2>Reset Password</h2>
            <p>Step 1: Please enter your email</p>
            <?php
            if($error_message !=''){
                ?>

            <div class="alert alert-info"><?php echo $error_message; ?></div>
            <?php
            }
            ?>
            <?  echo $user_phone; ?>
            <form action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="col-md-6 col-md-offset-3" style="margin-bottom: 15px;">
                    <input type="submit" name="submit" class="btn btn-primary btn-block" style="border-radius: 25px !important; background-color: #ff7200 !important;" value="Submit">
                </div>
            </form>

        </div>
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

</body>
</html>