<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/29/16
 * Time: 11:09 PM
 */

class EmailLog extends Model{

    var $table_name = "appear__email_logger";
    var $main_id = "log_id";

///Default Coloms for read
    public $default_read_coloms = "log_id,log_email_id,log_date,log_status,log_template";

//allowed colom in CRUD filter
    public $coloumlist = "log_id,log_email_id,log_date,log_status,log_template";
    public $log_id;
    public $log_email_id;
    public $log_date;
    public $log_status;
    public $log_template;
} 