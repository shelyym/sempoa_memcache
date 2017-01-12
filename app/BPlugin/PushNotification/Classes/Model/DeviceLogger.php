<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/19/15
 * Time: 10:53 AM
 */

class DeviceLogger extends Model{
    //Nama Table
    public $table_name = "push__device_logger";

    //Primary
    public $main_id = 'log_id';
    public $log_id;
    public $log_acc_id;
    public $log_app_id;
    public $log_date;

    public $log_dev_id;
    public $log_dev_type;

    public $log_lng;
    public $log_lat;

    public $log_page_id;

    //Default Coloms for read
    public $default_read_coloms = "log_id,log_acc_id,log_app_id,log_date,log_dev_id,log_dev_type,log_lng,log_lat,log_page_id";

//allowed colom in CRUD filter
    public $coloumlist = "log_id,log_acc_id,log_app_id,log_date,log_dev_id,log_dev_type,log_lng,log_lat,log_page_id";

} 