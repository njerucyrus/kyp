<?php

require_once __DIR__ . '/user.php';
require_once __DIR__ . '/class.sms.php';
require_once __DIR__ . '/../db/class.db.php';


/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/30/17
 * Time: 4:30 PM
 */


class ResetPassword
{

    /**
     * @var string
     */
    private $userEmail;
    /**
     * @var string
     */
    private $resetCode;

    /**
     * ResetPassword constructor.
     * @param $userEmail
     */
    public function __construct($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    /**
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * @param string $userEmail
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    /**
     * @return string
     */
    public function getResetCode()
    {
        return $this->resetCode;
    }


    /**
     * @return null|string
     */
    public function retrieveUserPhone()
    {
        $userObject = User::getById($this->getUserEmail());
        if (!is_null($userObject)) {
            $user = $userObject->fetch(PDO::FETCH_ASSOC);

            return array(
                "phone_number"=>$user['phone_number']);
        } else {
            return null;
        }
    }


    /**
     * @param int $length
     * @return string
     */
    public function generateResetCode($length = 6)
    {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        $this->resetCode = $str;
        return $str;

    }

    /**
     *
     */
    public function sendCode()
    {

        $message = "Your PremierPesa Password Reset Code is " . $this->generateResetCode();
        $sms = new Sms();
        $user_phone = $this->retrieveUserPhone();
        $sms->setReceiver($user_phone['phone_number']);
        $sms->setMessage($message);
        $sms->send();


    }

    /**
     * @param $newPassword
     * @return bool
     */
    public function resetPassword($newPassword)
    {
        global $conn;

        try {
            $password_hash = password_hash($newPassword, PASSWORD_BCRYPT);
            $userEmail = $this->getUserEmail();

            $stmt = $conn->prepare("UPDATE users SET password=:password WHERE paypal_email=:user_email");

            $stmt->bindParam(":password", $password_hash);
            $stmt->bindParam(":user_email", $userEmail);
            $stmt->execute();
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}




