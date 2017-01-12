<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/20/16
 * Time: 11:27 PM
 */

class AccessRight2Role extends Model{

    var $table_name = "sp_accessright_matrix";
    var $main_id = "mat_id";

    //Default Coloms for read
    public $default_read_coloms = "mat_id,mat_role_id,mat_ar_id,mat_active";

//allowed colom in CRUD filter
    public $coloumlist = "mat_id,mat_role_id,mat_ar_id,mat_active";
    public $mat_id;
    public $mat_role_id;
    public $mat_ar_id;
    public $mat_active;
} 