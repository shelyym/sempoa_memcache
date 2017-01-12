<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/20/16
 * Time: 11:42 AM
 */

class TypeAModel extends Model{

    var $table_name = "push__typeAmodel";
    var $main_id = "a_id";

    //Default Coloms for read
    public $default_read_coloms = "a_id,a_title,a_msg,a_carousel,a_app_id,a_update_date,a_posting_date,a_video,a_map,a_action,a_price,a_payment_gateway,a_order,a_hide,a_header_type";

//allowed colom in CRUD filter
    public $coloumlist = "a_id,a_title,a_msg,a_carousel,a_app_id,a_update_date,a_posting_date,a_video,a_map,a_action,a_price,a_payment_gateway,a_content_id,a_category,a_order,a_hide,a_header_type";
    public $a_id;
    public $a_title;
    public $a_msg;
    public $a_carousel;
    public $a_app_id;
    public $a_update_date;
    public $a_posting_date;
    public $a_video;
    public $a_map;
    public $a_action;
    public $a_price;
    public $a_payment_gateway;
    public $a_content_id;
    public $a_category;
    public $a_order;

    var $a_hide;
    var $a_header_type;

    var $crud_webservice_allowed = "a_id,a_msg,a_update_date,a_posting_date,a_video,a_map,a_action,a_price,a_order,a_hide,a_header_type";

} 