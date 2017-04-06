<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/22/17
 * Time: 2:34 PM
 */
require_once __DIR__ . '/interface.crud.php';
require_once __DIR__ . '/trait.query.php';
require_once __DIR__ . '/../db/class.db.php';

class Merchant implements PesaCrud
{

    use ComplexQuery;

    private $merchantEmail;
    private $phoneNumber;
    private $status;

    /**
     * @return mixed
     */
    public function getMerchantEmail()
    {
        return $this->merchantEmail;
    }

    /**
     * @param mixed $merchantEmail
     */
    public function setMerchantEmail($merchantEmail)
    {
        $this->merchantEmail = $merchantEmail;
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
     * @return bool
     * create a new merchant into the database
     */
    public function create()
    {
        global $conn;
        try {

            $merchantEmail = $this->getMerchantEmail();
            $phoneNumber = $this->getPhoneNumber();

            $stmt = $conn->prepare("INSERT INTO merchants(merchant_email, phone_number) VALUES (:merchant_email, :phone_number)");

            $stmt->bindParam(":merchant_email", $merchantEmail);
            $stmt->bindParam(":phone_number", $phoneNumber);
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
     */
    public function update($id)
    {
        global $conn;
        try {

            $merchantEmail = $this->getMerchantEmail();
            $phoneNumber = $this->getPhoneNumber();

            $stmt = $conn->prepare("UPDATE merchants SET merchant_email=:merchant_email, 
                                    phone_number=:phone_number WHERE id=:id");

            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":merchant_email", $merchantEmail);
            $stmt->bindParam(":phone_number", $phoneNumber);
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
     */
    public static function delete($id)
    {
        global $conn;
        try {

            $stmt = $conn->prepare("DELETE FROM merchants WHERE id=:id");

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
     * @return null|PDOStatement
     */
    public static function getById($id)
    {
        global $conn;
        try {

            $stmt = $conn->prepare("SELECT * FROM merchants WHERE id=:id");

            $stmt->bindParam(":id", $id);
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
     * @return null|PDOStatement
     */
    public static function all()
    {
        global $conn;
        try {

            $stmt = $conn->prepare("SELECT * FROM merchants WHERE 1");

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
     * @return bool
     * set the mail with the specified id active.
     * only active mail will be used in paypal
     */
    public static function activateMerchantEmail($id)
    {
        global $conn;
        try {


            $stmt = $conn->prepare("UPDATE merchants SET `status`=1 WHERE id=:id;
                                    UPDATE merchants SET `status`=0 WHERE id!=:id;
                                   ");

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
     */
    public static function deactivateMerchantEmail($id)
    {
        global $conn;
        try {


            $stmt = $conn->prepare("UPDATE merchants SET `status`=0 WHERE id=:id;");

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

    public static function getActiveMerchant()
    {
        global $conn;
        try {
            $stmt = $conn->prepare("SELECT `merchant_email`, `phone_number` FROM `merchants` WHERE `status`=1 LIMIT 1");
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $merchant = array(
                    "merchant_email" => $row['merchant_email'],
                    "phone_number" => $row['phone_number']
                );
                return $merchant;
            }
            else{
                return [];
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
            return [];
        }
    }

}
