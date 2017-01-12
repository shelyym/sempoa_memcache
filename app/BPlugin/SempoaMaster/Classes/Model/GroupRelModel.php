<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/31/16
 * Time: 2:03 PM
 */

class GroupRelModel extends Model{
    var $table_name = "sempoa__group_relation";
    var $main_id = "rel_org_id";
    var $rel_org_id;

    var $rel_group_id;

    //Default Coloms for read
    public $default_read_coloms = "rel_org_id,rel_group_id";

    //allowed colom in CRUD filter
    public $coloumlist = "rel_org_id,rel_group_id";


} 