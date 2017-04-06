<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/15/17
 * Time: 10:26 AM
 */

require_once 'interface.crud.php';
require_once __DIR__.'/../db/class.db.php';

class UserFeedback implements PesaCrud
{
    private $userId;
    private $approved;
    private $text;

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * @param mixed $approved
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }


    public function create()
    {
        global $conn;

        $userId = $this->getUserId();
        $text = $this->getText();
        $approved = $this->getApproved();

        try {
            $stmt = $conn->prepare("INSERT INTO feedbacks(user_id, text, approved)
                                  VALUES(:user_id, :text, :approved)");

            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":text", $text);
            $stmt->bindParam(":approved", $approved);
            $stmt->execute();
            return $stmt;

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

        $text = $this->getText();

        try {

            $stmt = $conn->prepare("UPDATE feedbacks SET text=:text WHERE id=:id");
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":text", $text);
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
            $stmt = $conn->prepare("DELETE FROM feedbacks WHERE id=:id");
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

            $stmt = $conn->prepare("SELECT * FROM feedbacks WHERE id=:id");
            $stmt->bindParam(":id", $id);

            if ($stmt->rowCount()) {
                return $stmt;
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

    public static function all()
    {
        global $conn;

        try {

            $stmt = $conn->prepare("SELECT * FROM feedbacks WHERE approved=1");
            $stmt->execute();

            if ($stmt->rowCount()) {
                return $stmt;
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

    public static function approve($id)
    {
        global $conn;

        try {
            $stmt = $conn->prepare("UPDATE feedbacks SET approved=1 WHERE id=:id");
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

    public static function disapprove($id){
        global $conn;

        try {
            $stmt = $conn->prepare("UPDATE feedbacks SET approved=0 WHERE id=:id");
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

    public static function getTimeAgo($timestamp)
    {
        $timestamp = strtotime($timestamp);
        $cur_time = time();
        $time_elapsed = $cur_time - $timestamp;
        $seconds = $time_elapsed;
        $minutes = round($time_elapsed / 60);
        $hours = round($time_elapsed / 3600);
        $days = round($time_elapsed / 86400);
        $weeks = round($time_elapsed / 604800);
        $months = round($time_elapsed / 2600640);
        $years = round($time_elapsed / 31207680);
        // Seconds
        if ($seconds <= 60) {
            return  "just now";
        } //Minutes
        else if ($minutes <= 60) {
            if ($minutes == 1) {
                return "one minute ago";
            } else {
                return "$minutes minutes ago";
            }
        } //Hours
        else if ($hours <= 24) {
            if ($hours == 1) {
                return "an hour ago";
            } else {
                return "$hours hrs ago";
            }
        } //Days
        else if ($days <= 7) {
            if ($days == 1) {
                return "yesterday";
            } else {
                return "$days days ago";
            }
        } //Weeks
        else if ($weeks <= 4.3) {
            if ($weeks == 1) {
                return "a week ago";
            } else {
                return "$weeks weeks ago";
            }
        } //Months
        else if ($months <= 12) {
            if ($months == 1) {
                return "a month ago";
            } else {
                return "$months months ago";
            }
        } //Years
        else {
            if ($years == 1) {
                return "one year ago";
            } else {
                return "$years years ago";
            }
        }
    }
}

