<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/19/15
 * Time: 10:51 AM
 */

class LL_AccountLogger extends Model{
    //Nama Table
    public $table_name = "ll__account_logger";

    //Primary
    public $main_id = 'log_id';
    public $log_id;
    public $log_acc_id;
    public $log_date;
    //Default Coloms for read
    public $default_read_coloms = "log_id,log_acc_id,log_date";

//allowed colom in CRUD filter
    public $coloumlist = "log_id,log_acc_id,log_date";

} 