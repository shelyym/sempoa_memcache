<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Role2Account
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class Role2Account extends Model {
    public $table_name = "sp_role2account";
    public $main_id    = "rc_id";
    //Default Coloms
    public $default_read_coloms = 'rc_id,role_id,role_admin_id';

    public $rc_id;
    public $account_username;
    public $role_id;
    public $role_admin_id;
    
    public $coloumlist = 'rc_id,role_id,role_admin_id';
    /*
     * @return array of roles
     */
    public function getRoles ($id)
    {
        global $db;
        $sql = "SELECT * FROM {$this->table_name} WHERE role_admin_id = '{$id}'";

        return $db->query($sql, 2);
    }
    public function overwriteRead ($return)
    {
        $return = parent::overwriteRead($return);
        
        $objs = $return['objs'];
        foreach ($objs as $obj) {
            if (isset($obj->role_admin_id)) {
                $acc = new Account();
                $acc->getByID($obj->role_admin_id);
                $obj->role_admin_id = $acc->admin_nama_depan;
            }
        }
        return $return;
    }
    public function overwriteForm($return,$returnfull){
        $r = new Role();
        $arr = $r->getAll();
        foreach($arr as $rol){
            if($rol->role_active)
            $arrNew[$rol->role_id] = $rol->role_id;
        }
        $acc = new Account();
        $acc->default_read_coloms = "admin_id,admin_nama_depan,admin_aktiv";
        $arr = $acc->getAll();
        foreach($arr as $ac){
            if($ac->admin_aktiv)
            $arrNew2[$ac->admin_id] = $ac->admin_id." - ".$ac->admin_nama_depan;
        }
        $return['role_admin_id']= new Leap\View\InputSelect($arrNew2,"role_admin_id", "role_admin_id",$this->role_admin_id);            
        $return['role_id'] = new Leap\View\InputSelect($arrNew,"role_id", "role_id",$this->role_id);
        $return['account_username'] = new Leap\View\InputText("hidden","account_username", "account_username",$this->account_username);
        return $return;
    }
}
