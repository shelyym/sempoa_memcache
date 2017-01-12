<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/21/15
 * Time: 9:07 AM
 */

class DeviceModelCapsule extends Model{

    public $table_name = "push__device_capsule";

    //Primary
    public $main_id = 'did';

    //Default Coloms for read
    public $default_read_coloms = 'did,device_id,dev_app_id,device_type,acc_id,logindate,firstlogin,dev_lng,dev_lat';

    //allowed colom in CRUD filter
    public $coloumlist = 'did,device_id,dev_app_id,device_type,acc_id,logindate,firstlogin,dev_lng,dev_lat,dev_not_send';

    public $did;
    public $device_id;
    public $device_type;
    public $acc_id;
    public $firstlogin;
    public $logindate;
    public $dev_app_id;
    public $dev_lng;
    public $dev_lat;
    public $dev_not_send;

} 