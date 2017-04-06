<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/14/17
 * Time: 11:02 PM
 */

include_once 'interface.crud.php';
include_once 'class.auth.php';

class User extends Auth implements PesaCrud
{
    private $firstName;
    private $lastName;
    private $paypalEmail;
    private $phoneNumber;
    private $status;
    private $idNo;
    private $amountLimit;
    private $transactionLimit;
    private $password;

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getPaypalEmail()
    {
        return $this->paypalEmail;
    }

    /**
     * @param mixed $paypalEmail
     */
    public function setPaypalEmail($paypalEmail)
    {
        $this->paypalEmail = $paypalEmail;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getIdNo()
    {
        return $this->idNo;
    }

    /**
     * @param mixed $idNo
     */
    public function setIdNo($idNo)
    {
        $this->idNo = $idNo;
    }

    /**
     * @return mixed
     */
    public function getAmountLimit()
    {
        return $this->amountLimit;
    }

    /**
     * @param mixed $amountLimit
     */
    public function setAmountLimit($amountLimit)
    {
        $this->amountLimit = $amountLimit;
    }

    /**
     * @return mixed
     */
    public function getTransactionLimit()
    {
        return $this->transactionLimit;
    }

    /**
     * @param mixed $transactionLimit
     */
    public function setTransactionLimit($transactionLimit)
    {
        $this->transactionLimit = $transactionLimit;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }


    public function create()
    {
        global $conn;

        try {

            $firstName = $this->getFirstName();
            $lastName = $this->getLastName();
            $paypalEmail = $this->getPaypalEmail();
            $phoneNumber = $this->getPhoneNumber();
            $idNo = $this->getIdNo();
            $amountLimit = $this->getAmountLimit();
            $transactionLimit = $this->getTransactionLimit();
            $password = $this->getPassword();

            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name,
                                    paypal_email, phone_number, 
                                    id_no, transaction_limit,
                                    amount_limit, password) VALUES(:first_name, :last_name,
                                    :paypal_email, :phone_number, 
                                    :id_no,  :transaction_limit,
                                    :amount_limit, :password) ");

            $stmt->bindParam(":first_name", $firstName);
            $stmt->bindParam(":last_name", $lastName);
            $stmt->bindParam(":paypal_email", $paypalEmail);
            $stmt->bindParam(":phone_number", $phoneNumber);
            $stmt->bindParam(":id_no", $idNo);
            $stmt->bindParam(":transaction_limit", $transactionLimit);
            $stmt->bindParam(":amount_limit", $amountLimit);
            $stmt->bindParam(":password", $password);

            $stmt->execute();
            return true;


        } catch (PDOException $e) {
            print_r(json_encode(array(
                'statusCode' => 500,
                'message' => "Error " . $e->getMessage()
            )));
            return false;

        }
    }

