<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 16/03/2017
 * Time: 00:10
 */
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/class.phone_number.php';
require_once __DIR__.'/../models/class.sms.php';
require_once __DIR__.'/../models/class.merchant.php';
$error_message = '';
$success_message = '';
if (isset($_POST['submit'])) {

    if (isset($_POST['first_name']) && isset($_POST['last_name']) &&
        isset($_POST['paypal_email']) && isset($_POST['phone_number']) &&
        isset($_POST['id_no']) && isset($_POST['password'])
    ) {

        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $paypalEmail = $_POST['paypal_email'];
        $phoneNumber = $_POST['phone_number'];
        $idNo = $_POST['id_no'];
        $password = $_POST['password'];

        $user = new User();

        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPaypalEmail($paypalEmail);

        /* create a valid phone number */
        $phoneNumberObj = new PhoneNumber($phoneNumber);
        $cleanPhoneNumber = $phoneNumberObj->addPrefix();

        $user->setPhoneNumber($cleanPhoneNumber);
        $user->setIdNo($idNo);
        $user->setPassword($password);

        /*DEFAULT attributes*/
        $user->setTransactionLimit(3);
        $user->setAmountLimit(20);


        $created = $user->create();

        if ($created == true) {
            $success_message .= "Account Created Successfully! The account is waiting approval.
            Will Send you an Email Once your account is verified and approved";

            $merchant = Merchant::getActiveMerchant();
            $sms = new Sms();
            $sms->setReceiver($merchant['phone_number']);
            $admin_message = "A new user has signup  Email: ".$paypalEmail." ID_NO: ".$idNo." FullName ".$firstName." ".$lastName."Kindly Login to Approve this account";
            $sms->setMessage($admin_message);
            $sms->send();
            //send admin sms//
        } elseif ($created == false) {
            $error_message .= "Error occurred";
        }

    } else {
        $error_message .= "all fields required";
    }
}

?>


<style xmlns="http://www.w3.org/1999/html">
    .sigup-div {
        margin-top: 15px;


    }

    .calculator{
        border-style: solid;
        border-color: #ff7200;
        border-radius: 25px;
        border-width: thin;
    }
    input[type=text], input[type=email], input[type=password], input[type=number] {
        height: 50px;
        border-radius: 25px !important;

    }


</style>

<div class="container sigup" >

    <div class="col col-md-8 col-md-offset-2"  style="margin-top: 100px;">
        <div class="row">
            <?php
            if (!$error_message !='' and $success_message == ''){
                echo "<div class='alert alert-danger'>".$error_message."</div>";
            }
            elseif($error_message== '' and $success_message!=''){
                echo "<div class='alert alert-success'>".$success_message."</div>";
            }
            ?>

            <div class="head_title">
                <h2>Sign up</h2>
                <div class="separator"></div>
            </div>

            <div class="calculator">

            <form class="form-group" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="margin: 25px;">

                <fieldset>
                    <legend><p style="font-size: 1em;">Create account and start to enjoy our services</p></legend>

                    <div class="row">
                        <div class="col col-md-6">
                            <div class="sigup-div">
                                <input type="text" name="first_name" class="form-control" placeholder="First Name"
                                       required>
                            </div>
                        </div>

                        <div class="col col-md-6">
                            <div class="sigup-div">
                                <input type="text" name="last_name" class="form-control" placeholder="Last Name"
                                       required>
                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col col-md-6">
                            <div class="sigup-div">
                                <input type="email" name="paypal_email" class="form-control" placeholder="Paypal email"
                                       required>
                            </div>
                        </div>

                        <div class="col col-md-6">
                            <div class="sigup-div">
                                <input type="number" name="id_no" class="form-control" placeholder="National ID No"
                                       required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-6">
                            <div class="sigup-div">
                                <input type="number" name="phone_number" class="form-control"
                                       placeholder="Phone Number (07 XXX XXX)" required>
                            </div>
                        </div>

                        <div class="col col-md-6">
                            <div class="sigup-div">
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                       required>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="row">
                    <div class="col-md-6 col-md-offset-0 pull-left">
                        <input type="submit" name="submit" class="btn btn-primary" value="Sign Up" style="margin-top: 10px; margin-left: 10px;">
                    </div>
            </form>
        </div>



        </div>

        </div>

    </div>
</div>
</div>


