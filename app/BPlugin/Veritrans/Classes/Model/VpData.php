<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 2/17/16
 * Time: 1:47 PM
 */

class VpData extends Model{

    //
    var $table_name = "vp__data";
    var $main_id    = "vp_id";

    //Default Coloms for read
    public $default_read_coloms = "vp_id,vp_date,vp_obj,status_code,status_message,transaction_id,masked_card,order_id,gross_amount,payment_type,transaction_time,transaction_status,fraud_status,approval_code,signature_key,bank,eci";

//allowed colom in CRUD filter
    public $coloumlist = "vp_id,vp_date,vp_obj,status_code,status_message,transaction_id,masked_card,order_id,gross_amount,payment_type,transaction_time,transaction_status,fraud_status,approval_code,signature_key,bank,eci";
    public $vp_id;
    public $vp_date;
    public $vp_obj;
    public $status_code;
    public $status_message;
    public $transaction_id;
    public $masked_card;
    public $order_id;
    public $gross_amount;
    public $payment_type;
    public $transaction_time;
    public $transaction_status;
    public $fraud_status;
    public $approval_code;
    public $signature_key;
    public $bank;
    public $eci;

} 