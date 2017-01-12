<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/24/16
 * Time: 7:47 PM
 */

class TypeCCategoryModel extends Model{

    var $table_name = "push__typeC_category";
    var $main_id = "cat_id";

    var $cat_id;
    var $cat_name;
    var $cat_pic;
    var $cat_order;
    var $cat_content_id;
    var $cat_app_id;


    //Default Coloms for read
    public $default_read_coloms = "cat_id,cat_name,cat_pic,cat_order,cat_content_id,cat_app_id,cat_hide";

//allowed colom in CRUD filter
    public $coloumlist = "cat_id,cat_name,cat_pic,cat_order,cat_content_id,cat_app_id,cat_hide";

    var $cat_hide;


} 