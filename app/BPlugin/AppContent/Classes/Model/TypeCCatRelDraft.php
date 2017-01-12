<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/25/16
 * Time: 9:34 AM
 */

class TypeCCatRelDraft extends Model{

    var $table_name = "push__typeC_category_relationdraft";
    var $main_id = "rel_id";
    var $rel_id;
    var $rel_a_id;
    var $rel_cat_id;
    var $rel_content_id;




//Default Coloms for read
    public $default_read_coloms = "rel_id,rel_a_id,rel_cat_id,rel_content_id";

//allowed colom in CRUD filter
    public $coloumlist = "rel_id,rel_a_id,rel_cat_id,rel_content_id";

    var $crud_webservice_allowed = "a_id,a_title,a_msg,a_carousel,a_app_id,a_update_date,a_posting_date,a_video,a_map,a_action,a_price,a_payment_gateway,a_content_id,a_category,a_order,a_hide";
} 