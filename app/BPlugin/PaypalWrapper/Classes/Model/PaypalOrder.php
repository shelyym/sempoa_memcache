<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/22/15
 * Time: 1:23 PM
 */

class PaypalOrder extends Model {

//pporders
//my table name
    var $table_name = "pporders";
    var $main_id    = "order_id";

    var $default_read_coloms = "order_id,user_id,payment_id,state,amount,description,created_time,currency";

    var $order_id;
    //var	$set_name;
    var $user_id;
    var $payment_id;
    var $state;
    var $amount;
    var $description;
    var $created_time;
    var $currency;
    var $payment_type;

    var $coloumlist = "order_id,user_id,payment_id,state,amount,description,created_time,currency,payment_type";
} 