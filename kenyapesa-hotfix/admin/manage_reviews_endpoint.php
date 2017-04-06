<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/20/17
 * Time: 9:52 AM
 */
require_once __DIR__ . '/../models/class.feedback.php';

if (isset($_POST['option'])) {
    $option = $_POST['option'];
    switch ($option) {
        case 'approve_review':
            approveReview();
            break;
        case 'delete_review':
            deleteReview();
            break;

    }
}

function approveReview()
{
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $approved = UserFeedback::approve($id);
        if ($approved) {
            print_r(json_encode(array(
                "statusCode" => 200,
                "message" => "Review approved successfully"
            )));
        } else {
            print_r(json_encode(array(
                "statusCode" => 500,
                "message" => "Error occurred"
            )));
        }
    } else {
        print_r(json_encode(array(
            "statusCode" => 500,
            "message" => "Error! Could not find the review id"
        )));
    }
}

function deleteReview()
{
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $deleted = UserFeedback::delete($id);
        if ($deleted) {
            print_r(json_encode(array(
                "statusCode" => 200,
                "message" => "Review approved successfully"
            )));
        } else {
            print_r(json_encode(array(
                "statusCode" => 500,
                "message" => "Error occurred"
            )));
        }
    } else {
        print_r(json_encode(array(
            "statusCode" => 500,
            "message" => "Error! Could not find the review id"
        )));
    }
}