    public function update($id)
    {
        global $conn;

        try {

            $firstName = $this->getFirstName();
            $lastName = $this->getLastName();
            $paypalEmail = $this->getPaypalEmail();
            $phoneNumber = $this->getPhoneNumber();
            $idNo = $this->getIdNo();
            $status = $this->getStatus();
            $amountLimit = $this->getAmountLimit();
            $transactionLimit = $this->getTransactionLimit();
            $password = $this->getPassword();

            $stmt = $conn->prepare("UPDATE users SET first_name=:first_name, last_name=:last_name,
                                 paypal_email=:paypal_email,phone_number=:phone_number,
                                  id_no=:id_no, status=:status, amount_limit=:amount_limit,
                                  transaction_limit=:transaction_limit, password=:password
                                  WHERE id=:id");

            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":first_name", $firstName);
            $stmt->bindParam(":last_name", $lastName);
            $stmt->bindParam(":paypal_email", $paypalEmail);
            $stmt->bindParam(":phone_number", $phoneNumber);
            $stmt->bindParam(":id_no", $idNo);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":transaction_limit", $transactionLimit);
            $stmt->bindParam(":amount_limit", $amountLimit);
            $stmt->bindParam(":password", $password);

            $stmt->execute();
            return true;


        } catch (PDOException $e) {

            print_r(json_encode(array(
                'statusCode' => 500,
                'message' => "Error " . $e->getMessage()
            )));
            return false;
        }
    }

    public static function delete($id)
    {
        global $conn;
        try {
            $stmt = $conn->prepare("DELETE FROM users WHERE id='{$id}'");
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            print_r(json_encode(array(
                'statusCode' => 500,
                'message' => "Error " . $e->getMessage()
            )));
            return false;
        }
    }

    public static function getById($paypal_email)
    {
        global $conn;

        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE paypal_email= '{$paypal_email}'");
            $stmt->execute();

            return $stmt->rowCount() > 0 ? $stmt : null;

        } catch (PDOException $e) {
            print_r(json_encode(array(
                'statusCode' => 500,
                'message' => "Error " . $e->getMessage()
            )));
            return null;
        }
    }

    public static function getId($id)
    {
        global $conn;
        try {

            $stmt = $conn->prepare("SELECT * FROM users WHERE id='{$id}'");

            $stmt->execute();

            return $stmt->rowCount() > 0 ? $stmt : null;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function all()
    {
        global $conn;

        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE 1");

            $stmt->execute();

            return $stmt->rowCount() > 0 ? $stmt : null;


        } catch (PDOException $e) {
            print_r(json_encode(array(
                'statusCode' => 500,
                'message' => "Error " . $e->getMessage()
            )));
            return null;
        }
    }

    /**
     * @param $id
     * @param $status
     * @return bool
     * add or remove admin status
     */
    public static function promoteDemote($id, $status)
    {
        global $conn;

        try {

            $stmt = $conn->prepare("UPDATE users SET is_admin='{$status}' WHERE id=:id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return true;

        } catch (PDOException $e) {

            print_r(json_encode(array(
                'statusCode' => 500,
                'message' => "Error " . $e->getMessage()
            )));
            return false;

        }
    }

    /**
     * @param $id
     * @return bool
     * Approve the user account
     */
    public static function approveAccount($id)
    {
        global $conn;

        try {

            $stmt = $conn->prepare("UPDATE users SET `status`='approved' WHERE id=:id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return true;

        } catch (PDOException $e) {

            print_r(json_encode(array(
                'statusCode' => 500,
                'message' => "Error " . $e->getMessage()
            )));
            return false;

        }
    }


    /**
     * @param $id
     * @param $status
     * @return bool
     */
    public static function blockUnblockAccount($id, $status)
    {
        global $conn;
        try {

            $stmt = $conn->prepare("UPDATE users SET `status`='{$status}' WHERE `id`=:id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {

            print_r(json_encode(array(
                'statusCode' => 500,
                'message' => "Error " . $e->getMessage()
            )));
            return false;

        }

    }

    public static function updateLimits($id, $limits)
    {
        global $conn;
        if (is_array($limits)) {
            $transactionLimit = $limits['transaction_limit'];
            $amountLimit = $limits['amount_limit'];
            try {
                $stmt = $conn->prepare("UPDATE users SET transaction_limit =:transaction_limit, amount_limit=:amount_limit
                                    WHERE id=:id");
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":transaction_limit", $transactionLimit);
                $stmt->bindParam(":amount_limit", $amountLimit);
                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                print_r(json_encode(array(
                    'statusCode' => 500,
                    'message' => "Error " . $e->getMessage()
                )));
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param $paypalEmail
     * @return array|null
     */
    public static function getUserLimits($paypalEmail)
    {
        global $conn;
        try {
            $stmt = $conn->prepare("SELECT transaction_limit,amount_limit FROM users WHERE paypal_email=:paypal_email");

            $stmt->bindParam(":paypal_email", $paypalEmail);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return array(
                "txn_limit" => $row['transaction_limit'],
                "amt_limit" => $row['amount_limit']
            );

        } catch (PDOException $e) {
            print_r(json_encode(array(
                'statusCode' => 500,
                'message' => "Error " . $e->getMessage()
            )));
            return null;
        }
    }

    /**
     * @return array
     */
    public static function getUserStats()
    {
        global $conn;
        try {

            $blocked_stmt = $conn->prepare("SELECT count(id) as blocked FROM users WHERE `status`='blocked'");
            $approved_stmt = $conn->prepare("SELECT count(id) as approved FROM users WHERE `status`='approved'");
            $pending_stmt = $conn->prepare("SELECT count(id) as pending FROM users WHERE `status`='pending'");
            $total_stmt = $conn->prepare("SELECT count(id) as total_users FROM users WHERE 1");

            $blocked_stmt->execute();
            $approved_stmt->execute();
            $pending_stmt->execute();
            $total_stmt->execute();
            $user_stats = array();
            if($blocked_stmt->rowCount() == 1){
                $row = $blocked_stmt->fetch(PDO::FETCH_ASSOC);
                array_push($user_stats, ["blocked"=>$row['blocked']]);
            }
            if ($approved_stmt->rowCount() == 1){
                $row = $approved_stmt->fetch(PDO::FETCH_ASSOC);
                array_push($user_stats, ["approved"=> $row['approved']]);
            }

            if ($pending_stmt->rowCount() == 1){
                $row = $pending_stmt->fetch(PDO::FETCH_ASSOC);
                array_push($user_stats, ["pending"=> $row['pending']]);
            }


            if ($total_stmt->rowCount() == 1){
                $row = $total_stmt->fetch(PDO::FETCH_ASSOC);
                array_push($user_stats, ["total_users"=>$row['total_users']]);
            }
            return $user_stats;

        } catch (PDOException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }
}

