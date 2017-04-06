<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 3/15/17
 * Time: 11:29 AM
 */
require_once 'class.rate.php';
require_once 'class.limits.php';
class PesaCalc extends Rate {

    public static function calculate($userDollar){
       $rate = Rate::getRate($userDollar);
       $exchange_rate = Limit::getCurrentExchangeRate();

       if (is_array($rate) and is_array($exchange_rate)){
           $percentage = (float)$rate['percentage'];
           $fixed = (float)$rate['fixed'];
           $dollar_rate = (float)$exchange_rate['exchange_rate'];

           $gross_ksh= (float)($userDollar-$fixed -($userDollar* ($percentage/100)));


           $net_ksh = (int)($gross_ksh * $dollar_rate);

           return $net_ksh;



       }
       else {

           return null;
       }
    }
}