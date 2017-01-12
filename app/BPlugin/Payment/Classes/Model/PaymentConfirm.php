<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/22/15
 * Time: 3:09 PM
 */

class PaymentConfirm extends Model{

    //ppconfirm
    var $table_name = "ppconfirm";
    var $main_id    = "confirm_id";

    //Default Coloms for read
    public $default_read_coloms = "confirm_id,confirm_date,confirm_create_date,confirm_app_id,confirm_user_id,confirm_name,confirm_bank,confirm_amount,confirm_receipt,confirm_status,confirm_status_changed,confirm_status_change_by";

//allowed colom in CRUD filter
    public $coloumlist = "confirm_id,confirm_date,confirm_create_date,confirm_app_id,confirm_user_id,confirm_name,confirm_bank,confirm_amount,confirm_receipt,confirm_status,confirm_status_changed,confirm_status_change_by";
    public $confirm_id;
    public $confirm_date;
    public $confirm_create_date;
    public $confirm_app_id;
    public $confirm_user_id;
    public $confirm_name;
    public $confirm_bank;
    public $confirm_amount;
    public $confirm_receipt;
    public $confirm_status;
    public $confirm_status_changed;
    public $confirm_status_change_by;
} 