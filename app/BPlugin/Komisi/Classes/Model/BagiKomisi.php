<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/29/16
 * Time: 2:27 PM
 */

class BagiKomisi extends Model{

    var $table_name = "vp__bagi_komisi";
    var $main_id = "bagi_id";

//Default Coloms for read
    public $default_read_coloms = "bagi_id,bagi_bk_id,bagi_acc_id,bagi_date_acquire,bagi_date_withdraw,bagi_status,bagi_value";

//allowed colom in CRUD filter
    public $coloumlist = "bagi_id,bagi_bk_id,bagi_acc_id,bagi_date_acquire,bagi_date_withdraw,bagi_status,bagi_value";
    public $bagi_id;
    public $bagi_bk_id;
    public $bagi_acc_id;
    public $bagi_date_acquire;
    public $bagi_date_withdraw;
    public $bagi_status;
    public $bagi_value;

} 