<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/17/17
 * Time: 1:16 AM
 */

require_once __DIR__.'/../db/class.db.php';
require_once 'interface.crud.php';
class Limit implements PesaCrud {

    private $minLimit;
    private $maxLimit;
    private $exchangeRate;

    /**
     * @return mixed
     */
    public function getMinLimit()
    {
        return $this->minLimit;
    }

    /**
     * @param mixed $minLimit
     */
    public function setMinLimit($minLimit)
    {
        $this->minLimit = $minLimit;
    }

    /**
     * @return mixed
     */
    public function getMaxLimit()
    {
        return $this->maxLimit;
    }

    /**
     * @param mixed $maxLimit
     */
    public function setMaxLimit($maxLimit)
    {
        $this->maxLimit = $maxLimit;
    }

    /**
     * @return mixed
     */
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }

    /**
     * @param mixed $exchangeRate
     */
    public function setExchangeRate($exchangeRate)
    {
        $this->exchangeRate = $exchangeRate;
    }



    /**
     * @return mixed
     */
    public function create()
    {
        global $conn;
        try{

            $minLimit = $this->getMinLimit();
            $maxLimit = $this->getMaxLimit();
            $exchangeRate = $this->getExchangeRate();



            $stmt = $conn->prepare("INSERT INTO limits(min_limit, max_limit, exchange_rate)
                                  VALUES (:min_limit, :max_limit, :exchange_rate)");

            $stmt->bindParam(":min_limit", $minLimit);
            $stmt->bindParam(":max_limit", $maxLimit);
            $stmt->bindParam(":exchange_rate", $exchangeRate);
            $stmt->execute();
            return true;

        }catch (PDOException $e) {
            print_r(json_encode(array(
                'statusCode' => 500,
                'message' => "Error " . $e->getMessage()
            )));

            return false;
        }

    }

    /**
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        global $conn;

        try{

            $minLimit = $this->getMinLimit();
            $maxLimit = $this->getMaxLimit();
            $exchangeRate = $this->getExchangeRate();

            $stmt = $conn->prepare("UPDATE limits SET min_limit=:min_limit, max_limit=:max_limit, exchange_rate=:exchange_rate
                                  WHERE id=:id");
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":min_limit", $minLimit);
            $stmt->bindParam(":max_limit", $maxLimit);
            $stmt->bindParam(":exchange_rate", $exchangeRate);
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
     * @return mixed
     */
    public static function delete($id)
    {
        global $conn;
        try{
            $stmt = $conn->prepare("DELETE FROM limits WHERE id=:id");
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
     * @return mixed
     */
    public static function getById($id)
    {
        global $conn;
        try{

            $stmt = $conn->prepare("SELECT * FROM limits WHERE id=:id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            if($stmt->rowCount()> 0) {
                return $stmt;
            }
            else{
                return null;
            }

        } catch (PDOException $e){
            print_r(json_encode(array(
                'statusCode' => 500,
                'message' => "Error " . $e->getMessage()
            )));

            return null;
        }
    }

    /**
     * @return mixed
     */
    public static function all()
    {
        global $conn;
        try{

            $stmt = $conn->prepare("SELECT * FROM limits WHERE 1");
            $stmt->execute();
            if($stmt->rowCount() > 0 ) {
                return $stmt;
            }
            else {
                return null;
            }

        } catch (PDOException $e){
            print_r(json_encode(array(
                'statusCode' => 500,
                'message' => "Error " . $e->getMessage()
            )));

            return null;
        }
    }

    public static function getLimits(){
        global $conn;
        try{

            $stmt = $conn->prepare("SELECT * FROM limits LIMIT 1");
            $stmt->execute();
            if($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return array(
                    "min"=>$row['min_limit'],
                    "max"=>$row['max_limit']
                );

            }
            else{
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
    public static function getCurrentExchangeRate(){

        global $conn;
        try{

            $stmt = $conn->prepare("SELECT * FROM limits LIMIT 1");
            $stmt->execute();
            if($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return array(
                    "exchange_rate"=>$row['exchange_rate'],

                );

            }
            else{
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
}

