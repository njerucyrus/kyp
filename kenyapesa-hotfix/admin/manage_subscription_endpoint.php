<?php

/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 20/03/2017
 * Time: 11:33
 */

require_once __DIR__.'/../models/class.subscription.php';

if(isset( $_POST['option'])){
    $option = $_POST['option'];
    switch ($option){
        case 'delete':
            deleteSubscription();
            break;

    }

}

function deleteSubscription(){
    if(isset($_POST['id'])){

        $id =$_POST['id'];

        $deleted= Subscription::delete($id);
        if ($deleted) {

            print_r(json_encode(array(
                "statusCode" => 200,
                "message" => "Email Deleted Successfully"
            )));
        } else {
            print_r(json_encode(array(
                "statusCode" => 500,
                "message" => "Error occurred"
            )));
        }


    }
    else{
        print_r(json_encode(array(
            "statusCode" => 500,
            "message" => "All fields required"
        )));

    }

}
