<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/31/15
 * Time: 10:27 AM
 */

class PushLoggerAgentApp extends Model{

    public $table_name = "agent__pushnot_logger";

    //Primary
    public $main_id = 'log_id';

    //Default Coloms for read
    public $default_read_coloms = 'log_id,log_camp_id,log_macc_id,log_status,log_date,log_text';

    //allowed colom in CRUD filter
    public $coloumlist = 'log_id,log_camp_id,log_device_id,log_macc_id,log_status,log_date,log_text,log_multicast_id,log_client_id,log_seen,log_seen_date,log_app_id,log_active';

    public $log_id;
    public $log_camp_id;
    public $log_device_id;
    public $log_macc_id;
    public $log_status;
    public $log_date;
    public $log_text;
    public $log_multicast_id;

    public $log_seen;
    public $log_seen_date;

    public $log_client_id;
    public $log_app_id;

    public $log_active;


    //allowed colom in CRUD filter
    public $exportList = 'log_id,log_camp_id,log_device_id,log_macc_id,log_status,log_date,log_text,log_multicast_id,log_client_id,log_seen,log_seen_date,log_app_id,log_active';



    static function savelog($camp_id,$device_id,$acc_id,$status,$log_text,$log_multicast_id){

        $nl = new PushLoggerCaps();
        $nl->log_camp_id = $camp_id;
        $nl->log_device_id = $device_id;
        $nl->log_macc_id = $acc_id;

        $nl->log_status = $status;
        $nl->log_text = $log_text;
        $nl->log_multicast_id = $log_multicast_id;
        $nl->log_date = leap_mysqldate();
        $nl->log_active = 1;

//        $nl->log_app_id = $log_app_id;
//        $nl->log_client_id = $client_camp_id;
        return $nl->save();

    }
}