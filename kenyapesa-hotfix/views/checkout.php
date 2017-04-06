<?php
session_start();
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/22/17
 * Time: 1:03 AM
 */
require_once __DIR__.'/../models/class.payment.php';
require_once __DIR__.'/../models/class.merchant.php';


if(isset($_SESSION['username'])) {
    $userPaypalEmail = $_SESSION['username'];

    if (isset($_POST['dollars'])) {
        $amount = $_POST['dollars'];

        $limit_errors = Payment::authenticate_payment($userPaypalEmail,$amount);

        if (count($limit_errors) == 0) {

            $table = 'merchants';
            $fields = array("merchant_email");
            $options = array(
                    "status" => 1,
                    "limit"=>1
            );

            $merchantObject = Merchant::customFilter($table, $fields, $options);
              $merchant_email = 'quickserve@hudutech.com';
           // $merchant_email = 'njerucyrusdev@gmail.com';
            if (!is_null($merchantObject)){
                $merchant = $merchantObject->fetch(PDO::FETCH_ASSOC);
                $merchant_email = $merchant['merchant_email'];
            }

            $paypalURL = "https://www.paypal.com/cgi-bin/webscr";
            $notify_url = "http://premierpesa.co.ke/views/ipn.php";
            $return_url = "http://premierpesa.co.ke/views/success.php";
            $cancel_url = "http://premierpesa.co.ke/views/cancel.php";

            ?>
            <!DOCTYPE html>
            <html>
            <head>
            <script src="../public/assets/js/jquery.js"></script>

            <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
            <script type="text/javascript">
                //paste this code under the head tag or in a separate js file.
                // Wait for window load
                $(window).load(function() {
                    // Animate loader off screen
                    $(".se-pre-con").fadeOut("slow");
                });
            </script>
            <style>
                .no-js loader { display: none;  }
                .js loader { display: block; position: absolute; left: 100px; top: 0; }
                .se-pre-con {
                    position: fixed;
                    left: 0px;
                    top: 0px;
                    width: 100%;
                    height: 100%;
                    z-index: 9999;
                    background: url('../public/assets/Preloader/Preloader_2.gif') center no-repeat #fff;
                }
            </style>
            </head>
            <body>
            <!--- paypal fields here--->
            <form name="payment_form" id="payment_form" action="<?php echo $paypalURL?>" method="post">
                <!-- Identify your business so that you can collect the payments. -->
                <input type="hidden" name="business" value="<?php echo $merchant_email?>">

                <!-- Specify a Buy Now button. -->
                <input type="hidden" name="cmd" value="_xclick">

                <!-- Specify details about the item that buyers will purchase. -->
                <input type="hidden" name="item_name" value="MPESA_TOP_UP">
                <input type="hidden" name="item_number" value="<?php echo uniqid('TOPUP', true)?>">
                <!-- set amount using js-->
                <input type="hidden" name="amount"  value="<?php echo $amount?>">
                <!-->
                <input type="hidden" name="currency_code" value="USD">

                <!-- Specify URLs -->
                <input type="hidden" name="notify_url" value="<?php echo $notify_url?>" />
                <input type='hidden' name='cancel_return' value='<?php echo $cancel_url?>'>
                <input type='hidden' name='return' value='<?php echo $return_url?>'>
                <!--end of paypalfields-->

            </form>
            <script type="text/javascript">
                document.payment_form.submit();
            </script>
            </body>
            </html>

        <?php
        }
        else{
            header('Location: convert.php?lmt_error='.urlencode($amount));
        }
    }
}
//else{
//    header('Location: login.php');
//}
?>
