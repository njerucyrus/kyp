<?php
session_start();
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/31/17
 * Time: 1:16 AM
 */
$error_message = '';
if(isset($_POST['submit'])) {
    if (isset($_SESSION['PASSWORD_RESET_CODE'])) {
        if (isset($_POST['password_reset_code'])) {
            $password_reset_code = $_POST['password_reset_code'];
            if ($password_reset_code == $_SESSION['PASSWORD_RESET_CODE']) {
                header('Location: reset_password_step3.php');
            } else {
                $error_message .= "The code you entered is invalid";
            }
        } else {
            $error_message .= "Reset password code field cannot be empty";
        }
    } else {
        header('Location: reset_password_step1.php');
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
            <div class="row "  style="margin-top: 100px; ">

                <div class="col col-md-8 col-md-offset-2">
                    <h2>Reset Password</h2>

            <?php
            if($error_message != ''){
                ?>
            <div class="alert alert-info"><?php echo $error_message; ?></div>
            <?php
            }
            ?>
            <p>Step 2: A 6-digit code was sent to <?php echo $_SESSION['PHONE_NUMBER']; ?></p>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <div class="form-group">

                    <input style="background-color: #869791; color: white; " type="text" id="password_reset_code" name="password_reset_code" placeholder="Enter 6 digit code here" maxlength="6" style="text-align: center">
                </div>
                <div class="col-md-4 col-md-offset-4">
                    <input type="submit" name="submit" class="btn btn-primary btn-block" style="border-radius: 25px !important; background-color: #ff7200;" value="Submit">
                </div>
            </form>
                    <div class="col-md-6 col-md-offset-3">
                    <p>Didn't get Code ?<a href="reset_password_step1.php" class="btn-link" style="color: #1CD3CB;">Resend Code</a></p>
                    </div>

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

</body>
</html>