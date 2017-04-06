<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 18/03/2017
 * Time: 09:58
 */
require_once __DIR__ . '/../models/class.subscription.php';

$request_method = $_SERVER['REQUEST_METHOD'];
if ($request_method == 'POST') {
    if (isset($_POST['name']) and isset($_POST['email'])) {

        $name = $_POST['name'];
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email";
        }
        $subscription = new Subscription();
        $subscription->setName($name);
        $subscription->setEmail($email);
        $created = $subscription->create();
        if ($created) {
            $message = "You have subscribed successfully";
        }
        else{
            $message = "Error occurred";
        }
    } else {
        $message = "all fields required";
    }
}
else{
    $message = '';
}
?>


