<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/17/17
 * Time: 2:05 AM
 */

require_once __DIR__ . '/../models/class.limits.php';

if (is_array(Limit::getLimits())) {
    print_r(json_encode(Limit::getLimits()));
}
else{
    print_r(json_encode(array("error"=>"no limits set")));
}