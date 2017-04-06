<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/15/17
 * Time: 1:02 AM
 */

require_once __DIR__.'/../db/class.db.php';


class Auth{
    private $token;
    public function authenticate($username, $password)
    {
        global $conn;
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE paypal_email=:username");
            $stmt->bindParam(":username", $username);

            $stmt->execute();

            if ($stmt->rowCount() == 1) {

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return password_verify($password, $row['password']) ? true : false;

            } else {
                return false;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * @param $paypalEmail
     * @return bool
     */
    public function verifyEmail($paypalEmail){
        global $conn;
        try{
            $stmt = $conn->prepare("SELECT `id` FROM users WHERE paypal_email=:paypal_email");
            $stmt->bindParam(":paypal_email", $paypalEmail);
            $stmt->execute();
            return $stmt->rowCount() == 1 ? true : false;
        } catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }

    }

    public function generateCSRF_TOKEN(){
        $this->token = md5(uniqid('auth_token', true));
        return $this->token;
    }
}