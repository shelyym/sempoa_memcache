<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 1/19/18
 * Time: 8:52 AM
 */
class ParentSempoa extends Model
{
    var $table_name = "sempoa__app_parent";
    var $main_id = "parent_id";

    //Default Coloms for read
    public $default_read_coloms = "parent_id,parent_fullname,parent_email,parent_hp_nr,parent_kode_anak,parent_pwd,parent_created_date,parent_updated_date,parent_active,parent_last_login,parent_last_ip";

//allowed colom in CRUD filter
    public $coloumlist = "parent_id,parent_fullname,parent_email,parent_hp_nr,parent_kode_anak,parent_pwd,parent_created_date,parent_updated_date,parent_active,parent_last_login,parent_last_ip";
    public $parent_id;
    public $parent_fullname;
    public $parent_email;
    public $parent_hp_nr;
    public $parent_kode_anak;
    public $parent_pwd;
    public $parent_created_date;
    public $parent_updated_date;
    public $parent_active;
    public $parent_last_login;
    public $parent_last_ip;


    public function isEmailUsed($email){
        $this->getWhereOne("parent_email='$email'");
        if(is_null($this->parent_id)){
            return true;
        }
        else{
            return false;
        }
    }

    function setLastLogin($datetime){
        $this->parent_last_login = $datetime;
    }
}