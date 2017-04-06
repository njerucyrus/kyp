<?php
session_start();
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/20/17
 * Time: 8:36 PM
 */
require_once __DIR__ . '/../models/class.payment.php';
require_once __DIR__ . '/../models/class.calculator.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/class.sms.php';
require_once __DIR__ . '/../models/class.merchant.php';

class Paypal_IPN
{
    private $_url;

    public function __construct($mode = 'live')
    {
        if ($mode == 'live') {
            $this->_url = "https://www.paypal.com/cgi-bin/webscr";
        } elseif ($mode == 'sandbox') {
            $this->_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
        }
    }

    public function run()
    {

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        // Read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        //$get_magic_quotes_exists = false;
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }


        $postFields = 'cmd=_notify-validate';
        foreach ($_POST as $key => $value) {
            $postFields .= "&$key=" . urlencode($value);
        }
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $this->_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $req,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_HTTPHEADER => array('Connection: Close', 'User-Agent: PremierePesa')
        ));
        $result = curl_exec($ch);

        $tokens = explode("\r\n\r\n", trim($result));
        $result = trim(end($tokens));

        if (strcmp($result, "VERIFIED") == 0 || strcasecmp($result, "VERIFIED") == 0) {

            //Payment data
            $item_number = $_POST['item_number'];
            $txn_id = $_POST['txn_id'];
            $payment_gross = $_POST['mc_gross'];
            $payment_status = $_POST['payment_status'];
            $buyer_email = $_POST['payer_email'];

            if ($payment_status == 'Completed') {

                //Check if payment data exists with the same TXN ID.
                $table = 'payments';
                $fields = array('transaction_id');
                $options = array("transaction_id" => $txn_id);

                $prevPayment = Payment::customFilter($table, $fields, $options);
                if (!is_null($prevPayment)) {
                    exit();
                } else {
                    //get user id using the pay paypal email

                    $userObject = User::getById($buyer_email);

                    $table = 'merchants';
                    $fields = array("merchant_email");
                    $options = array(
                        "status" => 1,
                        "limit" => 1
                    );

                    $merchantObject = Merchant::customFilter($table, $fields, $options);
                    $merchant_email = 'quickserve@hudutech.com';
                    if (!is_null($merchantObject)) {
                        $merchant = $merchantObject->fetch(PDO::FETCH_ASSOC);
                        $merchant_email = $merchant['merchant_email'];
                    }

                    if (!is_null($userObject)) {
                        $user = $userObject->fetch(PDO::FETCH_ASSOC);
                        $user_id = $user['id'];
                        // insert data into the database
                        $shillings = PesaCalc::calculate($payment_gross);
                        $payment = new Payment();
                        $payment->setItemId($item_number);
                        $payment->setTransactionId($txn_id);
                        $payment->setStatus($payment_status);
                        $payment->setDollars($payment_gross);
                        $payment->setPaypalEmail($buyer_email);
                        $payment->setUserId($user_id);
                        $payment->setShilling($shillings);
                        $payment->create();

                        $message = $buyer_email . " Has purchased MPESA TOPUP of " . $payment_gross . " USD Send this user KSH " . $shillings . " to MPESA ACC: " . $user['phone_number'] . " (Your Current Paypal Receiver Email: " . $merchant_email . ")";

                        $sms = new Sms();
                        $sms->setMessage($message);
                        $sms->send();

                    } else {
                        //create payment without user id. incase the
                        //uses different email other than the one they registered with
//                        $user = $userObject->fetch(PDO::FETCH_ASSOC);
//                        $user_id = $user['id'];
                        // insert data into the database
                        $shillings = PesaCalc::calculate($payment_gross);
                        $payment = new Payment();
                        $payment->setItemId($item_number);
                        $payment->setTransactionId($txn_id);
                        $payment->setStatus($payment_status);
                        $payment->setDollars($payment_gross);
                        $payment->setPaypalEmail($buyer_email);
                        $payment->setUserId(null);
                        $payment->setShilling($shillings);


                        $userObject = User::getById($_SESSION['username']);
                        $buyer_phone = 'Not Provided';
                        if (!is_null($userObject)) {
                            $user = $userObject->fetch(PDO::FETCH_ASSOC);
                            $buyer_phone = $user['phone_number'];
                            $payment->setUserId($user['id']);
                        }


                        $message = $buyer_email . " Has purchased MPESA TOPUP of " . $payment_gross . " USD Send this user KSH " . $shillings . " to MPESA ACC: " . $buyer_phone . " (Your Current Paypal Receiver Email: " . $merchant_email . ")";

                        $sms = new Sms();
                        $sms->setMessage($message);
                        $sms->send();

                        $payment->create();


                    }

                }
            } else {
                exit();
            }
        }
        // close curl
        curl_close($ch);

    }
}

//execute the paypal ipn
$ipn = new Paypal_IPN();
$ipn->run();