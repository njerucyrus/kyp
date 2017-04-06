<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/22/17
 * Time: 4:14 PM
 */

require_once __DIR__.'/../models/class.merchant.php';
require_once __DIR__.'/../models/class.phone_number.php';


if (isset($_POST['option'])){
    $option =  $_POST['option'];
    switch ($option){
        case 'activate':
            activate();
            break;
        case 'deactivate':
            deactivate();
            break;

        case 'create':
            create();
            break;

        case 'update':
            update();
            break;

        case 'delete':
            delete();
            break;

    }
}

function activate(){
    if(isset($_POST['id'])){
        $id = $_POST['id'];

        $activated = Merchant::activateMerchantEmail($id);
        if ($activated){
            print_r(json_encode(array(
                "statusCode" => 200,
                "message" => "Merchant Email Activated successfully"
            )));
        } else {
            print_r(json_encode(array(
                "statusCode" => 500,
                "message" => "Error occurred"
            )));
        }
    }
    else {
        print_r(json_encode(array(
            "statusCode" => 500,
            "message" => "id not set "
        )));
    }
}

function deactivate(){
    if(isset($_POST['id'])){
        $id = $_POST['id'];

        $deactivated = Merchant::deactivateMerchantEmail($id);

        if ($deactivated){
            print_r(json_encode(array(
                "statusCode" => 200,
                "message" => "Merchant Email deactivated successfully"
            )));
        } else {
            print_r(json_encode(array(
                "statusCode" => 500,
                "message" => "Error occurred"
            )));
        }
    }
    else {
        print_r(json_encode(array(
            "statusCode" => 500,
            "message" => "id not set "
        )));
    }
}


function create(){
    if(isset($_POST['email']) and isset($_POST['phone_number'])){
        $email = $_POST['email'];

        $merchant = new Merchant();
        $phoneNumberObj = new PhoneNumber($_POST['phone_number']);
        $phoneNumber = $phoneNumberObj->addPrefix();

        $merchant->setMerchantEmail($email);
        $merchant->setPhoneNumber($phoneNumber);

        $created = $merchant->create();

        if ($created) {
            print_r(json_encode(array(
                "statusCode" => 200,
                "message" => "Merchant Email Added successfully"
            )));
        } else {
            print_r(json_encode(array(
                "statusCode" => 500,
                "message" => "Error occurred"
            )));
        }
    }
    else {
        print_r(json_encode(array(
            "statusCode" => 500,
            "message" => "email required "
        )));
    }
}


function update(){
    if(isset($_POST['id']) and isset($_POST['email']) and isset($_POST['phone_number'])){
        $id = $_POST['id'];
        $email = $_POST['email'];

        $merchant = new Merchant();

        $phoneNumberObj = new PhoneNumber($_POST['phone_number']);
        $phoneNumber = $phoneNumberObj->addPrefix();
        $merchant->setMerchantEmail($email);
        $merchant->setPhoneNumber($phoneNumber);

        $updated = $merchant->update($id);

        if ($updated){
            print_r(json_encode(array(
                "statusCode" => 200,
                "message" => "Merchant Email updated successfully"
            )));
        } else {
            print_r(json_encode(array(
                "statusCode" => 500,
                "message" => "Error occurred"
            )));
        }
    }
    else {
        print_r(json_encode(array(
            "statusCode" => 500,
            "message" => "email required "
        )));
    }
}


function delete(){
    if(isset($_POST['id'])){
        $id = $_POST['id'];

        $deleted = Merchant::delete($id);

        if ($deleted){
            print_r(json_encode(array(
                "statusCode" => 200,
                "message" => "Merchant Email deleted successfully"
            )));
        } else {
            print_r(json_encode(array(
                "statusCode" => 500,
                "message" => "Error occurred"
            )));
        }
    }
    else {
        print_r(json_encode(array(
            "statusCode" => 500,
            "message" => "id not set "
        )));
    }
}