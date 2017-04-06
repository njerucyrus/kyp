<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/18/17
 * Time: 4:47 PM
 */
require_once __DIR__ . '/../models/user.php';
require_once __DIR__.'/../models/class.contactus.php';

$request_method = $_SERVER['REQUEST_METHOD'];
$option = $_POST['option'];

    switch ($option) {
        case 'update_limit':
            updateLimits();
            break;
        case 'block_user':
            blockUnblockUser();
            break;
        case 'approve':
            approveAccount();
            break;
        case 'promote_user':
            promoteDemote();
            break;

    }

    function updateLimits()
    {
        global $request_method;
        if ($request_method == 'POST') {

            if (isset($_POST['id']) and isset($_POST['txnLimit']) and isset($_POST['amtLimit'])) {
                $id = $_POST['id'];
                $txnLimit = $_POST['txnLimit'];
                $amtLimit = $_POST['amtLimit'];

                $updated = User::updateLimits($id, array(
                    "transaction_limit" => $txnLimit,
                    "amount_limit" => $amtLimit
                ));

                if ($updated) {
                    print_r(json_encode(array(
                        "statusCode" => 200,
                        "message" => "Limits updated successfully"
                    )));
                } else {
                    print_r(json_encode(array(
                        "statusCode" => 500,
                        "message" => "Error occurred"
                    )));
                }

            }
        }
    }

    function blockUnblockUser()
    {
        if (isset($_POST['id'])) {
            $userId = (int)$_POST['id'];
            $status = $_POST['status'];
            $blocked = User::blockUnblockAccount($userId, $status);
            if ($blocked) {
                $message = '';
                if ($status=='blocked'){
                    $message = 'User Blocked Successfully';

                    $stmt = User::getId($userId);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    $contact = new ContactUs();
                    $contact->setFirstName("PremierPesa");
                    $contact->setLastName(" ");
                    $contact->setSubject("PremierPesa Account Blocked");
                    $contact->setEmailMessage("Your PremierPesa account <".$user['paypal_email']."> has been Blocked Contact info@premierpesa.co.ke for more details");
                    $contact->setSenderEmail('info@premierpesa.co.ke');
                    $contact->sendMail($user['paypal_email']);
                }
                elseif ($status=='approved'){
                    $message = 'User Unblocked Successfully';

                    $stmt = User::getId($userId);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    $contact = new ContactUs();
                    $contact->setFirstName("PremierPesa");
                    $contact->setLastName(" ");
                    $contact->setSubject("PremierPesa Account Unblocked");
                    $contact->setEmailMessage("Your PremierPesa account <".$user['paypal_email']."> has been Unblocked. Welcome back!.");
                    $contact->setSenderEmail('info@premierpesa.co.ke');
                    $contact->sendMail($user['paypal_email']);
                }
                print_r(json_encode(array(
                    "statusCode" => 200,
                    "message" => $message
                )));
            } else {
                print_r(json_encode(array(
                    "statusCode" => 500,
                    "message" => "Error occurred"
                )));
            }
        }
    }

function approveAccount(){

    if (isset($_POST['id'])) {
        $userId = (int)$_POST['id'];

        $approved = User::approveAccount($userId);
        if ($approved) {
            $stmt = User::getId($userId);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $contact = new ContactUs();
            $contact->setFirstName("PremierPesa");
            $contact->setLastName(" ");
            $contact->setSubject("PremierPesa Account Approval");
            $contact->setEmailMessage("Your PremierPesa account <".$user['paypal_email']."> has been verified and approved. You can now start using PremierPesa");
            $contact->setSenderEmail('info@premierpesa.co.ke');
            $contact->sendMail($user['paypal_email']);
            print_r(json_encode(array(
                "statusCode" => 200,
                "message" => "Account Approved Successfully"
            )));
        } else {
            print_r(json_encode(array(
                "statusCode" => 500,
                "message" => "Error occurred"
            )));
        }
    }
}

function promoteDemote(){
    if (isset($_POST['id'])) {
        $userId = (int)$_POST['id'];
        $status = $_POST['status'];
        $promoted = User::promoteDemote($userId, $status);
        if ($promoted) {
            $message = '';
            if ($status==1){
                $message = 'User Promoted to Admin';
            }
            elseif ($status==0){
                $message = 'User Remove from Admin ';
            }
            print_r(json_encode(array(
                "statusCode" => 200,
                "message" => $message
            )));
        } else {
            print_r(json_encode(array(
                "statusCode" => 500,
                "message" => "Error occurred"
            )));
        }
    }
}


