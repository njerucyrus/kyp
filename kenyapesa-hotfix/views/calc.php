<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/16/17
 * Time: 11:49 PM
 */

require_once __DIR__ . '/../models/class.calculator.php';

$value = $_POST['value'];

$calc = new PesaCalc();

$float_val = (float)$value;
$amount = $calc->calculate($float_val);

print_r(json_encode(array(
    'amount' => $amount
)));
