<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/15/17
 * Time: 11:34 AM
 */
require_once __DIR__ . '/../db/class.db.php';
require_once 'interface.crud.php';

class Rate implements PesaCrud
{
    private $minValue;
    private $maxValue;
    private $fixedDollar;
    private $percentage;

    /**
     * @return mixed
     */
    public function getMinValue()
    {
        return $this->minValue;
    }

    /**
     * @param mixed $minValue
     */
    public function setMinValue($minValue)
    {
        $this->minValue = $minValue;
    }

    /**
     * @return mixed
     */
    public function getMaxValue()
    {
        return $this->maxValue;
    }

    /**
     * @param mixed $maxValue
     */
    public function setMaxValue($maxValue)
    {
        $this->maxValue = $maxValue;
    }

    /**
     * @return mixed
     */
    public function getFixedDollar()
    {
        return $this->fixedDollar;
    }

    /**
     * @param mixed $fixedDollar
     */
    public function setFixedDollar($fixedDollar)
    {
        $this->fixedDollar = $fixedDollar;
    }

    /**
     * @return mixed
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @param mixed $percentage
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
    }


    public function create()
    {
        global $conn;

        $minValue = $this->getMinValue();
        $maxValue = $this->getMaxValue();
        $fixedDollar = $this->getFixedDollar();
        $percentage = $this->getPercentage();

        try {
            $stmt = $conn->prepare("INSERT INTO rates(min_value, max_value, fixed_dollar, percentage)
                                  VALUES (:min_value, :max_value, :fixed_dollar, :percentage)");

            $stmt->bindParam(":min_value", $minValue);
            $stmt->bindParam(":max_value", $maxValue);
            $stmt->bindParam(":fixed_dollar", $fixedDollar);
            $stmt->bindParam(":percentage", $percentage);
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

        $minValue = $this->getMinValue();
        $maxValue = $this->getMaxValue();
        $fixedDollar = $this->getFixedDollar();
        $percentage = $this->getPercentage();

        try {

            $stmt = $conn->prepare("UPDATE rates SET min_value=:min_value, max_value=:max_value, 
                                  fixed_dollar=:fixed_dollar, percentage=:percentage
                                  WHERE id=:id");

            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":min_value", $minValue);
            $stmt->bindParam(":max_value", $maxValue);
            $stmt->bindParam(":fixed_dollar", $fixedDollar);
            $stmt->bindParam(":percentage", $percentage);

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

            $stmt = $conn->prepare("DELETE FROM rates WHERE id=:id");
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
            $stmt = $conn->prepare("SELECT * FROM rates WHERE id=:id");

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

    public static function all()
    {
        global $conn;
        try {

            $stmt = $conn->prepare("SELECT * FROM rates WHERE 1");
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


    public static function getRate($amount)
    {
        global $conn;

        try {

            $new_amount = (float)$amount;

            $stmt = $conn->prepare("SELECT * FROM rates WHERE min_value<='{$new_amount}' AND max_value>='{$new_amount}'");

            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return array(
                    "fixed" => $row['fixed_dollar'],
                    "percentage" => $row['percentage']
                );
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

}


