<?php

/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/19/17
 * Time: 3:28 PM
 */
trait CustomMailing
{

    /**
     * gets the list of all users subscribed to
     * our mailing list
     * @return array|null
     */
    public static function getSubscriberMailingList()
    {
        global $conn;
        try {

            $stmt = $conn->prepare("SELECT email FROM subscription WHERE 1");

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $recipient = array();
                while ($list = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    array_push($recipient, $list['email']);
                }
                return $recipient;

            } else {
                return null;
            }

        } catch (PDOException $e) {

            print_r(json_encode(array(
                'statusCode' => 500,
                'message' => "Error " . $e->getMessage()
            )));
            return null;

        }
    }

    /**
     * sends mail to all the subscribers
     * @param $subject
     * @param $message
     * @return bool
     */
    public static function sendSubscriptionMail($subject, $message)
    {

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        $recipients = self::getSubscriberMailingList();
        if (!empty($recipients)) {

            $to = rtrim(implode(',', $recipients), ',');
            $sent = mail($to, $subject, $message, implode("\r\n", $headers));
            if ($sent) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    /**
     * @param $to
     * @return bool
     * used for sending custom email.
     */
    public function sendMail($to){

        $name = $this->getFirstName() ."  ".$this->getLastName();
        $sender = $this->getSenderEmail();
        $subject = $this->getSubject();
        $message = $this->getEmailMessage();

        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = "From:$name <$sender>";

        $sent = mail($to, $subject, $message, implode("\r\n", $headers));
        return $sent ? true : false;
    }


}