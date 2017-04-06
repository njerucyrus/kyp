<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 23/03/2017
 * Time: 11:11
 */
require_once  __DIR__.'/../models/trait.mail.php';
require_once __DIR__.'/../models/class.contactus.php';
$message='';
if(isset($_POST['first_name']) and isset($_POST['last_name']) and isset($_POST['email']) and isset($_POST['subject']) and isset($_POST['message'])){

    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $body_message = $_POST['message'];

    $contact = new ContactUs();
    $contact->setFirstName($firstName);
    $contact->setLastName($lastName);
    $contact->setEmailMessage($body_message);
    $contact->setSubject($subject);
    $contact->setSenderEmail($email);
    $to = "info@premierpesa.com";
    $sent = $contact->sendMail($to);
    if ($sent === true){
        $message .= "email sent successfully";
    }
    elseif ($sent===false){
        $message .= "error occurred";
    }
}else{
    $message .="all fields required";
}

?>