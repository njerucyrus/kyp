<?php
session_start();
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 4/1/17
 * Time: 10:27 PM
 */
require_once __DIR__ . '/../models/class.reset_password.php';

$error_message = '';
$success_message = '';
if(isset($_SESSION['PASSWORD_RESET_CODE'])
and isset($_SESSION['PHONE_NUMBER'])
and isset($_SESSION['EMAIL'])) {
    if (isset($_POST['new_password'])
        and isset($_POST['confirm_new_password'])
    ) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_new_password'];
        $reset_password = new ResetPassword($_SESSION['EMAIL']);
        if ($new_password == $confirm_password) {
            $success = $reset_password->resetPassword($new_password);
            if ($success) {
                unset($_SESSION['PASSWORD_RESET_CODE']);
                unset($_SESSION['PHONE_NUMBER']);
                unset($_SESSION['EMAIL']);
                $success_message .= 'Password reset successful';
                sleep(2);
                header('Location: login.php');

            }
        } else {
            $error_message .= 'Password don\'t match';
        }

    }
}
else{
    header('Location: reset_password_step1.php');
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
            <div class="row "  style="margin-top: 100px; ">

                <div class="col col-md-8 col-md-offset-2" style="padding-bottom: 30px;">
            <?php
            if ($error_message != '') {
                ?>
                <div class="alert alert-danger">
                    <?php echo $error_message; ?>
                </div>
                <?php
            } elseif ($success_message != '') {
                ?>
                <div class="alert alert-success">
                    <?php echo $success_message;

                    ?>

                </div>
                <?php
            }
            ?>
                    <h2>Reset Password</h2>
                    <p>Step 3: Enter the new password and complete password resetting process</p>
            <form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                <div class="form-group " >

                    <input type="password" style=" color: black;  width: 300px; align-content: center; font-size: 20px; padding-left: 15px; " id="new_password"  name="new_password" placeholder="Enter new password" required>
                </div>
                <div class="form-group">

                    <input type="password" style=" color: black;  width: 300px ; font-size: 20px; padding-left: 15px;" id="confirm_new_password" name="confirm_new_password" placeholder="confirm password" required>
                </div>
                <div class="col col-md-3 col-md-offset-4">
                <input type="submit" value="Reset Password" class="btn btn-primary btn-block" style="border-radius: 25px !important; background-color: #ff7200;">
                </div>
            </form>
        </div>
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

