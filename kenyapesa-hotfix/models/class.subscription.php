<?php
/**
 * Created by PhpStorm.
 * User: New LAptop
 * Date: 17/03/2017
 * Time: 23:38
 */
require_once __DIR__ . '/../db/class.db.php';
require_once 'interface.crud.php';
require_once 'trait.mail.php';

class Subscription implements PesaCrud
{

    use CustomMailing;

    private $name;
    private $email;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    //setting getter and setters
    public function create()
    {
        global $conn;
        try {

            $name = $this->getName();
            $email = $this->getEmail();

            $stmt = $conn->prepare("INSERT INTO subscription(name, email) VALUES(:name,:email)");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
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

            $name = $this->getName();
            $email = $this->getEmail();

            $stmt = $conn->prepare("UPDATE  subscription SET name=:name, email=:email WHERE id=:id");
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
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
            $stmt = $conn->prepare("DELETE FROM subscription WHERE id=:id");
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

    public static function getById($id)
    {
        global $conn;
        try {

            $stmt = $conn->prepare("SELECT * FROM subscription WHERE id=:id");
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

            $stmt = $conn->prepare("SELECT * FROM subscription WHERE 1");
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




}