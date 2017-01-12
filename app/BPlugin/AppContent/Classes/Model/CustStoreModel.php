<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/26/16
 * Time: 10:04 AM
 */

class CustStoreModel extends Model{

    var $table_name = "push__store";
    var $main_id = "store_id";

///Default Coloms for read
    public $default_read_coloms = "store_id,store_name,store_descr,email,phone,address,latitude,longitude,store_aktif,opening_hour,store_content_id,store_app_id";

//allowed colom in CRUD filter
    public $coloumlist = "store_id,store_name,store_descr,email,phone,address,latitude,longitude,store_aktif,opening_hour,store_content_id,store_app_id";
    public $store_id;
    public $store_name;
    public $email;
    public $phone;
    public $address;
    public $latitude;
    public $longitude;
    public $store_aktif;
    public $opening_hour;
    public $store_content_id;
    public $store_app_id;

    public $store_descr;
    var $crud_webservice_allowed = "store_id,store_name,store_descr,email,phone,address,latitude,longitude,store_aktif,opening_hour,store_content_id,store_app_id";
} 