<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Group
 *
 * @author efindiongso
 */
class GroupsModel extends SempoaModel {

    //put your code here    
    var $table_name = "sempoa__group";
    var $main_id = "id_group";
//Default Coloms for read
    public $default_read_coloms = "id_group,nama,groups,type,parent_id,group_desc";
//allowed colom in CRUD filter
    public $coloumlist = "id_group,nama,groups,type,parent_id,group_desc";
    public $id_group;
    public $nama;
    public $groups;
    public $type;
    public $parent_id;
    public $group_desc;

    public function overwriteForm($return, $returnfull) {
//        Generic::getMyRoot();
        $return = parent::overwriteForm($return, $returnfull);
        $arrType = Generic::getTypeGroup();
        $myOrgID = AccessRight::getMyOrgID();
        if (AccessRight::getMyOrgType() == KEY::$KPO) {
            $return['type'] = new Leap\View\InputText("hidden", 'type', 'type', KEY::$IBO);
            $return['parent_id'] = new Leap\View\InputText("hidden", 'parent_id', 'parent_id', $myOrgID);
            $arrIBO = Generic::getAllsMyIBO(AccessRight::getMyOrgID());
            $label = implode(",", $arrIBO);
            $value = implode(",", array_keys($arrIBO));
            $return['groups'] = new Leap\View\InputFieldToken("text", 'groups', 'groups', $value, $label, $this->groups);
        
            
        } elseif (AccessRight::getMyOrgType() == KEY::$IBO) {
            $return['type'] = new Leap\View\InputText("hidden", 'type', 'type', KEY::$TC);
            $return['parent_id'] = new Leap\View\InputText("hidden", 'parent_id', 'parent_id', $myOrgID);
            $arrTC = Generic::getTCMemberRoy(AccessRight::getMyOrgID(),$this->id_group);
//            pr($arrTC);
//            if ( $this->groups !="") {
                $label = implode(",", $arrTC);
                $value = implode(",", array_keys($arrTC));
//                $arrValue = array();
//                $arrLabel = array();
//                $explode = explode(",", $this->groups);
//                foreach($explode as $id){
//                    $org = new SempoaOrg();
//                    $org->getByID($id);
//                    
//                    $arrValue[] = $id;
//                    $arrLabel[] = $org->nama;
//                }
//                pr($arrLabel); echo "halo";
                $return['groups'] = new Leap\View\InputFieldToken("text", 'groups', 'groups', $value, $label, $this->groups);
//            } else {
////                 $return['groups'] = new Leap\View\InputText("hidden", 'groups', 'groups', "");
//            }
           
            
//            $return['groups'] = new Leap\View\InputFieldToken("text", 'groups', 'groups', $value, $label, $this->groups);
//            $this->groups = $group_help;
        }
        $return['type']->setReadOnly();
        $return['parent_id']->setReadOnly();
        return $return;
    }
    
    public function overwriteForm2($return, $returnfull) {
//        Generic::getMyRoot();
        $return = parent::overwriteForm($return, $returnfull);
        $arrType = Generic::getTypeGroup();
        $myOrgID = AccessRight::getMyOrgID();
        if (AccessRight::getMyOrgType() == KEY::$KPO) {
            $return['type'] = new Leap\View\InputText("hidden", 'type', 'type', KEY::$IBO);
            $return['parent_id'] = new Leap\View\InputText("hidden", 'parent_id', 'parent_id', $myOrgID);
            $arrIBO = Generic::getAllsMyIBO(AccessRight::getMyOrgID());
            $label = implode(",", $arrIBO);
            $value = implode(",", array_keys($arrIBO));
            $return['groups'] = new Leap\View\InputFieldToken("text", 'groups', 'groups', $value, $label, $this->groups);
        
            
        } elseif (AccessRight::getMyOrgType() == KEY::$IBO) {
            $return['type'] = new Leap\View\InputText("hidden", 'type', 'type', KEY::$TC);
            $return['parent_id'] = new Leap\View\InputText("hidden", 'parent_id', 'parent_id', $myOrgID);
            $arrTC = Generic::getTCMember(AccessRight::getMyOrgID());
//            pr($arrTC);
//            if ( $this->groups !="") {
                $label = implode(",", $arrTC);
                $value = implode(",", array_keys($arrTC));
//                $arrValue = array();
//                $arrLabel = array();
//                $explode = explode(",", $this->groups);
//                foreach($explode as $id){
//                    $org = new SempoaOrg();
//                    $org->getByID($id);
//                    
//                    $arrValue[] = $id;
//                    $arrLabel[] = $org->nama;
//                }
//                pr($arrLabel); echo "halo";
                $return['groups'] = new Leap\View\InputFieldToken("text", 'groups', 'groups', $value, $label, $this->groups);
//            } else {
////                 $return['groups'] = new Leap\View\InputText("hidden", 'groups', 'groups', "");
//            }
           
            
//            $return['groups'] = new Leap\View\InputFieldToken("text", 'groups', 'groups', $value, $label, $this->groups);
//            $this->groups = $group_help;
        }
        $return['type']->setReadOnly();
        $return['parent_id']->setReadOnly();
        return $return;
    }

    public function constraints() {
        //err id => err msg
        $err = array();
//
//        if (!isset($this->nama)) {
//            $err['nama'] = Lang::t('Please provide Name');
//        }
//        if (!isset($this->groups)) {
//            $err['groups'] = Lang::t('Please provide groups');
//        }

        return $err;
    }

    public function overwriteRead($return) {
        $return = parent::overwriteRead($return);

        $objs = $return['objs'];
        foreach ($objs as $obj) {
            if($obj->groups != ""){
                $arrGroups =  explode(",", $obj->groups);
                $help = "";
                foreach ($arrGroups as $groups){
                    if($help == ""){
                        $help = Generic::getTCNamebyID($groups);
                    }
                    else{
                        $help = $help . ", " . Generic::getTCNamebyID($groups);
                    }
                }
                $obj->groups = $help;
            }
            
            if($obj->parent_id != ""){
                $obj->parent_id  = Generic::getTCNamebyID($obj->parent_id);
            }
                
        }
        return $return;
    }

    public function onSaveSuccess($id) {

        $exp = explode(",", $this->groups);
        $grl = new GroupRelModel();
        global $db;
        $q = "DELETE FROM {$grl->table_name} WHERE rel_group_id = '$id'";
        $db->query($q, 0);

        foreach ($exp as $org_id) {
            $grl = new GroupRelModel();
            $grl->rel_group_id = $id;
            $grl->rel_org_id = $org_id;
            $grl->save(1);
        }
    }

}
