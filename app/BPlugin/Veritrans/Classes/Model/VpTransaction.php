<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/27/16
 * Time: 4:31 PM
 */

class VpTransaction extends Model{

    var $table_name = "vp__transaction";
    var $main_id    = "order_id";

    //Default Coloms for read
    public $default_read_coloms = "order_id,order_app_id,order_acc_id,order_date,order_value,order_paket_id,order_status";

//allowed colom in CRUD filter
    public $coloumlist = "order_id,order_app_id,order_acc_id,order_date,order_value,order_paket_id,order_status,order_message,order_status_from";
    public $order_id;
    public $order_app_id;
    public $order_acc_id;
    public $order_date;
    public $order_value;
    public $order_paket_id;
    public $order_status; //1 settlement //2 success //3 challenge //4 pending //5 deny // 6 cancel //order //see VP/handling
    public $order_message;
    public $order_status_from;
} 