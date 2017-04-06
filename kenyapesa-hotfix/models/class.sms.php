<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/24/17
 * Time: 10:14 PM
 */

require_once 'AfricasTalkingGateway.php';
require_once __DIR__.'/../db/class.db.php';

class Sms{


    private $receiver = '+254701201390';
    private $message;
    private $apiKey = 'b9d8146b2640b921a1641b35de0d4c383274d5c25276087e87006ec6b1d52322';
    private $username = 'premierpesa';

    /**
     * @return mixed
     */
    public function getMessage()
    {

        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param mixed $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getReceiver()
    {
        global $conn;
        try{

            $stmt = $conn->prepare("SELECT phone_number FROM merchants WHERE `boardStatus`=1 LIMIT 1");
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $phone_number = $row['phone_number'];
                return $phone_number;
            }
            else{
                return $this->receiver;
            }


        } catch (PDOException $e){
            //return the default receiver in case of error
            return $this->receiver;
        }
    }

    /**
     * @param mixed $receiver
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }


    public function send(){
        try{
            $username = $this->getUsername();
            $apiKey = $this->getApiKey();

            $gateway = new AfricasTalkingGateway($username, $apiKey);
            $sent = $gateway->sendMessage($this->getReceiver(), $this->getMessage());
            return $sent ? true : false;

        } catch (AfricasTalkingGatewayException $e){
            echo $e->getMessage();
            return false;
        }
    }
}

