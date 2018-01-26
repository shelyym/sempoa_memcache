<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 1/24/18
 * Time: 2:18 PM
 */
class ChallangeModel extends Model
{

    var $table_name = "sempoa__app_challange";
    var $main_id = "challange_id";

    //Default Coloms for read
    public $default_read_coloms = "challange_id,chllange_type,challange_title,challange_level,challange_date,challange_status,challange_murid_ikut,challange_created_date,challange_updated,challange_active,challange_ak,challange_kpo,challange_ibo,challange_tc";

//allowed colom in CRUD filter
    public $coloumlist = "challange_id,chllange_type,challange_title,challange_level,challange_date,challange_status,challange_murid_ikut,challange_created_date,challange_updated,challange_active,challange_ak,challange_kpo,challange_ibo,challange_tc";
    public $challange_id;
    public $chllange_type;
    public $challange_title;
    public $challange_level;
    public $challange_date;
    public $challange_status;
    public $challange_murid_ikut;
    public $challange_created_date;
    public $challange_updated;
    public $challange_active;
    public $challange_ak;
    public $challange_kpo;
    public $challange_ibo;
    public $challange_tc;
}