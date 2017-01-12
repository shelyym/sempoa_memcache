<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingWeb5Model
 *
 * @author efindiongso
 */
class SettingWeb5Model extends SempoaModel {

    var $table_name = "sempoa__level_murid";
    var $main_id = "id_level_murid";
    //Default Coloms for read
    public $default_read_coloms = "id_level_murid,level_murid,level_murid_desc,ak_id,kpo_id,ibo_id,tc_id";
//allowed colom in CRUD filter
    public $coloumlist = "id_level_murid,level_murid,level_murid_desc,ak_id,kpo_id,ibo_id,tc_id";
    public $id_level_murid;
    public $level_murid;
    public $level_murid_desc;
    public $ak_id;
    public $kpo_id;
    public $ibo_id;
    public $tc_id;

    public function overwriteForm($return, $returnfull) {

        $myOrgID = AccessRight::getMyOrgID();
        $return = parent::overwriteForm($return, $returnfull);

        if (AccessRight::getMyOrgType() == KEY::$AK) {
            
        } elseif (AccessRight::getMyOrgType() == KEY::$KPO) {
            $myParentID = Generic::getMyParentID($myOrgID);
            $return['ak_id'] = new \Leap\View\InputText("text", 'ak_id', 'ak_id', $myParentID);
            $return['kpo_id'] = new \Leap\View\InputText("text", 'kpo_id', 'kpo_id', $myOrgID);
            $return['ak_id']->setReadOnly();
            $return['kpo_id']->setReadOnly();
            $return['ibo_id']->setReadOnly();
            $return['tc_id']->setReadOnly();
        } elseif (AccessRight::getMyOrgType() == KEY::$IBO) {

            $myParentID = Generic::getMyParentID($myOrgID);
            $myGrandParentID = Generic::getMyParentID($myParentID);
            $return['ak_id'] = new \Leap\View\InputText("text", 'ak_id', 'ak_id', $myGrandParentID);
            $return['kpo_id'] = new \Leap\View\InputText("text", 'kpo_id', 'kpo_id', $myParentID);
            $return['ibo_id'] = new \Leap\View\InputText("text", 'ibo_id', 'ibo_id', $myOrgID);
            $return['ak_id']->setReadOnly();
            $return['kpo_id']->setReadOnly();
            $return['ibo_id']->setReadOnly();
            $return['tc_id']->setReadOnly();
        } elseif (AccessRight::getMyOrgType() == KEY::$TC) {

            $myParentID = Generic::getMyParentID($myOrgID);
            $myGrandParentID = Generic::getMyParentID($myParentID);
            $myGrandGrandParentID = Generic::getMyParentID($myGrandParentID);
            $return['ak_id'] = new \Leap\View\InputText("text", 'ak_id', 'ak_id', $myGrandGrandParentID);
            $return['kpo_id'] = new \Leap\View\InputText("text", 'kpo_id', 'kpo_id', $myGrandParentID);
            $return['ibo_id'] = new \Leap\View\InputText("text", 'ibo_id', 'ibo_id', $myParentID);
            $return['tc_id'] = new \Leap\View\InputText("text", 'tc_id', 'tc_id', $myOrgID);
            $return['ak_id']->setReadOnly();
            $return['kpo_id']->setReadOnly();
            $return['ibo_id']->setReadOnly();
            $return['tc_id']->setReadOnly();
        }
        return $return;
    }

    public function constraints() {
        //err id => err msg
        $err = array();
        if (!isset($this->level_murid)) {
            $err['level_murid'] = Lang::t('Please provide level murid');
        }
        return $err;
    }

}
