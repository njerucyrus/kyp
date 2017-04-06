<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/19/17
 * Time: 7:25 AM
 */

require_once __DIR__ . '/../db/class.db.php';

trait ComplexQuery
{

    /**
     * @param $table = database table
     * @param $fields = array table columns
     * @param $options = array($key=>$value), $key is the
     * name of table column this parameter is used for
     * constriction of the sql query condition
     * @return null|PDOStatement
     * key meta in options takes values of ASC OR DESC
     * This specifies the type of ordering.
     * order_by key is an array of columns used to order your
     * results eg order_by =>array("column1", column2")
     */
    public static function customFilter($table, $fields, $options)
    {
        global $conn;

        $order_by = '';
        $limit = '';
        $meta = '';

        if (array_key_exists("order_by", $options)) {

            $order_by_array = $options['order_by'];
            $order_by = rtrim(implode(' ,', $order_by_array), ',');
        }
        if (array_key_exists("limit", $options)) {
            $limit = $options['limit'];

        }

        if (array_key_exists("meta", $options)) {
            $meta = $options['meta'];

        }

        unset($options['order_by']);
        unset($options['limit']);
        unset($options['meta']);

        if (is_array($fields) and is_array($options)) {


            $new_options_array = array();
            foreach ($options as $key => $value) {
                $option = $key . "='" . $value . "'";
                array_push($new_options_array, $option);
            }
            if (empty($options)) {
                $sql_condition_string = 1;
            } else {
                $order_by_string = '';
                $limit_string = '';
                if($order_by != ''){
                    $order_by_string = 'ORDER BY '.$order_by;
                }

                if($limit != ''){
                    $limit_string = 'LIMIT '.$limit;
                }

                $extras = $order_by_string." ". "".$meta." ". $limit_string;

                $sql_condition_string = rtrim(implode(' AND ', $new_options_array), ',');
                $sql_condition_string .= " ".$extras;

            }
            $fields = empty($fields) ? '*' : rtrim(implode(',', $fields), ',');


            try {

                $stmt = $conn->prepare("SELECT $fields FROM $table WHERE $sql_condition_string");

                $stmt->execute();

                return $stmt->rowCount() > 0 ? $stmt : null;

            } catch (PDOException $e) {
                print_r(json_encode(array(
                    'statusCode' => 500,
                    'message' => "Error " . $e->getMessage()
                )));
                return null;
            }

        } else {
            return null;
        }

    }

}

