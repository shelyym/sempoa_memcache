<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 4/7/16
 * Time: 7:18 PM
 */

class AppFree extends Model{

    var $table_name ="appear__app_free";
    var $main_id = "free_app_id";

    //Default Coloms for read
    public $default_read_coloms = "free_app_id,free_date,free_org_name,free_org_type,free_address,free_contact_name,free_contact_phone,free_contact_email,free_status";

//allowed colom in CRUD filter
    public $coloumlist = "free_app_id,free_date,free_org_docs,free_org_name,free_org_type,free_address,free_contact_name,free_contact_phone,free_contact_email,free_status";
    public $free_app_id;
    public $free_date;
    public $free_org_name;
    public $free_org_type;
    public $free_address;
    public $free_contact_name;
    public $free_contact_phone;
    public $free_contact_email;
    public $free_status;
    public $free_org_docs;
} 