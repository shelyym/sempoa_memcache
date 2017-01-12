<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/25/16
 * Time: 9:32 AM
 */

class TypeCCatRel extends Model{

    var $table_name = "push__typeC_category_relation";
    var $main_id = "rel_id";
    var $rel_id;
    var $rel_a_id;
    var $rel_cat_id;
    var $rel_content_id;




//Default Coloms for read
    public $default_read_coloms = "rel_id,rel_a_id,rel_cat_id,rel_content_id";

//allowed colom in CRUD filter
    public $coloumlist = "rel_id,rel_a_id,rel_cat_id,rel_content_id";
} 