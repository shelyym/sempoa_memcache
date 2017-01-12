<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/17/16
 * Time: 1:42 PM
 */

class DraftModel extends Model{

    var $table_name = "sp__draft";
    var $main_id = "draft_id";



    public $draft_id;
    public $draft_app_id;
    public $draft_obj;
    public $draft_date;
    public $draft_type;

    //Default Coloms
    var $default_read_coloms = "draft_id,draft_app_id,draft_obj,draft_date,draft_type";

    var $coloumlist = "draft_id,draft_app_id,draft_obj,draft_date,draft_type";

    var $crud_webservice_allowed = "draft_id,draft_app_id,draft_obj,draft_date,draft_type";

} 