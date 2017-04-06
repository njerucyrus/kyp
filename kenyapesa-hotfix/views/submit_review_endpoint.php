<?php

/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/22/17
 * Time: 9:55 AM
 */

require_once __DIR__.'/../models/class.feedback.php';

if(isset($_POST['user_id']) and isset($_POST['review'])) {
    $userId = $_POST['user_id'];
    $text = $_POST['review'];

    $review = new UserFeedback();
    $review->setUserId($userId);
    $review->setText($text);
    $review->setApproved(0);
    $created = $review->create();
    if ($created) {
        print_r(json_encode(array(
            "statusCode" => 200,
            "message" => "review submitted successfully"
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
        "emailMessage" => "Missing text"
    )));
}

