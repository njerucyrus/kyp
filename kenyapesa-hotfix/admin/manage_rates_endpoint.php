<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/19/17
 * Time: 5:01 PM
 */

require_once __DIR__ . '/../models/class.rate.php';
require_once __DIR__ . '/../models/class.limits.php';


$option = $_POST['option'];

switch ($option) {
    case 'create_rates':
        createRate();
        break;
    case 'update_rates':
        updateRate();
        break;
    case 'delete_rates':
        deleteRate();
        break;
    case 'create_limit':
        createLimit();
        break;

    case 'update_limits':
        updateLimit();
        break;
}

function createRate()
{
    if (isset($_POST['min']) and
        isset($_POST['max']) and
        isset($_POST['fixed']) and
        isset($_POST['percentage'])
    ) {
        $min = $_POST['min'];
        $max = $_POST['max'];
        $fixed = $_POST['fixed'];
        $percentage = $_POST['percentage'];

        //create instance of rate class
        $rate = new Rate();
        //set properties using setter methods
        $rate->setMinValue($min);
        $rate->setMaxValue($max);
        $rate->setFixedDollar($fixed);
        $rate->setPercentage($percentage);

        //save the new reate to the database by calling create method
        $created = $rate->create();

        if ($created) {
            print_r(json_encode(array(
                "statusCode" => 200,
                "message" => "Rates saved successfully"
            )));
        } else {
            print_r(json_encode(array(
                "statusCode" => 500,
                "message" => "Error occurred"
            )));
        }

    } else {
        print_r(json_encode(array(
            "statusCode" => 500,
            "message" => "data not set"
        )));
    }
}

function updateRate()
{
    if (isset($_POST['id']) and
        isset($_POST['min']) and
        isset($_POST['max']) and
        isset($_POST['fixed']) and
        isset($_POST['percentage'])
    ) {
        $id = $_POST['id'];
        $min = $_POST['min'];
        $max = $_POST['max'];
        $fixed = $_POST['fixed'];
        $percentage = $_POST['percentage'];

        //create instance of rate class
        $rate = new Rate();
        //set properties using setter methods
        $rate->setMinValue($min);
        $rate->setMaxValue($max);
        $rate->setFixedDollar($fixed);
        $rate->setPercentage($percentage);

        //update the values in the database by calling public method update
        $updated = $rate->update($id);

        if ($updated) {
            print_r(json_encode(array(
                "statusCode" => 200,
                "message" => "Rates updated successfully"
            )));
        } else {
            print_r(json_encode(array(
                "statusCode" => 500,
                "message" => "error occurred"
            )));
        }


    } else {
        print_r(json_encode(array(
            "statusCode" => 500,
            "message" => "data not set"
        )));
    }
}

function deleteRate()
{
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $deleted = Rate::delete($id);

        if ($deleted) {
            print_r(json_encode(array(
                "statusCode" => 200,
                "message" => "Rate Deleted successfully"
            )));
        } else {
            print_r(json_encode(array(
                "statusCode" => 500,
                "message" => "error occurred"
            )));
        }

    } else {
        print_r(json_encode(array(
            "statusCode" => 500,
            "message" => "data not set"
        )));
    }

}


function createLimit()
{
    if (isset($_POST['min_limit']) and
        isset($_POST['max_limit']) and
        isset($_POST['exchange_rate'])
    ) {

        $min_limit = $_POST['min_limit'];
        $max_limit = $_POST['max_limit'];
        $exchange_rate = $_POST['exchange_rate'];

        $limit = new Limit();
        $limit->setMinLimit($min_limit);
        $limit->setMaxLimit($max_limit);
        $limit->setExchangeRate($exchange_rate);

        $created = $limit->create();

        if ($created) {
            print_r(json_encode(array(
                "statusCode" => 200,
                "message" => "Limits saved successfully"
            )));
        } else {
            print_r(json_encode(array(
                "statusCode" => 500,
                "message" => "error occurred"
            )));
        }

    } else {
        print_r(json_encode(array(
            "statusCode" => 500,
            "message" => "data not set"
        )));
    }
}

function updateLimit()
{

    if (isset($_POST['id']) and
        isset($_POST['min_limit']) and
        isset($_POST['max_limit']) and
        isset($_POST['exchange_rate'])
    ) {

        $id = $_POST['id'];
        $min_limit = $_POST['min_limit'];
        $max_limit = $_POST['max_limit'];
        $exchange_rate = $_POST['exchange_rate'];

        $limit = new Limit();
        $limit->setMinLimit($min_limit);
        $limit->setMaxLimit($max_limit);
        $limit->setExchangeRate($exchange_rate);

        $updated = $limit->update($id);

        if ($updated) {
            print_r(json_encode(array(
                "statusCode" => 200,
                "message" => "Limits Updated successfully"
            )));
        } else {
            print_r(json_encode(array(
                "statusCode" => 500,
                "message" => "error occurred"
            )));
        }

    } else {
        print_r(json_encode(array(
            "statusCode" => 500,
            "message" => "data not set"
        )));
    }
}



